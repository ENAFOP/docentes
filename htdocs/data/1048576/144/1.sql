CREATE TABLE experiencia_formacion (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idpostulante int,
    taller varchar(365),
    totalhoras int,
    fechainicio varchar(20),
    fechafin varchar(20),
    modalidad varchar(35),
    institucion varchar(300),
    idatestado int,
    FOREIGN KEY  (idpostulante) REFERENCES tblusers(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY  (idatestado) REFERENCES tbldocuments(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);