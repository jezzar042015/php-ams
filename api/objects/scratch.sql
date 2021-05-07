


CREATE TABLE IF NOT  EXISTS policies (
    policyID   int(11) NOT NULL  AUTO_INCREMENT,
    policyNumber VARCHAR (256) NOT NULL,
    coverageType TINYINT NOT NULL,
    effective DATE NULL,
    expiration DATE NULL,
    accountID   int(11) NOT NULL,
    created datetime NOT NULL,
    modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (policyID)    
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19;


INSERT INTO accounts (accountID,legalName,usdot)
VALUES
(1,'DBA Transport Inc','2904310'),
(2,'Anytime Transport Inc','2799986'),
(3,'Right Time Transport LLC','2461825');


INSERT  INTO policies (policyID,policyNumber,coverageType,effective,expiration,accountID)
VALUES
(1,'KSI000193-00',1,'2020-8-22','2021-8-22',1),
(2,'RK60919A20',2,'2020-8-22','2021-8-22',1),
(3,'PFA02049A20',3,'2020-8-22','2021-8-22',1),
(4,'WGL000458-00',4,'2020-8-22','2021-8-22',1),
(5,'CTS0232731',1,'2021-1-13','2022-1-13',3),
(6,'MKLM7IM0052816',2,'2021-1-13','2022-1-13',3),
(7,'B1180D200941/155',3,'2021-1-13','2022-1-13',3),
(8,'JMH000033-00',1,'2020-8-15','2021-8-15',3),
(9,'MKLM6IM0054016',2,'2020-8-15','2021-8-15',3),
(10,'RK61107A20',3,'2020-8-15','2021-8-15',3);


