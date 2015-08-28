<?php include 'protect.php'; ?>
<?php include 'conecta.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Prazos de Pgto.</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<?php include'links-tb.php'; ?>
</head>

<body>
<?php require 'menu'.$_SESSION['tipoUsu'].'.php'; ?>
<?php //error_reporting(0); ?>

<div  class="well">
<a  class="btn" href="cadastraPrazo.php">Voltar</a>
<br /><br />

<?php

	
	$sql1 = "SELECT * FROM prazo ";
	$result1 = mysql_query($sql1);
	
?> <table class="table table-pesq">
        <tr class="row">
            <td class="formTitulo">Descricao:</td> <td class="formTitulo">Dias:</td>
        </tr>
<?php
while($linha = mysql_fetch_array($result1) ) {
	$descricao = $linha['descricao'];
	
	
?>

	<tr class="row">    
        <td class="span2">
            <a href="cadastraPrazo.php?descricao=<?php echo $descricao;?>&id=<?php echo $linha['idprazo']; ?>">
                <?php echo $descricao; ?> <img src="imagens/lapis.png" style="border:none" title="editar">
            </a>     	     
        </td>
    
        <td>        
			<?php
				$idTitulo = $linha['idprazo'];
				$sql2 = "SELECT * FROM itemprazo WHERE prazo = '$idTitulo'";
				$result2 = mysql_query($sql2);
				while ($linha2 = mysql_fetch_array($result2) ){
				$item = $result2['dias'];			
		
				echo $linha2['dias']; 
			?>        
    
  
<?php } }?>
    </td>        
	</tr>
</table>

</div>
</body>
</html>