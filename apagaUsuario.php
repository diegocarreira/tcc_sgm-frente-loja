<?php
require 'protect.php';
require 'conecta.php'; 

if ( isset($_GET['id']) and ($_GET['id'] != '') ){	
	
	$id = $_GET['id'];
	
	$sql = "delete from usuario where idusuario = '$id'";
		
		if ( mysql_query($sql) )
		{
			
				header("location:usuarios.php");				
				
			}else {
				echo 'Erro ao excluir usuario!! '.mysql_error();
				exit();
			}
}







?>