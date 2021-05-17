CREATE TABLE IF NOT EXISTS vehiclemakes(
	makeid int not null auto_increment,
    makename varchar(100) not null,
    maketype tinyint not null,
    primary key (makeid)
);

CREATE TABLE IF NOT EXISTS vehicletypes(
	typeid int not null auto_increment,
    typename varchar(100) not null,
    primary key (typeid)
);

INSERT INTO vehicletypes (typename)
VALUES 
('Tractor'),
('Trailer'),
('Truck');