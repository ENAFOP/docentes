<?php 
 $nombreFichero=$_GET['nombrefichero'];
 $numElemento=$_GET['numElemento'];
 
$file_out = file("./listas_tematicas/$nombreFichero.txt"); // Read the whole file into an array
//Delete the recorded line
unset($file_out[$numElemento-1]);
//Recorded in a file
file_put_contents("./listas_tematicas/$nombreFichero.txt", implode("", $file_out));
?>