DROP TABLE drivers;

CREATE TABLE  IF NOT EXISTS drivers (
    driverid int(11) NOT NULL  AUTO_INCREMENT,
    firstname VARCHAR (100) NOT NULL,
    middlename VARCHAR (100) NULL,
    lastname VARCHAR (100) NOT NULL,
    hiredate DATE NULL,
    terminationdate DATE NULL,
    dob DATE NOT NULL,
    cdl_state VARCHAR (5) NOT NULL,
    cdl_number VARCHAR (50) NOT NULL,
    year_licensed VARCHAR (5) NULL,
    phone VARCHAR (20) NULL,
    email VARCHAR (256) NULL,
    isOwnerOperator BOOLEAN DEFAULT TRUE,
    accountid int(11),
    notes TEXT NULL,
    created datetime,
    modified timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (driverid) 
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19;


UPDATE drivers SET middlename = NULL WHERE LENGTH(middlename) = 0;
UPDATE drivers SET hiredate = NULL WHERE LENGTH(hiredate) = "0000-00-00 00:00:00";
UPDATE drivers SET terminationdate = NULL WHERE LENGTH(terminationdate) = "0000-00-00 00:00:00";
UPDATE drivers SET year_licensed = NULL WHERE LENGTH(year_licensed) = 0;
UPDATE drivers SET phone = NULL WHERE LENGTH(phone) = 0;
UPDATE drivers SET email = NULL WHERE LENGTH(email) = 0;
UPDATE policies SET notes = NULL WHERE LENGTH(notes) = 0;