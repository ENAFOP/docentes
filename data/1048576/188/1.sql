-- SCRIPT QUE CREA LAS TABLAS NECESARIAS PARA  LA PESTAÑA 2: EXPERIENCIA LABORAL. EL EJE ES EL CARGO.

CREATE TABLE cargos (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idpostulante int,
    cargo varchar(256),
    funciones varchar (1500),
    institucion varchar (100),
    anoinicio varchar(4),
    anofin varchar(4),
    FOREIGN KEY  (idpostulante) REFERENCES tblusers(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);
