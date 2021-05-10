DROP TABLE mgas;

CREATE TABLE IF NOT EXISTS mgas (
    mgaid INT(11) NOT  NULL  AUTO_INCREMENT,
    mganame VARCHAR (256) NOT NULL,
    writingstate  VARCHAR (256) NULL,
    carriers VARCHAR (256) NULL,
    phones VARCHAR (100) NULL,
    emails VARCHAR (256) NULL,
    mga_address VARCHAR (256) NULL,
    mga_city VARCHAR (60) NULL,
    mga_state VARCHAR (5) NULL,
    mga_zip VARCHAR (5) NULL,
    website VARCHAR (256) NULL,
    endtFees DECIMAL (10,2) NULL,
    notes TEXT NULL,
    created datetime NOT NULL,
    modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (mgaid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19;

UPDATE mgas SET endtFees = null WHERE endtFees = 0;
UPDATE mgas SET writingstate = NULL WHERE LENGTH(writingstate) = 0;
UPDATE mgas SET carriers = NULL WHERE LENGTH(carriers) = 0;
UPDATE mgas SET phones = NULL WHERE LENGTH(phones) = 0;
UPDATE mgas SET emails = NULL WHERE LENGTH(emails) = 0;
UPDATE mgas SET mga_address = NULL WHERE LENGTH(mga_address) = 0;
UPDATE mgas SET mga_city = NULL WHERE LENGTH(mga_city) = 0;
UPDATE mgas SET mga_state = NULL WHERE LENGTH(mga_state) = 0;
UPDATE mgas SET mga_zip = NULL WHERE LENGTH(mga_zip) = 0;
UPDATE mgas SET website = NULL WHERE LENGTH(website) = 0;
UPDATE mgas SET notes = NULL WHERE LENGTH(notes) = 0;
