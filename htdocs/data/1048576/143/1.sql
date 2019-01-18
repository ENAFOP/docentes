CREATE TABLE cartas (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idpostulante int,
    idcarta int,
    FOREIGN KEY  (idpostulante) REFERENCES tblusers(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY  (idcarta) REFERENCES tbldocuments(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE referencias_personales (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idpostulante int,
    idreferencias int,
    FOREIGN KEY  (idpostulante) REFERENCES tblusers(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY  (idreferencias) REFERENCES tbldocuments(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);
