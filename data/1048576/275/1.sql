-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: teg_reserva
-- ------------------------------------------------------
-- Server version	5.7.19-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tblattributedefinitions`
--

DROP TABLE IF EXISTS `tblattributedefinitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblattributedefinitions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `objtype` tinyint(4) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `multiple` tinyint(4) NOT NULL DEFAULT '0',
  `minvalues` int(11) NOT NULL DEFAULT '0',
  `maxvalues` int(11) NOT NULL DEFAULT '0',
  `valueset` text,
  `regex` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblattributedefinitions`
--

LOCK TABLES `tblattributedefinitions` WRITE;
/*!40000 ALTER TABLE `tblattributedefinitions` DISABLE KEYS */;
INSERT INTO `tblattributedefinitions` VALUES (1,'Fecha de resolución',2,7,0,0,0,'',''),(4,'Deberes éticos (Art. 5 LEG)',2,3,1,0,0,'-a) Utilizar los bienes, fondos, recursos públicos o servicios contratados únicamente para el cumplimiento de los fines institucionales para los cuales están destinados-b) Denunciar ante el Tribunal de Ética Gubernamental o ante la Comisión de Ética Gubernamental respectiva, las supuestas violaciones a los deberes o prohibiciones éticas contenidas en esta Ley, de las que tuviere conocimiento en el ejercicio de su función pública-c) Excusarse de intervenir o participar en asuntos en los cuales él, su cónyuge, conviviente, parientes dentro del cuarto grado de consanguinidad o segundo de afinidad o socio, tengan algún conflicto de interés',''),(5,'Prohibiciones éticas (Art. 6 LEG)',2,3,1,0,0,'-a) Solicitar o aceptar cualquier bien o servicio de valor económico o beneficio adicional al que percibe por el desempeño de sus labores, por hacer, apresurar, retardar o dejar de hacer tareas o trámites relativos a sus funciones-b) Solicitar o aceptar cualquier bien o servicio de valor económico, para hacer valer su influencia en razón del cargo que ocupa ante otra persona sujeta a la aplicación de esta Ley, con la finalidad que éste haga, apresure, retarde o deje de hacer tareas o trámites relativos a sus funciones-c) Percibir más de una remuneración proveniente del presupuesto del Estado, cuando las labores deben ejercerse dentro del mismo horario-d) Desempeñar simultáneamente dos o más empleos en el sector público que fueren incompatibles entre sí por prohibición expresa de la normativa aplicable, por coincidir en las horas de trabajo o porque vaya en contra de los intereses insitucionales-e) Realizar actividades privadas durante la jornada ordinaria de trabajo-f) Exigir o solicitar a los subordinados que empleen el tiempo ordinario de labores para que realicen actividades que no sean las que se les requiera para el cumplimiento de los fines insitucionales-g) Aceptar o mantener un empleo, relaciones contractuales o responsabilidades en el sector privado, que menoscaben la imparcialidad o provoquen un conflicto de interés en el desempeño de su función pública-h) Nombrar, contratar, promover, o ascender en la entidad pública donde ejerce autoridad, a su cónyuge, conviviente, parientes, dentro del cuarto grado de consanguinidad o segundo de afinidad o socio-i) Retardar sin motivo legal la prestación de los servicios, trámites o procedimientos administrativos que le corresponden según sus funciones-j) Denegar a una persona la prestación de un servicio público a que tenga derecho, en razón de su nacionalidad, raza, sexo, religión, opinión política, condición social o económica, discapacidad o cualquier otra razón injustificada-k) Utilizar indebidamente los bienes muebles o inmuebles de la institución para hacer actos de proselitismo político partidario-l) Prevalerse del cargo para hacer política partidista',''),(6,'Problema jurídico',2,3,0,0,0,'',''),(7,'Ratio decidiendi',2,3,0,0,0,'',''),(8,'Decisión',2,3,1,0,0,',Sanciona,No sanciona',''),(9,'LEG',2,3,0,0,0,'','');
/*!40000 ALTER TABLE `tblattributedefinitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblcategory`
--

DROP TABLE IF EXISTS `tblcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcategory`
--

LOCK TABLES `tblcategory` WRITE;
/*!40000 ALTER TABLE `tblcategory` DISABLE KEYS */;
INSERT INTO `tblcategory` VALUES (2,'Ejecución de procesos'),(3,'Imparcialidad'),(4,'Presupuesto público'),(5,'Uso de bienes y servicios públicos');
/*!40000 ALTER TABLE `tblcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbldocumentattributes`
--

DROP TABLE IF EXISTS `tbldocumentattributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbldocumentattributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document` int(11) DEFAULT NULL,
  `attrdef` int(11) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `document` (`document`,`attrdef`),
  KEY `tblDocumentAttributes_attrdef` (`attrdef`),
  CONSTRAINT `tblDocumentAttributes_attrdef` FOREIGN KEY (`attrdef`) REFERENCES `tblattributedefinitions` (`id`),
  CONSTRAINT `tblDocumentAttributes_document` FOREIGN KEY (`document`) REFERENCES `tbldocuments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbldocumentattributes`
--

LOCK TABLES `tbldocumentattributes` WRITE;
/*!40000 ALTER TABLE `tbldocumentattributes` DISABLE KEYS */;
INSERT INTO `tbldocumentattributes` VALUES (33,13,8,',No sanciona'),(35,13,9,'DL 873'),(36,13,6,'¿Solicitó un juez de vigilancia penintenciaria por persona interpuesta la cantidad de mil quinientos dólares a cambio de agilizar el proceso?'),(37,13,5,'-a) Solicitar o aceptar cualquier bien o servicio de valor económico o beneficio adicional al que percibe por el desempeño de sus labores, por hacer, apresurar, retardar o dejar de hacer tareas o trámites relativos a sus funciones'),(38,13,7,'Efectivamente, la prueba documental presentada por los intervinientes y la diligencias de instrucción, no arrojan suficientes elementos para la construcción de un fundamento probatorio certero, y no generan convicción alguna sobre la existencia de la denuncia. De hecho, ni aún fue posible determinar la existencia del señor Marquiño García, quien supuestamente intervino como intermediario de la solicitud.'),(39,14,1,'2015-02-03'),(40,14,9,'DL 1038'),(41,14,6,'¿Es una infracción ética emitir una certificación castastral  sin hacer referencia a la inscripción, a favor de otro poseedor?'),(42,14,7,'Se colige entonces que si el legislador suprime una infracción administrativa del ordenamiento jurídico a través de una nueva ley, dicha situación le favorece al presunto infractor por lo que será la nueva normativa la que deberá aplicársele debido a su evidente carácter benévolo. ... Consecuentemente, al realizar una aplicación retroactiva de la norma sancionadora favorable se advierte que los hechos denunciados, al ser atípicos, ya no resultan sancionables.'),(43,15,8,',No sanciona'),(44,15,1,'2012-11-28'),(45,15,9,'DL 1038'),(46,15,6,'¿Cómo se puede determinar el retardo en la prestación del servicio si no hay un plazo definido?'),(47,15,5,',i'),(48,15,7,'La prueba documental demuestra que desde el treinta de julio hasta el seis de octubre, ambas fechas de dos mil diez, el personal de la Inspectoría realizó una serie de diligencias tendientes a obtener todos los datos relativos a la situación disciplinaria del requirente. Esto significa que al día seis de octubre la servidora pública denunciada contaba con toda la información necesaria para emitir la constancia solicitada; pese a ello, la elaboró hasta el ocho de diciembre, ambas fechas de dos mil diez. Excluyendo los días de asueto previstos por la ley, se advierte que transcurrieron cuarenta y cinco días hábiles desde el seis de octubre hasta el ocho de diciembre de dos mil diez, es decir, desde que la servidora pública denunciada tenía todos los insumos necesarios para emitir la solicitud hasta la fecha en que la extendió. Sin embargo, este Tribunal estima que dicho término es razonable en atención a la complejidad del documento solicitado por el denunciante y la carga laboral que maneja el personal de la Inspectoría General de la Policía Nacional Civil. De esta forma no se advierte la existencia de un retardo injustificado en la prestación del servicio requerido (confidencial) en vista que no existe una normativa que fije un plazo determinado para la extensión de la constancia y que además la denunciada fue diligente al momento de realizar las indagaciones previas a la emisión de la misma. Adicionalmente, se repara que la supuesta dilación no ocasionó un efectivo perjuicio al denunciante pues este finalmente recibió la constancia solicitada.'),(49,16,4,'-c) Excusarse de intervenir o participar en asuntos en los cuales él, su cónyuge, conviviente, parientes dentro del cuarto grado de consanguinidad o segundo de afinidad o socio, tengan algún conflicto de interés'),(50,16,8,',No sanciona'),(51,16,1,'2017-10-08'),(52,16,9,'DL 1038'),(53,16,6,'¿El retraso es imputable a un gerente cuando la respuesta a una solicitud depende de una sección?'),(54,16,7,'Es decir que el trámite de retiro de pensión no sólo es responsabilidad del Gerente General de la Unidad de Pensiones del Instituto Salvadoreño del Seguro Social, sino que dentro del mismo interviene también la Sección de Historial Laboral, cuya jefa es la señora Reina Victoria Castellón. ... De lo anterior se colige que el ingeniero Walter Edgardo Funes Callejas no detuvo ni dilató el retiro de pensión...pues constató que el trámite no es responsabilidad de dicho servidor público. La culminación del trámite exigía la recepción de información proveniente de la Sección de Historial Laboral, lo que no dependía del servidor público denunciado.'),(55,16,5,'-g) Aceptar o mantener un empleo, relaciones contractuales o responsabilidades en el sector privado, que menoscaben la imparcialidad o provoquen un conflicto de interés en el desempeño de su función pública'),(63,18,8,',Sanciona'),(65,18,9,'DL 873'),(66,18,6,'¿Incurre en infracción ética quien es contratado de manera interina  en una organización pública sin que se diera trámite a su renuncia antes en otra?'),(67,18,5,'-a) Solicitar o aceptar cualquier bien o servicio de valor económico o beneficio adicional al que percibe por el desempeño de sus labores, por hacer, apresurar, retardar o dejar de hacer tareas o trámites relativos a sus funciones-l) Prevalerse del cargo para hacer política partidista'),(68,18,7,'El denunciado alegó en su defensa que con fecha veintinueve de marzo de dos mil doce presentó su carta de renuncia irrevocable ante la Junta Directiva de la Facultad Multidisciplinaria Oriental de la UES, en la cual expresión su disposición de continuar ejerciendo sus funciones como docente ad honorem. El señor Martínez Guzmán agregó que dicha renuncia fue recibida sin darle trámite, y que en esa oportunidad le fue manifestado que continuará firmando las planillas; pues de lo contrario afectaría a los demás empleados.  En todo caso, arguyó que el monto recibido sería descontado de la indemnización que le corresponde por el tiempo laborado en la institución. Al respecto, se constatada que la nota que dirigió el denunciado a la referida institución para interponer su renuncia está fechada el veintinueve sede marzo de dos mil doce.  Sin embargo, esta nota fue recibida en realidad hasta el veinte de julio de ese año por la Secretaría de la Facultad... ... Lógicamente, el resultado del desempeño coincidente en ambas instituciones por parte del señor Martínez Guzmán fue la percepción por este durante los meses de marzo, abril, mayo y junio de dos mil doce de dos remuneraciones provenientes del presupuesto del Estado.'),(69,14,4,'-b) Denunciar ante el Tribunal de Ética Gubernamental o ante la Comisión de Ética Gubernamental respectiva, las supuestas violaciones a los deberes o prohibiciones éticas contenidas en esta Ley, de las que tuviere conocimiento en el ejercicio de su función pública'),(70,14,8,',No sanciona'),(71,14,5,'-b) Solicitar o aceptar cualquier bien o servicio de valor económico, para hacer valer su influencia en razón del cargo que ocupa ante otra persona sujeta a la aplicación de esta Ley, con la finalidad que éste haga, apresure, retarde o deje de hacer tareas o trámites relativos a sus funciones'),(81,21,4,'-a) Utilizar los bienes, fondos, recursos públicos o servicios contratados únicamente para el cumplimiento de los fines institucionales para los cuales están destinados'),(82,21,8,',No sanciona'),(83,21,1,'2010-01-01'),(84,21,6,'Problema'),(85,21,5,'-a) Solicitar o aceptar cualquier bien o servicio de valor económico o beneficio adicional al que percibe por el desempeño de sus labores, por hacer, apresurar, retardar o dejar de hacer tareas o trámites relativos a sus funciones-e) Realizar actividades privadas durante la jornada ordinaria de trabajo-h) Nombrar, contratar, promover, o ascender en la entidad pública donde ejerce autoridad, a su cónyuge, conviviente, parientes, dentro del cuarto grado de consanguinidad o segundo de afinidad o socio'),(86,21,7,'Ratio'),(87,13,4,'-b) Denunciar ante el Tribunal de Ética Gubernamental o ante la Comisión de Ética Gubernamental respectiva, las supuestas violaciones a los deberes o prohibiciones éticas contenidas en esta Ley, de las que tuviere conocimiento en el ejercicio de su función pública-c) Excusarse de intervenir o participar en asuntos en los cuales él, su cónyuge, conviviente, parientes dentro del cuarto grado de consanguinidad o segundo de afinidad o socio, tengan algún conflicto de interés'),(88,13,1,'2017-10-01'),(89,21,9,'XXXXXX'),(90,18,1,'2010-02-02'),(91,22,4,'-a) Utilizar los bienes, fondos, recursos públicos o servicios contratados únicamente para el cumplimiento de los fines institucionales para los cuales están destinados'),(92,22,8,',No sanciona'),(93,22,1,'2017-10-03'),(94,22,9,'dasdas'),(95,22,6,'Este es um problema juridico'),(96,22,5,'-e) Realizar actividades privadas durante la jornada ordinaria de trabajo'),(97,22,7,'oki');
/*!40000 ALTER TABLE `tbldocumentattributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbldocumentcategory`
--

DROP TABLE IF EXISTS `tbldocumentcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbldocumentcategory` (
  `categoryID` int(11) NOT NULL DEFAULT '0',
  `documentID` int(11) NOT NULL DEFAULT '0',
  KEY `tblDocumentCategory_category` (`categoryID`),
  KEY `tblDocumentCategory_document` (`documentID`),
  CONSTRAINT `tblDocumentCategory_category` FOREIGN KEY (`categoryID`) REFERENCES `tblcategory` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tblDocumentCategory_document` FOREIGN KEY (`documentID`) REFERENCES `tbldocuments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbldocumentcategory`
