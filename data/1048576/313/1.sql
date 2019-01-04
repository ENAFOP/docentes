CREATE TABLE conocimientos_adicionales(
id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
idpostulante int,
conocimientos varchar(1500),
FOREIGN KEY (idpostulante) REFERENCES tblUsers(id)
ON delete CASCADE
ON UPDATE CASCADE
);