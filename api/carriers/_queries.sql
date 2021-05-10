DROP TABLE carriers;

CREATE TABLE IF NOT EXISTS carriers (
    carrierid INT(11) NOT  NULL  AUTO_INCREMENT,
    carriername VARCHAR (256) NOT NULL,
    agencycode  VARCHAR (50) NULL,
    ambest_rating VARCHAR (50) NULL,
    phones VARCHAR (100) NULL,
    emails VARCHAR (256) NULL,
    carr_address VARCHAR (256) NULL,
    carr_city VARCHAR (60) NULL,
    carr_state VARCHAR (5) NULL,
    carr_zip VARCHAR (5) NULL,
    website VARCHAR (256) NULL,
    notes TEXT NULL,
    created datetime NOT NULL,
    modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (carrierid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19;

UPDATE carriers SET ambest_rating = NULL WHERE LENGTH(ambest_rating) = 0;
UPDATE carriers SET writingstate = NULL WHERE LENGTH(writingstate) = 0;
UPDATE carriers SET agencycode = NULL WHERE LENGTH(agencycode) = 0;
UPDATE carriers SET phones = NULL WHERE LENGTH(phones) = 0;
UPDATE carriers SET emails = NULL WHERE LENGTH(emails) = 0;
UPDATE carriers SET carr_address = NULL WHERE LENGTH(carr_address) = 0;
UPDATE carriers SET carr_city = NULL WHERE LENGTH(carr_city) = 0;
UPDATE carriers SET carr_state = NULL WHERE LENGTH(carr_state) = 0;
UPDATE carriers SET carr_zip = NULL WHERE LENGTH(carr_zip) = 0;
UPDATE carriers SET website = NULL WHERE LENGTH(website) = 0;
UPDATE carriers SET notes = NULL WHERE LENGTH(notes) = 0;
