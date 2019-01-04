CREATE DATABASE  IF NOT EXISTS `innodev_prueba` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `innodev_prueba`;
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
-- Dumping data for table `tblattributedefinitions`
--

LOCK TABLES `tblAttributeDefinitions` WRITE;
/*!40000 ALTER TABLE `tblAttributeDefinitions` DISABLE KEYS */;
INSERT INTO `tblAttributeDefinitions` VALUES (1,'Fecha de resolución',2,7,0,0,0,'',''),(4,'Deberes éticos (Art. 5 LEG)',2,3,1,0,0,'-a) Utilizar los bienes, fondos, recursos públicos o servicios contratados únicamente para el cumplimiento de los fines institucionales para los cuales están destinados-b) Denunciar ante el Tribunal de Ética Gubernamental o ante la Comisión de Ética Gubernamental respectiva, las supuestas violaciones a los deberes o prohibiciones éticas contenidas en esta Ley, de las que tuviere conocimiento en el ejercicio de su función pública-c) Excusarse de intervenir o participar en asuntos en los cuales él, su cónyuge, conviviente, parientes dentro del cuarto grado de consanguinidad o segundo de afinidad o socio, tengan algún conflicto de interés',''),(5,'Prohibiciones éticas (Art. 6 LEG)',2,3,1,0,0,'-a) Solicitar o aceptar cualquier bien o servicio de valor económico o beneficio adicional al que percibe por el desempeño de sus labores, por hacer, apresurar, retardar o dejar de hacer tareas o trámites relativos a sus funciones-b) Solicitar o aceptar cualquier bien o servicio de valor económico, para hacer valer su influencia en razón del cargo que ocupa ante otra persona sujeta a la aplicación de esta Ley, con la finalidad que éste haga, apresure, retarde o deje de hacer tareas o trámites relativos a sus funciones-c) Percibir más de una remuneración proveniente del presupuesto del Estado, cuando las labores deben ejercerse dentro del mismo horario-d) Desempeñar simultáneamente dos o más empleos en el sector público que fueren incompatibles entre sí por prohibición expresa de la normativa aplicable, por coincidir en las horas de trabajo o porque vaya en contra de los intereses insitucionales-e) Realizar actividades privadas durante la jornada ordinaria de trabajo-f) Exigir o solicitar a los subordinados que empleen el tiempo ordinario de labores para que realicen actividades que no sean las que se les requiera para el cumplimiento de los fines insitucionales-g) Aceptar o mantener un empleo, relaciones contractuales o responsabilidades en el sector privado, que menoscaben la imparcialidad o provoquen un conflicto de interés en el desempeño de su función pública-h) Nombrar, contratar, promover, o ascender en la entidad pública donde ejerce autoridad, a su cónyuge, conviviente, parientes, dentro del cuarto grado de consanguinidad o segundo de afinidad o socio-i) Retardar sin motivo legal la prestación de los servicios, trámites o procedimientos administrativos que le corresponden según sus funciones-j) Denegar a una persona la prestación de un servicio público a que tenga derecho, en razón de su nacionalidad, raza, sexo, religión, opinión política, condición social o económica, discapacidad o cualquier otra razón injustificada-k) Utilizar indebidamente los bienes muebles o inmuebles de la institución para hacer actos de proselitismo político partidario-l) Prevalerse del cargo para hacer política partidista',''),(6,'Problema jurídico',2,3,0,0,0,'',''),(7,'Ratio decidiendi',2,3,0,0,0,'',''),(8,'Decisión',2,3,1,0,0,',Sanciona,No sanciona',''),(9,'LEG',2,3,0,0,0,'','');
/*!40000 ALTER TABLE `tblAttributeDefinitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tblcategory`
--

LOCK TABLES `tblCategory` WRITE;
/*!40000 ALTER TABLE `tblCategory` DISABLE KEYS */;
INSERT INTO `tblCategory` VALUES (2,'Ejecución de procesos'),(3,'Imparcialidad'),(4,'Presupuesto público'),(5,'Uso de bienes y servicios públicos');
/*!40000 ALTER TABLE `tblCategory` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-27  1:05:20
