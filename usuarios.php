<?php
require 'protect.php';
require 'conecta.php'; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista de usuarios</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	table tr td{
		0border:1px solid #000;
		margin:0px;
		padding:5px;
		text-align:center;
			
	}
	
	.titulo{
		background:#069;	
		color:#FFF;
		font-weight:bold;
	}
	
</style>
<?php include 'links-tb.php'; ?>
</head>
<body>
<?php include 'menu'.$_SESSION['tipoUsu'].'.php';


if ( !$_SESSION['tipoUsu']  or $_SESSION['tipoUsu'] != '1' ){
	
		echo "Acesso não permitido para o usuário: ".$_SESSION['usuario'];	
		?> <a class="formBotao" style="color:#FFF;font-weight:bold;" href="index.php" >Voltar &nbsp;</a> <?php	
		exit();
	
	}
	

?>
<div  class="well w50" >
<a class="btn btn-primary" href="cadastraUsuario.php" style="float:right; text-align:center">Voltar</a>
<h3>Lista de usuarios</h3>
<table cellspacing="1px;" class="table table-bordered">
  <tr class="titulo">
    <td>CODIGO</td>
    <td>NOME</td>
    <td>TIPO</td>
    <td></td>
  </tr><?php
$sql = 'SELECT *
FROM usuario WHERE idusuario > 1
ORDER BY idusuario desc';
$resultado = mysql_query($sql);
while($linha = mysql_fetch_array($resultado)) {
?>

  <tr>
    <td><?php echo $linha['idusuario']; ?></td>
    <td><?php echo $linha['usuario']; ?></td>
    <td><?php echo $linha['tipo']; ?></td>
    <td>
      <!--<a href="cadastraUsuario.php?id=<?php echo $linha['idusuario']; ?>" title="Editar">
	  	<img src="imagens/editar.png" class="icone" />
	  </a> -->
      
      <a href="apagaUsuario.php?id=<?php echo $linha['idusuario']; ?>" title="Apagar">
     	 <img src="imagens/apagar.png" class="icone"/>
      </a>
      
      <?php if ($linha['status'] != 1){ ?>
      
      <a href="statusUsuario.php?idusuario=<?php echo $linha['idusuario']; ?>&status=1" title="Bloqueado">
      <img src="imagens/bloqueado.png" style="border:none">
      </a>
      <?php } else { ?>    
          
            
      <a href="statusUsuario.php?idusuario=<?php echo $linha['idusuario']; ?>&status=0" title="Liberado">
      <img src="imagens/liberado.png" style="border:none">
      </a>
      
      <?php } ?>
    </td>
  </tr>

<?php
}
?>
</table>
</div>

</body>
</html>
