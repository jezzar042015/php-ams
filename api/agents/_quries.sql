CREATE TABLE IF NOT  EXISTS agents (
    agentID TINYINT NOT NULL AUTO_INCREMENT,
    isInactive BOOLEAN,
    lastName VARCHAR (100) NOT NULL,
    firstName VARCHAR (100) NOT NULL,
    email VARCHAR (256),
    commSplit_new DECIMAL(4,2),
    commSplit_renew DECIMAL(4,2),
    brokerFeeSplit DECIMAL(4,2),
    created datetime,
    modified timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (agentID)    
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19; 

INSERT  INTO agents (agentID,isInactive,lastName,firstName,email,commSplit_new,commSplit_renew,brokerFeeSplit)
VALUES 
(1,false,'Nguyen','Anhdy','anhdy@acecic.com',0.35,0.25,0.4),
(2,false,'Martinez','Mario','mario@acecic.com',0.25,0.15,0.4),
(3,false,'Hoang','Jackie','jackie@acecic.com',0.35,0.25,0.4),
(4,false,'Medina','Julissa','julissa@acecic.com',200,100,0),
(5,false,'1','Inactive',null,0.5,0.25,0.5),
(6,false,'Li','Ada','ada@acecic.com',0.5,0.25,0.5),
(7,false,'1','Agent',null,0,0,0);



