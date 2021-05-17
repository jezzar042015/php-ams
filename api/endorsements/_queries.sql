

DROP TABLE endorsements;

CREATE TABLE IF NOT EXISTS endorsements (
    endtid INT NOT NULL AUTO_INCREMENT,
    endt_status TINYINT NOT NULL,
    policyid INT NOT NULL,
    effective DATE NOT NULL, 
    accountid INT NOT NULL,
    endt_action TINYINT NOT NULL,
    endt_type TINYINT NOT NULL,
    stage TINYINT NOT NULL,
    endt_description VARCHAR (256) NULL,
    insured_address VARCHAR (256) NULL,
    driverid INT NULL,
    vehicleid INT NULL,
    pro_rate DECIMAL (5,4) NULL,
    pdvalue DECIMAL (10,2) NULL,
    coveragetypes TINYINT NOT NULL,
    baseperunit DECIMAL (12,4) NULL,
    duesperunit_nontaxed DECIMAL (12,4) NULL,
    duesperunit_taxed DECIMAL (12,4) NULL,
    pd_rate DECIMAL (7,4) NULL,
    trailerrate DECIMAL (12,4) NULL,
    bfrate DECIMAL (10,2) NULL,
    strate DECIMAL (7,4) NULL,
    premium DECIMAL (10,2) NULL,
    surcharge DECIMAL (10,2) NULL,
    surplusline_tax DECIMAL (10,2) NULL,
    brokerfees DECIMAL (10,2) NULL,
    endtfees DECIMAL (10,2) NULL,
    otherfees DECIMAL (10,2) NULL,
    totalpremium DECIMAL (10,2) NULL,
    commission DECIMAL (10,2) NULL,
    invoice_date DATE NULL, 
    financing_ref VARCHAR (20) NULL,
    dp_received BOOLEAN DEFAULT FALSE,
    settled_items BOOLEAN DEFAULT FALSE,
    ern VARCHAR (20) NULL,
    notes TEXT NULL,
    estimateid INT NULL,
    created DATETIME,
    modified timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (endtid)
);

UPDATE endorsements SET endt_description = NULL WHERE LENGTH(endt_description) = 0;
UPDATE endorsements SET insured_address = NULL WHERE LENGTH(insured_address) = 0;
UPDATE endorsements SET driverid = null WHERE driverid = 0;
UPDATE endorsements SET vehicleid = null WHERE vehicleid = 0;
UPDATE endorsements SET pro_rate = null WHERE pro_rate = 0;
UPDATE endorsements SET pdvalue = null WHERE pdvalue = 0;
UPDATE endorsements SET baseperunit = null WHERE baseperunit = 0;
UPDATE endorsements SET duesperunit_nontaxed = null WHERE duesperunit_nontaxed = 0;
UPDATE endorsements SET duesperunit_taxed = null WHERE duesperunit_taxed = 0;
UPDATE endorsements SET pd_rate = null WHERE pd_rate = 0;
UPDATE endorsements SET trailerrate = null WHERE trailerrate = 0;
UPDATE endorsements SET bfrate = null WHERE bfrate = 0;
UPDATE endorsements SET strate = null WHERE strate = 0;
UPDATE endorsements SET premium = null WHERE premium = 0;
UPDATE endorsements SET surcharge = null WHERE surcharge = 0;
UPDATE endorsements SET surplusline_tax = null WHERE surplusline_tax = 0;
UPDATE endorsements SET brokerfees = null WHERE brokerfees = 0;
UPDATE endorsements SET endtfees = null WHERE endtfees = 0;
UPDATE endorsements SET otherfees = null WHERE otherfees = 0;
UPDATE endorsements SET totalpremium = null WHERE totalpremium = 0;
UPDATE endorsements SET commission = null WHERE commission = 0;
UPDATE endorsements SET invoice_date = NULL WHERE invoice_date = '0000-00-00 00:00:00';
UPDATE endorsements SET financing_ref = NULL WHERE LENGTH(financing_ref) = 0;
UPDATE endorsements SET ern = NULL WHERE LENGTH(ern) = 0;
UPDATE endorsements SET notes = NULL WHERE LENGTH(notes) = 0;
UPDATE endorsements SET estimateid = null WHERE estimateid = 0;


-- getting the list of account drivers
SELECT d.driverid, d.firstname, d.lastname  
FROM drivers as d
WHERE d.driverid in (
        SELECT DISTINCT e.driverid AS "Drivers"
        FROM endorsements AS e 
        WHERE e.accountid = 35);

-- getting the list of account vehicles
SELECT v.vehicleid, v.vehicle_year, v.makeid, v.vin
FROM vehicles as v
WHERE v.vehicleid IN (
    SELECT DISTINCT e.vehicleid 
    FROM endorsements as e
    WHERE e.accountid = 35);

--getting the latest action of a vehicle
SELECT e.endt_action
FROM endorsements as e
WHERE e.vehicleid = 206 AND e.accountid = 35 AND coveragetypes = 1
ORDER by e.effective DESC, e.endtid DESC LIMIT 1;

-- get the status of the account vehicles on specific coveragetypes

SET @accoutID:=35;
SET @coveragetype:=1; 
SELECT v.vehicleid, v.vehicle_year, v.typeid, v.makeid, v.vin,
    (
        SELECT e.endt_action
        FROM endorsements as e
        WHERE e.vehicleid = v.vehicleid AND e.accountid = @accoutID AND coveragetypes = @coveragetype
        ORDER by e.effective DESC, e.endtid DESC LIMIT 1
    ) AS Status
FROM vehicles as v
WHERE v.vehicleid IN (
    SELECT DISTINCT e.vehicleid 
    FROM endorsements as e
    WHERE e.accountid = @accoutID)
ORDER BY v.typeid;


-- get the list of endt groups
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
FROM endorsements
WHERE accountid = 129
GROUP BY CONCAT(effective,'|',endt_action,'|',endt_type,'|',(IFNULL(driverid,0) + IFNULL(vehicleid,0)),'|',accountid)
ORDER BY effective DESC, stage DESC, endt_type) AS eg 
	LEFT JOIN vehicles AS v ON eg.vehicleid = v.vehicleid) 
    LEFT JOIN vehiclemakes AS vm ON v.makeid = vm.makeid;



CREATE INDEX endt_indexes
ON endorsements(accountid, vehicleid, driverid, effective, endt_type, endt_action);

ALTER Table endorsements
DROP INDEX endt_indexes;    
