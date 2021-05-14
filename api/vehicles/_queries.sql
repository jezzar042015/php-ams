DROP TABLE vehicles;

CREATE TABLE IF NOT EXISTS vehicles (
    vehicleid int(11) NOT NULL AUTO_INCREMENT, 
    vin VARCHAR (100) NULL,
    vehicle_year VARCHAR (10) NULL,
    makeid TINYINT NOT NULL,
    typeid TINYINT NOT NULL,

    model VARCHAR (256) NULL,
    unit_number VARCHAR (50) NULL,
    pdvalue DECIMAL (10,2) NULL,
    driverid int(11) NULL,
    lienholder int(11) NULL,
    
    accountid int(11) NOT NULL,
    notes TEXT NULL,
    created datetime,
    modified timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (vehicleid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19;

UPDATE vehicles SET vin = NULL WHERE LENGTH(vin) = 0;
UPDATE vehicles SET vehicle_year = NULL WHERE LENGTH(vehicle_year) = 0;
UPDATE vehicles SET model = NULL WHERE LENGTH(model) = 0;
UPDATE vehicles SET unit_number = NULL WHERE LENGTH(unit_number) = 0;
UPDATE vehicles SET pdvalue = null WHERE pdvalue = 0;
UPDATE vehicles SET lienholder = null WHERE lienholder = 0;
UPDATE vehicles SET notes = NULL WHERE LENGTH(notes) = 0;

UPDATE vehicles SET vin = NULL WHERE makeid = 14;