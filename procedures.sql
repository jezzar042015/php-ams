SELECT accountid, legalname from accounts where legalname like '%right time%';

select policyid, policynumber, coveragetype,
	if(expiration > current_date,'active','expired') status
from policies where accountid = 36
order by status, coveragetype;


DELIMITER //

CREATE PROCEDURE GetAccountActiveRatedCoverages (IN _accountid INT)

BEGIN
	SELECT policyid, policynumber, coveragetype 
	FROM policies 
	WHERE accountid = _accountid
		AND (premium IS NULL 
					AND (baseperunit > 0 
							OR PDRate > 0 
							OR trailerrate > 0 
							OR not_rate > 0 
							OR ti_rate > 0))
		AND (expiration >= current_date);
END //

DELIMITER ;

SELECT policyid, policynumber, coveragetype 
FROM policies 
WHERE accountid = 39
	AND (premium IS NULL 
				AND (baseperunit > 0 
						OR PDRate > 0 
                        OR trailerrate > 0 
                        OR not_rate > 0 
                        OR ti_rate > 0))
	AND (expiration >= current_date);

select * from policies where accountid = 35; 
    
CALL GetAccountActiveRatedCoverages (150);


USE ams;

DELIMITER //

CREATE PROCEDURE GetAccountGroupedEndorsements ( IN _accountid INT)

BEGIN
	SELECT
	effective, 
    -- stage, endt_action,  
    (case
		when endt_action = 1 then 'ADD' 
        when endt_action = -1 then 'DELETE' 
    end) AS action_name, 
    -- endt_type, 
    endt_description, 
    -- eg.vehicleid, eg.driverid, 
    vehicle_year, makename, vin, 
    
    if(endt_type IN (1,2,3), pdvalue,null) as pdvalue,
    
    (SELECT SUM(surcharge) FROM endorsements 
    WHERE effective = eg.effective AND endt_action = eg.endt_action 
		AND endt_type = eg.endt_type AND accountid = eg.accountid 
        AND vehicleid = eg.vehicleid AND driverid = eg.driverid) AS surcharge,
        
	(SELECT SUM(ifnull(premium,0) + ifnull(surplusline_tax,0)) FROM endorsements 
    WHERE effective = eg.effective AND endt_action = eg.endt_action 
		AND endt_type = eg.endt_type AND accountid = eg.accountid 
        AND (vehicleid = eg.vehicleid OR driverid = eg.driverid) 
        AND coveragetypes = 1) AS al_premium, 

	(SELECT SUM(ifnull(premium,0) + ifnull(surplusline_tax,0)) FROM endorsements 
    WHERE effective = eg.effective AND endt_action = eg.endt_action 
		AND endt_type = eg.endt_type AND accountid = eg.accountid 
        AND (vehicleid = eg.vehicleid OR driverid = eg.driverid) 
        AND coveragetypes = 2) AS mtc_premium,
        
	(SELECT SUM(ifnull(premium,0) + ifnull(surplusline_tax,0)) FROM endorsements 
    WHERE effective = eg.effective AND endt_action = eg.endt_action 
		AND endt_type = eg.endt_type AND accountid = eg.accountid 
        AND (vehicleid = eg.vehicleid OR driverid = eg.driverid) 
        AND coveragetypes = 3) AS pd_premium,
	
    (SELECT SUM(brokerfees) FROM endorsements 
    WHERE effective = eg.effective AND endt_action = eg.endt_action 
		AND endt_type = eg.endt_type AND accountid = eg.accountid 
        AND (vehicleid = eg.vehicleid OR driverid = eg.driverid)) AS brokerfees,

    (SELECT SUM(endtfees) FROM endorsements 
    WHERE effective = eg.effective AND endt_action = eg.endt_action 
		AND endt_type = eg.endt_type AND accountid = eg.accountid 
        AND (vehicleid = eg.vehicleid OR driverid = eg.driverid)) AS endtfees,        

    (SELECT SUM(ifnull(otherfees,0) + ifnull(duesperunit_nontaxed,0) + ifnull(duesperunit_taxed,0)) FROM endorsements 
    WHERE effective = eg.effective AND endt_action = eg.endt_action 
		AND endt_type = eg.endt_type AND accountid = eg.accountid 
        AND (vehicleid = eg.vehicleid OR driverid = eg.driverid)) AS otherfees,

    (SELECT SUM(totalpremium) FROM endorsements 
    WHERE effective = eg.effective AND endt_action = eg.endt_action 
		AND endt_type = eg.endt_type AND accountid = eg.accountid 
        AND (vehicleid = eg.vehicleid OR driverid = eg.driverid)) AS totalpremium,
        
	(SELECT endt_status FROM endorsements 
    WHERE effective = eg.effective AND endt_action = eg.endt_action 
		AND endt_type = eg.endt_type AND accountid = eg.accountid 
        AND (vehicleid = eg.vehicleid OR driverid = eg.driverid) 
        AND coveragetypes = 1) AS al_status,

	(SELECT endt_status FROM endorsements 
    WHERE effective = eg.effective AND endt_action = eg.endt_action 
		AND endt_type = eg.endt_type AND accountid = eg.accountid 
        AND (vehicleid = eg.vehicleid OR driverid = eg.driverid) 
        AND coveragetypes = 2) AS mtc_status,        
        
	(SELECT endt_status FROM endorsements 
    WHERE effective = eg.effective AND endt_action = eg.endt_action 
		AND endt_type = eg.endt_type AND accountid = eg.accountid 
        AND (vehicleid = eg.vehicleid OR driverid = eg.driverid) 
        AND coveragetypes = 3) AS pd_status
        
FROM ((SELECT 
		MAX(effective) as effective, 
        MAX(endt_action) as endt_action, 
        MAX(endt_type) as endt_type, 
        MAX(vehicleid) as vehicleid, 
        MAX(driverid) as driverid,
        MAX(endt_description) as endt_description,
        MAX(stage) as stage,
        MAX(accountid) as accountid
		-- CONCAT(MAX(effective),'|',MAX(endt_action),'|',MAX(endt_type),'|',(IFNULL(MAX(driverid),0) + IFNULL(MAX(vehicleid),0)),'|',MAX(accountid)) AS lineID,
FROM endorsements
WHERE accountid = _accountid 
GROUP BY CONCAT(effective,'|',endt_action,'|',endt_type,'|',(IFNULL(driverid,0) + IFNULL(vehicleid,0)),'|',accountid)
ORDER BY effective DESC, stage DESC, endt_type) AS eg 
	LEFT JOIN vehicles AS v ON eg.vehicleid = v.vehicleid) 
    LEFT JOIN vehiclemakes AS vm ON v.makeid = vm.makeid;
END //

DELIMITER ;


