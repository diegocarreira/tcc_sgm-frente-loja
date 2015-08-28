<?php
session_start();
   if ( !isset ($_SESSION['logado']) ) {
      	header('location:login.php');
		exit;   
   }



function mensagem($tipo,$txt){

echo'
	<div class=" show alert alert-'.$tipo.'">
	  <a class="close" data-dismiss="alert" href="#">×</a>
	  <!-- <h4 class="alert-heading">Warning!</h4> -->
		'.$txt.'
	</div> ';
}




