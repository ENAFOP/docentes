CREATE TABLE otros (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idpostulante int,
    ingles varchar(5),
    prezi varchar (5),
    relevante varchar (3500),
    FOREIGN KEY  (idpostulante) REFERENCES tblusers(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);