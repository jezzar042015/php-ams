

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
	effective, endt_action, endt_type, endt_description,vehicleid,driverid,lineID
FROM (SELECT MAX(effective) as effective, MAX(endt_action) as endt_action, MAX(endt_type) as endt_type, MAX(vehicleid) as vehicleid, MAX(driverid) as driverid,
	CONCAT(MAX(effective),'|',MAX(endt_action),'|',MAX(endt_type),'|',(IFNULL(MAX(driverid),0) + IFNULL(MAX(vehicleid),0)),'|',MAX(accountid)) AS lineID,
    MAX(endt_description) as endt_description
FROM endorsements
WHERE accountid = 35
GROUP BY CONCAT(effective,'|',endt_action,'|',endt_type,'|',(IFNULL(driverid,0) + IFNULL(vehicleid,0)))
order by effective desc) as eg
;