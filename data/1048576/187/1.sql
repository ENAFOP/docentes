CREATE TABLE metodologias_programas (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idpostulante int,
    experiencia varchar(3000),
    idatestado int,
    FOREIGN KEY  (idpostulante) REFERENCES tblusers(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY  (idatestado) REFERENCES tbldocuments(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);
CREATE TABLE metodologias_disenocartas (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idpostulante int,
    experiencia varchar(3000),
    idatestado int,
    FOREIGN KEY  (idpostulante) REFERENCES tblusers(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY  (idatestado) REFERENCES tbldocuments(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);
CREATE TABLE metodologias_evaluacion (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idpostulante int,
    experiencia varchar(3000),
    idatestado int,
    FOREIGN KEY  (idpostulante) REFERENCES tblusers(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY  (idatestado) REFERENCES tbldocuments(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);
CREATE TABLE metodologias_facilitacion (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idpostulante int,
    experiencia varchar(3000),
    idatestado int,
    FOREIGN KEY  (idpostulante) REFERENCES tblusers(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY  (idatestado) REFERENCES tbldocuments(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);
CREATE TABLE metodologias_participativa (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idpostulante int,
    experiencia varchar(3000),
    idatestado int,
    FOREIGN KEY  (idpostulante) REFERENCES tblusers(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY  (idatestado) REFERENCES tbldocuments(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);
CREATE TABLE metodologias_elaboracion (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idpostulante int,
    experiencia varchar(3000),
    idatestado int,
    FOREIGN KEY  (idpostulante) REFERENCES tblusers(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY  (idatestado) REFERENCES tbldocuments(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);
CREATE TABLE metodologias_linea (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idpostulante int,
    experiencia varchar(3000),
    idatestado int,
    FOREIGN KEY  (idpostulante) REFERENCES tblusers(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY  (idatestado) REFERENCES tbldocuments(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);