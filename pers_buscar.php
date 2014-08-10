<?php
$nom = $_POST['nomPer'];
$ali = $_POST['aliPer'];
$ape = $_POST['apePer'];
$raz = $_POST['razPer'];
$cla = $_POST['cla'];
$alin = $_POST['alin'];
$sex = $_POST['sex'];

if(($nom != "" && $nom != null) || ($ali != "" && $ali != null ) || ($ape != "" && $ape != null) || ($raz != "" && $raz != null) || ($cla != "" && $cla != null) || ($alin != "" && $alin != null) || ($sex != "" && $sex != null))
{
	$buscar = "select * from personajes where id_per = id_per";
	if($nom != "" && $nom != null){			
		$buscar = $buscar." and nombre like '%".$nom."%'";
	}
	if($ali != "" && $ali != null){
		$buscar = $buscar." and alias like '%".$ali."%'";
	}
	if($ape != "" && $ape != null){
		$buscar = $buscar." and apellidos = '%".$ape."%'";
	}
	if($raz != "" && $raz != null){
		$buscar = $buscar." and raza = '".$raz."'";
	}
	if($cla != "" && $cla != null){
		$buscar = $buscar." and clase = '".$cla."'";
	}
	if($alin != "" && $alin != null){
		$buscar = $buscar." and alineamiento = '".$alin."'";
	}
	if($sex != "" && $sex != null){
		$buscar = $buscar." and sexo = '".$sex."'";
	}
		
}
else{
	$buscar = "select * from personajes";
}
header('Location: http://localhost/dai/pers_lista.php?buscar='.$buscar);
?>