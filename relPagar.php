<?php 
include 'protect.php'; 
include 'conecta.php';
?>

<?php

function dataToEua($data){
	$data2 = str_replace("/","-",$data);
	$data = date('Y-m-d', strtotime($data2));
	return $data;
}

function dataToBra($data){
	$data2 = date('d/m/Y', strtotime($data));
	return $data2;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Rel. Contas a Pagar em Atraso</title>
<link href="estilo.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="print.css" rel="stylesheet" type="text/css" media="print"/>
<?php include 'links-tb.php'; ?>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/validate.js"></script>
</head>

<body>
<?php require 'menu'.$_SESSION['tipoUsu'].'.php'; ?>
<?php error_reporting(0); ?>

<div id="pesquisa" class="well form-search">
<!--<form name="formPesquisa" action="" method="get" >
  <table class="noPrint">
  <tr>
    <td>Pesquisa:</td>
    <td><input class="input-xlarge search-query"  type="text"  name="q" id="q" onkeypress="return formata(this,'##/##/####',event)"  required autofocus/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    	<input type="submit" name="pesquisar" id="pesquisar" value="Pesquisar" class="btn btn-primary" />
    	<a class="btn" href="relReceber.php">Voltar</a>
    </td>
  </tr>
  </table>

</form> -->
<br />

<?php
/*if( isset($_GET['q'])) {
	
	if ($_GET['q'] != "") {	
		
	$data = dataToEua($_GET['q']);			
        
		$sql = "
			select * from receber
			where dataemi = '$data'
			order by status, idvenda
			";
	}else{
		//$sql = "select * from clifor where nome <> 'NULL' order by nome";
		
	}*/
	
		$hoje = date("Y-m-d");
		$sql = "
			select * from pagar
			where vencimento <= '$hoje'
			and status = '0'
			order by idpagar
			";


if($resultado = mysql_query($sql)){
	//echo 'okkkk';
}else{
	echo 'erooooooooooooooooooo'.mysql_error();
}
?>
<table class="table-condensed" style="border-collapse:separate; border-spacing:1px" >
 <tr class="formTitulo">
  	<td>Nº Conta:</td>
    <td>Fornecedor:</td>    
    <td>Valor:</td>
    <td>Emissão:</td>
    <td>Vencimento:</td>
  </tr>
  
<?php while($linha = mysql_fetch_array($resultado)) { ?>

    <td class="span2 textCenter">
        <?php echo $linha['idpagar']; ?>   
                
    </td>
    
    <?php 
		$cliente = $linha['fornecedor'];
		$result = mysql_query($sql = " select * from clifor where idclifor = '$cliente' ");
		$cliente = mysql_fetch_assoc($result); 
		if ($cliente['nome'] != 'NULL'){
			$cli = $cliente['nome'];
		}else{
			$cli = $cliente['razsoc'];
		}
	?>
    
    <td class="span2 textCenter"> <?php echo $cli; ?> </td>
    
        
    <td class="span2 textCenter">
	<?php
		echo str_replace(".",",",$linha['valor']);
	?>
    </td>
   
    <td class="span2 textCenter"> <?php echo dataToBra($linha['emissao']); ?> </td>
    
  	<td class="span2 textCenter"> <?php echo dataToBra($linha['vencimento']); ?> </td>
    

  </tr>
  
<?php /*}*/ }?>

</table>

</div>

</body>
</html>