--

LOCK TABLES `tbldocumentcategory` WRITE;
/*!40000 ALTER TABLE `tbldocumentcategory` DISABLE KEYS */;
INSERT INTO `tbldocumentcategory` VALUES (2,13),(2,14),(2,15),(2,16),(3,18),(3,21),(5,22);
/*!40000 ALTER TABLE `tbldocumentcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbldocumentcontent`
--

DROP TABLE IF EXISTS `tbldocumentcontent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbldocumentcontent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document` int(11) NOT NULL DEFAULT '0',
  `version` smallint(5) unsigned NOT NULL,
  `comment` text,
  `date` int(12) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `dir` varchar(255) NOT NULL DEFAULT '',
  `orgFileName` varchar(150) NOT NULL DEFAULT '',
  `fileType` varchar(10) NOT NULL DEFAULT '',
  `mimeType` varchar(100) NOT NULL DEFAULT '',
  `fileSize` bigint(20) DEFAULT NULL,
  `checksum` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `document` (`document`,`version`),
  CONSTRAINT `tblDocumentContent_document` FOREIGN KEY (`document`) REFERENCES `tbldocuments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbldocumentcontent`
--

LOCK TABLES `tbldocumentcontent` WRITE;
/*!40000 ALTER TABLE `tbldocumentcontent` DISABLE KEYS */;
INSERT INTO `tbldocumentcontent` VALUES (13,13,1,'',1508358751,1,'13/','unins000.dat','.dat','application/octet-stream',11273,'60ad923e82a92c81697f067e9d522b5f'),(14,14,1,'',1508358900,1,'14/','unins000.dat','.dat','application/octet-stream',11273,'60ad923e82a92c81697f067e9d522b5f'),(15,15,1,'',1508359036,1,'15/','changelog.txt','.txt','text/plain',37339,'2640a9cff0b9de65a38f219cf6ed1a82'),(16,16,1,'',1508375799,1,'16/','sublime.py','.py','application/octet-stream',37575,'7ba4d5abb9f324cb5aedd7b81398a827'),(18,18,1,'',1508382214,1,'18/','unins000.dat','.dat','application/octet-stream',11273,'60ad923e82a92c81697f067e9d522b5f'),(21,13,2,'',1509032556,1,'13/','LEY DE ETICA.pdf','.pdf','application/pdf',187710,'daebd00d1e087639648765b5dc3fc361'),(22,21,1,'',1509036327,1,'21/','LEY DE ETICA.pdf','.pdf','application/pdf',187710,'daebd00d1e087639648765b5dc3fc361'),(23,13,3,'dasda',1509062980,1,'13/','señorAttributeManager.php','.php','application/octet-stream',14577,'ca86bc4cca2d9e63475109ff8ccb1de0'),(24,13,4,'',1509062992,1,'13/','LEY DE ETICA.pdf','.pdf','application/pdf',187710,'daebd00d1e087639648765b5dc3fc361'),(25,22,1,'',1509063460,1,'22/','LEY DE ETICA.pdf','.pdf','application/pdf',187710,'daebd00d1e087639648765b5dc3fc361');
/*!40000 ALTER TABLE `tbldocumentcontent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbldocumentcontentattributes`
--

DROP TABLE IF EXISTS `tbldocumentcontentattributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbldocumentcontentattributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` int(11) DEFAULT NULL,
  `attrdef` int(11) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content` (`content`,`attrdef`),
  KEY `tblDocumentContentAttributes_attrdef` (`attrdef`),
  CONSTRAINT `tblDocumentContentAttributes_attrdef` FOREIGN KEY (`attrdef`) REFERENCES `tblattributedefinitions` (`id`),
  CONSTRAINT `tblDocumentContentAttributes_document` FOREIGN KEY (`content`) REFERENCES `tbldocumentcontent` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbldocumentcontentattributes`
--

LOCK TABLES `tbldocumentcontentattributes` WRITE;
/*!40000 ALTER TABLE `tbldocumentcontentattributes` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbldocumentcontentattributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbldocumentfiles`
--

DROP TABLE IF EXISTS `tbldocumentfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbldocumentfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document` int(11) NOT NULL DEFAULT '0',
  `userID` int(11) NOT NULL DEFAULT '0',
  `comment` text,
  `name` varchar(150) DEFAULT NULL,
  `date` int(12) DEFAULT NULL,
  `dir` varchar(255) NOT NULL DEFAULT '',
  `orgFileName` varchar(150) NOT NULL DEFAULT '',
  `fileType` varchar(10) NOT NULL DEFAULT '',
  `mimeType` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `tblDocumentFiles_document` (`document`),
  KEY `tblDocumentFiles_user` (`userID`),
  CONSTRAINT `tblDocumentFiles_document` FOREIGN KEY (`document`) REFERENCES `tbldocuments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tblDocumentFiles_user` FOREIGN KEY (`userID`) REFERENCES `tblusers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbldocumentfiles`
--

LOCK TABLES `tbldocumentfiles` WRITE;
/*!40000 ALTER TABLE `tbldocumentfiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbldocumentfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbldocumentlinks`
--

DROP TABLE IF EXISTS `tbldocumentlinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbldocumentlinks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document` int(11) NOT NULL DEFAULT '0',
  `target` int(11) NOT NULL DEFAULT '0',
  `userID` int(11) NOT NULL DEFAULT '0',
  `public` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tblDocumentLinks_document` (`document`),
  KEY `tblDocumentLinks_target` (`target`),
  KEY `tblDocumentLinks_user` (`userID`),
  CONSTRAINT `tblDocumentLinks_document` FOREIGN KEY (`document`) REFERENCES `tbldocuments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tblDocumentLinks_target` FOREIGN KEY (`target`) REFERENCES `tbldocuments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tblDocumentLinks_user` FOREIGN KEY (`userID`) REFERENCES `tblusers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbldocumentlinks`
--

LOCK TABLES `tbldocumentlinks` WRITE;
/*!40000 ALTER TABLE `tbldocumentlinks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbldocumentlinks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbldocumentlocks`
--

DROP TABLE IF EXISTS `tbldocumentlocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbldocumentlocks` (
  `document` int(11) NOT NULL DEFAULT '0',
  `userID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`document`),
  KEY `tblDocumentLocks_user` (`userID`),
  CONSTRAINT `tblDocumentLocks_document` FOREIGN KEY (`document`) REFERENCES `tbldocuments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tblDocumentLocks_user` FOREIGN KEY (`userID`) REFERENCES `tblusers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbldocumentlocks`
--

LOCK TABLES `tbldocumentlocks` WRITE;
/*!40000 ALTER TABLE `tbldocumentlocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbldocumentlocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbldocuments`
--

DROP TABLE IF EXISTS `tbldocuments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbldocuments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `comment` text,
  `date` int(12) DEFAULT NULL,
  `expires` int(12) DEFAULT NULL,
  `owner` int(11) DEFAULT NULL,
  `folder` int(11) DEFAULT NULL,
  `folderList` text NOT NULL,
  `inheritAccess` tinyint(1) NOT NULL DEFAULT '1',
  `defaultAccess` tinyint(4) NOT NULL DEFAULT '0',
  `locked` int(11) NOT NULL DEFAULT '-1',
  `keywords` text NOT NULL,
  `sequence` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tblDocuments_folder` (`folder`),
  KEY `tblDocuments_owner` (`owner`),
  CONSTRAINT `tblDocuments_folder` FOREIGN KEY (`folder`) REFERENCES `tblfolders` (`id`),
  CONSTRAINT `tblDocuments_owner` FOREIGN KEY (`owner`) REFERENCES `tblusers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbldocuments`
--

LOCK TABLES `tbldocuments` WRITE;
/*!40000 ALTER TABLE `tbldocuments` DISABLE KEYS */;
INSERT INTO `tbldocuments` VALUES (13,'89-2012','¿Solicitó un juez de vigilancia penintenciaria por persona interpuesta la cantidad de mil quinientos dólares a cambio de agilizar el proceso?',1508358751,0,1,1,':1:',1,2,-1,'',1),(14,'54-2010','¿Es una infracción ética emitir una certificación castastral  sin hacer referencia a la inscripción, a favor de otro poseedor?',1508358900,0,1,1,':1:',1,2,-1,'',1),(15,'2-2011','¿Cómo se puede determinar el retardo en la prestación del servicio si no hay un plazo definido?',1508359036,0,1,1,':1:',1,2,-1,'',1),(16,'39-2011','¿El retraso es imputable a un gerente cuando la respuesta a una solicitud depende de una sección?',1508375799,0,1,1,':1:',1,2,-1,'',1),(18,'106-2012','¿Incurre en infracción ética quien es contratado de manera interina  en una organización pública sin que se diera trámite a su renuncia antes en otra?',1508382214,0,1,1,':1:',1,2,-1,'',1),(21,'Ejemplo','Problema',1509036327,0,1,1,':1:',1,2,-1,'',1),(22,'xxxx','Este es um problema juridico',1509063460,0,1,1,':1:',1,2,-1,'',1);
/*!40000 ALTER TABLE `tbldocuments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbldocumentstatus`
--

DROP TABLE IF EXISTS `tbldocumentstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbldocumentstatus` (
  `statusID` int(11) NOT NULL AUTO_INCREMENT,
  `documentID` int(11) NOT NULL DEFAULT '0',
  `version` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`statusID`),
  UNIQUE KEY `documentID` (`documentID`,`version`),
  CONSTRAINT `tblDocumentStatus_document` FOREIGN KEY (`documentID`) REFERENCES `tbldocuments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbldocumentstatus`
--

LOCK TABLES `tbldocumentstatus` WRITE;
/*!40000 ALTER TABLE `tbldocumentstatus` DISABLE KEYS */;
INSERT INTO `tbldocumentstatus` VALUES (10,13,1),(18,13,2),(20,13,3),(21,13,4),(11,14,1),(12,15,1),(13,16,1),(15,18,1),(19,21,1),(22,22,1);
/*!40000 ALTER TABLE `tbldocumentstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbldocumentstatuslog`
--

DROP TABLE IF EXISTS `tbldocumentstatuslog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbldocumentstatuslog` (
  `statusLogID` int(11) NOT NULL AUTO_INCREMENT,
  `statusID` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `userID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`statusLogID`),
  KEY `statusID` (`statusID`),
  KEY `tblDocumentStatusLog_user` (`userID`),
  CONSTRAINT `tblDocumentStatusLog_status` FOREIGN KEY (`statusID`) REFERENCES `tbldocumentstatus` (`statusID`) ON DELETE CASCADE,
  CONSTRAINT `tblDocumentStatusLog_user` FOREIGN KEY (`userID`) REFERENCES `tblusers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbldocumentstatuslog`
--

LOCK TABLES `tbldocumentstatuslog` WRITE;
/*!40000 ALTER TABLE `tbldocumentstatuslog` DISABLE KEYS */;
INSERT INTO `tbldocumentstatuslog` VALUES (12,10,2,'New document content submitted','2017-10-18 14:32:31',1),(13,11,2,'New document content submitted','2017-10-18 14:35:00',1),(14,12,2,'New document content submitted','2017-10-18 14:37:16',1),(15,13,2,'New document content submitted','2017-10-18 19:16:39',1),(17,15,2,'New document content submitted','2017-10-18 21:03:34',1),(20,18,2,'New document content submitted','2017-10-26 09:42:36',1),(21,19,2,'New document content submitted','2017-10-26 10:45:27',1),(22,20,2,'New document content submitted','2017-10-26 18:09:40',1),(23,21,2,'New document content submitted','2017-10-26 18:09:52',1),(24,22,2,'New document content submitted','2017-10-26 18:17:40',1);
/*!40000 ALTER TABLE `tbldocumentstatuslog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblevents`
--

DROP TABLE IF EXISTS `tblevents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblevents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `comment` text,
  `start` int(12) DEFAULT NULL,
  `stop` int(12) DEFAULT NULL,
  `date` int(12) DEFAULT NULL,
  `userID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblevents`
--

LOCK TABLES `tblevents` WRITE;
/*!40000 ALTER TABLE `tblevents` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblevents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblfolderattributes`
--

DROP TABLE IF EXISTS `tblfolderattributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblfolderattributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folder` int(11) DEFAULT NULL,
  `attrdef` int(11) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `folder` (`folder`,`attrdef`),
  KEY `tblFolderAttributes_attrdef` (`attrdef`),
  CONSTRAINT `tblFolderAttributes_attrdef` FOREIGN KEY (`attrdef`) REFERENCES `tblattributedefinitions` (`id`),
  CONSTRAINT `tblFolderAttributes_folder` FOREIGN KEY (`folder`) REFERENCES `tblfolders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblfolderattributes`
--

LOCK TABLES `tblfolderattributes` WRITE;
/*!40000 ALTER TABLE `tblfolderattributes` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblfolderattributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblfolders`
--

DROP TABLE IF EXISTS `tblfolders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblfolders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `folderList` text NOT NULL,
  `comment` text,
  `date` int(12) DEFAULT NULL,
  `owner` int(11) DEFAULT NULL,
  `inheritAccess` tinyint(1) NOT NULL DEFAULT '1',
  `defaultAccess` tinyint(4) NOT NULL DEFAULT '0',
  `sequence` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  KEY `tblFolders_owner` (`owner`),
  CONSTRAINT `tblFolders_owner` FOREIGN KEY (`owner`) REFERENCES `tblusers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblfolders`
--

LOCK TABLES `tblfolders` WRITE;
/*!40000 ALTER TABLE `tblfolders` DISABLE KEYS */;
INSERT INTO `tblfolders` VALUES (1,'resoluciones',0,'','DMS root',1505769715,1,0,2,0);
/*!40000 ALTER TABLE `tblfolders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblgroupmembers`
--

DROP TABLE IF EXISTS `tblgroupmembers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblgroupmembers` (
  `groupID` int(11) NOT NULL DEFAULT '0',
  `userID` int(11) NOT NULL DEFAULT '0',
  `manager` smallint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `groupID` (`groupID`,`userID`),
  KEY `tblGroupMembers_user` (`userID`),
  CONSTRAINT `tblGroupMembers_group` FOREIGN KEY (`groupID`) REFERENCES `tblgroups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tblGroupMembers_user` FOREIGN KEY (`userID`) REFERENCES `tblusers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblgroupmembers`
--

LOCK TABLES `tblgroupmembers` WRITE;
/*!40000 ALTER TABLE `tblgroupmembers` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblgroupmembers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblgroups`
--

DROP TABLE IF EXISTS `tblgroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblgroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblgroups`
--

LOCK TABLES `tblgroups` WRITE;
/*!40000 ALTER TABLE `tblgroups` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblgroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblusers`
--

DROP TABLE IF EXISTS `tblusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) DEFAULT NULL,
  `pwd` varchar(50) DEFAULT NULL,
  `fullName` varchar(100) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `language` varchar(32) NOT NULL,
  `theme` varchar(32) NOT NULL,
  `comment` text NOT NULL,
  `role` smallint(1) NOT NULL DEFAULT '0',
  `hidden` smallint(1) NOT NULL DEFAULT '0',
  `pwdExpiration` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `loginfailures` tinyint(4) NOT NULL DEFAULT '0',
  `disabled` smallint(1) NOT NULL DEFAULT '0',
  `quota` bigint(20) DEFAULT NULL,
  `homefolder` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  KEY `tblUsers_homefolder` (`homefolder`),
  CONSTRAINT `tblUsers_homefolder` FOREIGN KEY (`homefolder`) REFERENCES `tblfolders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblusers`
--

LOCK TABLES `tblusers` WRITE;
/*!40000 ALTER TABLE `tblusers` DISABLE KEYS */;
INSERT INTO `tblusers` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3','Administrator','marioleiva2011@gmail.com','es_ES','multisis-lte','Administrador del TEG',1,0,'0000-00-00 00:00:00',0,0,0,NULL),(2,'guest',NULL,'Buscador de resoluciones del TEG',NULL,'es_ES','multisis-lte','',2,0,'0000-00-00 00:00:00',0,0,0,NULL);
/*!40000 ALTER TABLE `tblusers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-27  0:21:30
