<?php
require 'protect.php';
require 'conecta.php';

$idusuario = (int) $_GET['idusuario'];
$status = $_GET['status'];

if ($status != '1'){
	$status = '0';
}

$sql = "update usuario set status = '$status' where idusuario = '$idusuario'";


mysql_query($sql);

header('location:usuarios.php');






?>