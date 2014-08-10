<?php
function Conectarse(){
	if (!($link= mysql_connect("mysql.hostinger.es","u565303011_pepe","lassillas2"))){
		echo "Error conectando a la base de datos.";
		exit();
	}
	if (!mysql_select_db("u565303011_friki",$link)){
		echo "Error seleccionando la base de datos.";
		exit();
	}
	return $link;
}
?>