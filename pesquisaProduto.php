<?php include 'protect.php'; ?>
<?php include 'conecta.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Produtos</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<?php include'links-tb.php'; ?>
</head>

<body>
<?php require 'menu'.$_SESSION['tipoUsu'].'.php'; ?>
<?php //error_reporting(0); ?>

<div class="well">
<a  class="btn" href="cadastraProduto.php">Voltar</a>
<br /><br />

<?php

	
	$sql1 = "SELECT * FROM produto ";
	$result1 = mysql_query($sql1);
	
?> <table class="table table-pesq">
        <tr class="formTitulo row">
            <td>Descricao:</td>
            <td>Tam-qtd:</td>
            
        </tr>
<?php
while($linha = mysql_fetch_array($result1) ) {
	$descricao = $linha['descricao'];
	
	
?>

	<tr class="row">    
        <td class="span4">
            <a class="" href="cadastraProduto.php?descricao=<?php echo $descricao;?>&id=<?php echo $linha['idpro']; ?>&alt=1">
                <?php echo $descricao; ?> <img src="imagens/lapis.png" style="border:none" title="editar">
            </a>     	     
        </td>
    
        <td class="span4">        
			<?php
				$idTitulo = $linha['idpro'];
				$sql2 = "SELECT * FROM itemproduto WHERE idpro = '$idTitulo'";
				$result2 = mysql_query($sql2);
				while ($linha2 = mysql_fetch_array($result2) ){
				//$item = $result2['tam'];			
		
				echo $linha2['tam']; 
				echo' - ';
				echo $linha2['estoque']; 
				echo' / ';
			?>        
    	
<?php } }?>
    </td> 
    	<td>
					
        </td>       
	</tr>
</table>

</div>
</body>
</html>