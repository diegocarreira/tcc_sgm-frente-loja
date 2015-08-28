<?php include 'protect.php'; ?>
<?php include 'conecta.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pesquisa Tipo Doc.</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<?php include 'links-tb.php'; ?>
</head>

<body>
<?php require 'menu'.$_SESSION['tipoUsu'].'.php'; ?>
<?php error_reporting(0); ?>

<div id="" class="well form-search">
<form name="formPesquisa" action="pesquisaTipoDocumento.php" method="get" >
  <table>
  <tr>
    <td>Pesquisa:</td>
    <td><input type="text"  name="q" id="q" class="input-xlarge search-query"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    	 <input type="submit" name="pesquisar" value="Listar" class="btn btn-primary"/> 
    	<a class="btn" href="cadastraTipoDocumento.php">Voltar</a> 
    </td>
  </tr>
  </table>

</form>
<br />

<?php
if( isset($_GET['q'])) {
	
	
	$sql = "select * from tipodocumento where descricao like '%" . $_GET['q'] . "%'";
}


$resultado = mysql_query($sql);
while($linha = mysql_fetch_array($resultado)) {
?>
<table class="table table-pesq">
  <tr >
    <td >        
        <a id="pesquisa" href="cadastraTipoDocumento.php?id=<?php echo $linha['idtipodoc']; ?>" title="editar">
		<img src="imagens/lapis.png" style="border:none" title="editar">
		<?php echo $linha['descricao']; ?> </a>
    </td>

  </tr>
  
<?php } ?>
</table>
</table>
</div>
</body>
</html>