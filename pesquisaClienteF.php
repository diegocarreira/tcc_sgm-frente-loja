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
<?php require 'menu'.$_SESSION['tipoUsu'].'.php'; ?>
<?php error_reporting(0); ?>

<div id="pesquisa" class="well form-search">
<form name="formPesquisa" action="pesquisaClienteF.php" method="get" >
  <table >
  <tr>
    <td>Pesquisa:</td>
    <td><input class="input-xlarge search-query"  type="text"  name="q" id="q" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    	<input type="submit" name="pesquisar" id="pesquisar" value="Pesquisar" class="btn btn-primary" />
    	<a class="btn" href="cadastraClienteF.php">Voltar</a>
    </td>
  </tr>
  </table>

</form>
<br />

<?php
if( isset($_GET['q'])) {
	
	if ($_GET['q'] != "") {
		$sql = "select * from clifor where nome like '%" . $_GET['q'] . "%'";
	}else{
		$sql = "select * from clifor where nome <> 'NULL' order by nome";
	}


$resultado = mysql_query($sql);
?>
<table class="table table-pesq" >
 <tr class="formTitulo">
  	<td>Nome:</td>
    <td>RG:</td>
    <td>Endereço:</td>    
    <td>Cidade:</td>
    <td>Fone:</td>
    <td>E-mail:</td>
  </tr>
  
<?php while($linha = mysql_fetch_array($resultado)) { ?>

   <tr>
    <td class="span4">
		<img src="imagens/lapis.png" style="border:none" alt="editar">
        <a  href="cadastraClienteF.php?id=<?php echo $linha['idclifor']; ?>"> <?php echo $linha['nome']; ?> </a>    
                
    </td>
    
    <td class="span2"> <?php echo $linha['ierg']; ?> </td>
    
    <td class="span2"> <?php echo $linha['endereco']; ?></td>
    
		<?php 
        $cid = $linha['cidade'];
        $result = mysql_query($sql = " select nome from cidade where idcid = '$cid' ");
        $cidade = mysql_fetch_assoc($result); 
        ?>
    
    <td class="span3"> <?php print_r( $cidade['nome']); ?> </td>
    
    <td class="span2">
        <?php 
			echo"(";
			echo $linha['telefone'][1] ; 
			echo $linha['telefone'][2] ; 
			echo")";
			echo $linha['telefone'] ; 
		?>
    </td>
    
    <td class="span2"> <?php echo $linha['email']; ?> </td>

  </tr>
  
<?php } }?>

</table>

</div>

</body>
</html>