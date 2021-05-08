CREATE TABLE IF NOT  EXISTS policies (
    policyID int(11) NOT NULL  AUTO_INCREMENT,
    policyNumber VARCHAR (256) NOT NULL,
    accountID   int(11) NOT NULL,
    mgaID int(11) NOT NULL,
    carrierID int(11) NOT NULL,
    coverageType TINYINT NOT NULL,
    bindDate DATE NULL,
    effective DATE NULL,
    expiration DATE NULL,

    baseperunit DECIMAL (10,4) NULL,
    duesperunit_nontaxed DECIMAL (10,4) NULL,
    pdrate DECIMAL (10,4) NULL,
    trailerrate DECIMAL (10,4) NULL,
    not_rate DECIMAL (10,4) NULL,
    ti_rate DECIMAL (10,4) NULL,
    bfrate DECIMAL (10,4) NULL,
    strate DECIMAL (10,4) NULL,
    commissionrate DECIMAL (10,4) NULL,

    premium DECIMAL (12,4) NULL,
    surcharge DECIMAL (12,4) NULL,
    policyfees DECIMAL (12,4) NULL,
    mgafees DECIMAL (12,4) NULL,
    surplusTax DECIMAL (12,4) NULL,
    brokerfees DECIMAL (12,4) NULL,
    otherfees DECIMAL (12,4) NULL,
    totalpremium DECIMAL (12,4) NULL,
    commission DECIMAL (12,4) NULL,

    agentsplit VARCHAR (40) NULL,
    policystate VARCHAR (40) NULL,
    premiumfinancer int(11) NULL,
    pf_accountNo VARCHAR (100) NULL,
    notes TEXT NULL,
    onInceptionStage BOOLEAN DEFAULT TRUE,
    created datetime NOT NULL,
    modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (policyID)    
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19;

DROP TABLE policies;


--cleaning the policies TABLE 
UPDATE policies SET bindDate = null WHERE bindDate = '0000-00-00 00:00:00';
UPDATE policies SET baseperunit = null WHERE baseperunit = 0;
UPDATE policies SET duesperunit_nontaxed = null WHERE duesperunit_nontaxed = 0;
UPDATE policies SET pdrate = null WHERE pdrate = 0;
UPDATE policies SET trailerrate = null WHERE trailerrate = 0;
UPDATE policies SET not_rate = null WHERE not_rate = 0;
UPDATE policies SET ti_rate = null WHERE ti_rate = 0;
UPDATE policies SET bfrate = null WHERE bfrate = 0;
UPDATE policies SET strate = null WHERE strate = 0;
UPDATE policies SET commissionrate = null WHERE commissionrate = 0;
UPDATE policies SET premium = null WHERE premium = 0;
UPDATE policies SET surcharge = null WHERE surcharge = 0;
UPDATE policies SET policyfees = null WHERE policyfees = 0;
UPDATE policies SET mgafees = null WHERE mgafees = 0;
UPDATE policies SET surplustax = null WHERE surplustax = 0;
UPDATE policies SET brokerfees = null WHERE brokerfees = 0;
UPDATE policies SET otherfees = null WHERE otherfees = 0;
UPDATE policies SET totalpremium = null WHERE totalpremium = 0;
UPDATE policies SET commission = null WHERE commission = 0;
UPDATE policies SET premiumfinancer = null WHERE premiumfinancer = 0;