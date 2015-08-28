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
<?php error_reporting(0); ?>
<?php require 'menu'.$_SESSION['tipoUsu'].'.php'; ?>
<div id="" class="well">
<form name="formPesquisa" action="pesquisaVendedor.php" method="get" >
  <table>
  <tr>
    <td>Pesquisa:</td>
    <td><input type="text"  name="q" id="q" class="input-xlarge search-query"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
        <input type="submit" name="pesquisar" value="Pesquisar" class="btn btn-primary"/>
        <a class="btn" href="cadastraVendedor.php">Voltar</a>
    </td>
  </tr>
  </table>

</form>
<br />

<?php
if( isset($_GET['q']) ) {
	
	if ($_GET['q'] != "") {
		$sql = "select * from vendedor where nome like '%" . $_GET['q'] . "%'";
	}else{
		$sql = "select * from vendedor order by nome";
	}



$resultado = mysql_query($sql);
while($linha = mysql_fetch_array($resultado)) {
?>
  <tr>
    <td><a  href="cadastraVendedor.php?id=<?php echo $linha['idvendedor']; ?>"><?php echo $linha['nome']; ?> 
    		<img src="imagens/lapis.png" style="border:none" alt="editar">
        </a>
    
    </td>
   
  </tr>
  
<?php }} ?>

</table>
</div>
</body>
</html>