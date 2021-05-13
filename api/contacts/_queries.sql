DROP TABLE contacts;

CREATE TABLE IF NOT EXISTS contacts (
    contactid int(11) NOT NULL  AUTO_INCREMENT,
    firstname VARCHAR (100) NOT NULL,
    middlename VARCHAR (100) NULL,
    lastname VARCHAR (100) NOT NULL,
    title int(11) NOT NULL,
   
    business_phone VARCHAR (20) NULL,
    direct_phone VARCHAR (20) NULL,
    mobile_phone VARCHAR (20) NULL,
    email1 VARCHAR (256) NULL,
    email2 VARCHAR (256) NULL,
   
    accountid int(11) NOT NULL
    notes TEXT NULL,

    created datetime,
    modified timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (contactid) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19; 

UPDATE contacts SET business_phone = NULL WHERE LENGTH(business_phone) = 0;
UPDATE contacts SET direct_phone = NULL WHERE LENGTH(direct_phone) = 0;
UPDATE contacts SET mobile_phone = NULL WHERE LENGTH(mobile_phone) = 0;
UPDATE contacts SET email1 = NULL WHERE LENGTH(email1) = 0;
UPDATE contacts SET email2 = NULL WHERE LENGTH(email2) = 0;
UPDATE contacts SET notes = NULL WHERE LENGTH(notes) = 0;