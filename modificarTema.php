<?php
$name="";
$pk=""; //me dirá el numero de linea del fichero
$value="";  //nuevo contenido de la línea pk
if(isset($_POST['pk']))
{
  $pk=$_POST['pk'];
}
if(isset($_POST['name']))
{
  $name=$_POST['name'];
}
if(isset($_POST['value']))
{
  $value=$_POST['value'];
  $value = iconv("UTF-8","windows-1250",$value);
}
$tmp = explode("_", $name);
$nombreFichero=$tmp[0];
//echo "Fichero: ".$nombreFichero;

$file = file("./listas_tematicas/$nombreFichero.txt");
$lines = array_map(function ($value) { return rtrim($value, PHP_EOL); }, $file);
$indice=$pk-1;

$lines[$indice] = $value."\r\n";
$lines = array_values($lines);
$content = implode(PHP_EOL, $lines);
file_put_contents("./listas_tematicas/$nombreFichero.txt", $content);
?>