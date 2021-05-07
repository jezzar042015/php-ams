-- dropping accounts table
DROP TABLE accounts;

-- creating the table structure
CREATE TABLE IF NOT  EXISTS accounts (
    accountID   int(11) NOT NULL  AUTO_INCREMENT,
    accountStatus TINYINT DEFAULT 1,
    accountType TINYINT DEFAULT 1,
    usdot VARCHAR (50),
    statePermit VARCHAR (50),
    taxid VARCHAR (50),
    legalName VARCHAR (256) NOT NULL,
    dba VARCHAR (256),
    operation TINYINT,
    radius TINYINT,
    mailAddress VARCHAR (256),
    mailCity VARCHAR (60),
    mailState VARCHAR (5),
    mailZip VARCHAR (10),
    garageAddress VARCHAR (256),
    garageCity VARCHAR (60),
    garageState VARCHAR (5),
    garageZip VARCHAR (10),
    notes VARCHAR (256),
    accountSource TINYINT,
    yearClient VARCHAR (10),
    agent TINYINT,
    created datetime,
    modified timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (accountID)    
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19; 

-- updating the data after csv import
-- setting null on zero string lengths
UPDATE accounts SET usdot = NULL WHERE LENGTH(usdot) = 0;
UPDATE accounts SET statePermit = NULL WHERE LENGTH(statePermit) = 0;
UPDATE accounts SET taxid = NULL WHERE LENGTH(taxid) = 0;
UPDATE accounts SET dba = NULL WHERE LENGTH(dba) = 0;
UPDATE accounts SET notes = NULL WHERE LENGTH(notes) = 0;
UPDATE accounts SET yearClient = NULL WHERE LENGTH(yearClient) = 0;



-- creating the support tables
-- creating the accountStatus table

-- ACCOUNT_STATUS
CREATE TABLE IF NOT EXISTS accountStatus (
    id TINYINT NOT NULL AUTO_INCREMENT,
    account_status VARCHAR (50) NOT NULL,
    PRIMARY KEY (id)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19; 

INSERT  INTO accountStatus (id,account_status)
VALUES 
(1,'active'),
(2,'inactive'),
(3,'prospect');

-- ACCOUNT_TYPES
CREATE TABLE IF NOT EXISTS accountTypes (
    id TINYINT NOT NULL AUTO_INCREMENT,
    account_type VARCHAR (50) NOT NULL,
    PRIMARY KEY (id)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19; 

INSERT  INTO accountTypes (id,account_type)
VALUES 
(1,'trucking'),
(2,'commercial');

-- ACCOUNT_OPERATIONS
CREATE TABLE IF NOT EXISTS operations (
    id TINYINT NOT NULL AUTO_INCREMENT,
    operation VARCHAR (50) NOT NULL,
    PRIMARY KEY (id)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19;

INSERT  INTO operations (id,operation)
VALUES 
(1,'intermodal'),
(2,'flatbed'),
(3,'dry'),
(4,'refrigerated'),
(5,'hook & drop'),
(6,'sand & gravel'),
(7,'container hauling');

-- ACCOUNT_RADIUS
CREATE TABLE IF NOT EXISTS radius (
    id TINYINT NOT NULL AUTO_INCREMENT,
    radius VARCHAR (50) NOT NULL,
    PRIMARY KEY (id)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19;

INSERT  INTO radius (id,radius)
VALUES 
(1,'local'),
(2,'intrastate'),
(3,'ca,az,nv'),
(4,'11 western'),
(5,'48 states');

-- ACCOUNT_SOURCE
CREATE TABLE IF NOT EXISTS accountSources (
    id TINYINT NOT NULL AUTO_INCREMENT,
    accountSource VARCHAR (50) NOT NULL,
    PRIMARY KEY (id)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19;

INSERT  INTO accountSources (id,accountSource)
VALUES 
(1,'telemarketing'),
(2,'google search'),
(3,'social media'),
(4,'client referral'),
(5,'email marketing'),
(6,'business network');



-- STATES TABLE 
CREATE TABLE IF NOT EXISTS usstates (
    id VARCHAR(15) NOT NULL,
    city VARCHAR(100) NOT NULL,
    city_ascii VARCHAR(100) NOT NULL,
    state_id VARCHAR(5) NOT NULL,
    state_name VARCHAR(100) NOT NULL,
    zips VARCHAR(256) NOT NULL,
    PRIMARY KEY (id)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19;