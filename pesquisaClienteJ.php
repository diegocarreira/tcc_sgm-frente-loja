<?php include 'protect.php'; ?>
<?php include 'conecta.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pesquisa Cliente F</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<?php include 'links-tb.php'; ?>
</head>

<body>
<?php include 'menu'.$_SESSION['tipoUsu'].'.php'; ?> 
<?php error_reporting(0); ?>

<div id="pesquisa" class="well">
<form name="formPesquisa" action="pesquisaClienteJ.php" method="get" >
  <table>
  <tr>
    <td>Pesquisa:</td>
    <td><input type="text"  name="q" id="q" class="search-query input-xlarge"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="pesquisar" value="Pesquisar" class="btn btn-primary"/>
    <a class="btn" href="cadastraClienteJ.php">Voltar</a></td></td>
  </tr>
  </table>

</form>
<br />

<?php
if( isset($_GET['q'])) {
	
	if ($_GET['q'] != "") {
	$sql = "select * from clifor where razsoc like '%" . $_GET['q'] . "%'";
}else{
		$sql = "select * from clifor where razsoc <> '' order by razsoc";
}


$resultado = mysql_query($sql);
while($linha = mysql_fetch_array($resultado)) {
?>
<table >
  <tr >
    <td width="480px">
    	<a id="pesquisa" href="cadastraClienteJ.php?id=<?php echo $linha['idclifor']; ?>">
			<?php echo $linha['razsoc']; ?> [ <?php echo $linha['fantasia']; ?> ]	<img src="imagens/lapis.png" style="border:none" alt="editar" />
	    </a>
    </td>

  </tr>
  
<?php } }?>
</table>
</table>
</div>
</body>
</html>