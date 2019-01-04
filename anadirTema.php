<?php 
 $nombreFichero=$_GET['nombrefichero'];
 $texto=$_GET['texto'];
 $myfile = fopen("./listas_tematicas/$nombreFichero.txt", "a") or die("Imposible abrir fichero");
 fwrite($myfile, $texto."\r\n");
?>