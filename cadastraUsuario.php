<?php
require 'protect.php';
require 'conecta.php'; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Cadastro de usuario</title>
<link href="estilo.css" rel="stylesheet" type="text/css">
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
<form action="cadastraUsuario.php" method="post" class="form well">
    	<a href="usuarios.php" class="btn btn-primary" style="float:right; magin-top:-10px;">Pesquisa</a>   
        <br />
<h3>Cadastrar usuario</h3>
	<br />
    
 <label> Usuario </label>
  <input  type="text" name="usuario" id="usuario" alt="" required />
  <br>
  <label>Senha:</label>
  <input type="password" name="senha" id="senha" alt="" required />   
  <br>
  <label>Repita a senha:</label>
  <input type="password" name="resenha" id="resenha" alt="" required />
  <br>
  <br>
  <input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success">
</form>


<?php 

if($_POST) {

	$usuario = strtoupper($_POST['usuario']);
	$senha = $_POST['senha'];
	$resenha = $_POST['resenha'];
	
	$tipo = '2';
	$status = (int) '1';
	
	if( $usuario == '' ) {
		echo '<span class="alert alert-danger top10">INFORME O NOME.</span>';		
		exit;
	}	
	if( $senha == '' ) {
		echo '<span class="alert alert-danger top10">INFORME A SENHA.</span>';		
		exit;
	}
	if( $senha != $resenha ) {
		echo '<span class="alert alert-danger top10">SENHAS NÃO BATEM.</span>';		
		exit;
	}
	/*if( $tipo == '' ) {
		echo 'INFORME O TIPO.';		
		exit;
	}*/
	
	$senha = '123' . $senha;
	$senha = md5($senha);
	
	/**/
	$consulta = mysql_query( " select * from usuario where usuario = '$usuario' " );
	$numlinhas = mysql_num_rows($consulta);

	if($numlinhas >=1 ) {
		//echo '<span style="color:#F00">Já existe um usuário com esse login, por favor escolha outro nome.</span><br>'; exit();
		?> <script type="text/javascript"> alert("Já existe usuario cadastrado com esse login, por favor escolha outro nome"); history.back(); </script>  <?php		
		exit();			
	}else{	//faca a insercao

		$sql = "INSERT INTO usuario
		(usuario,tipo,senha,status)
		VALUES ('$usuario', '$tipo', '$senha', '$status')";
	}
	
	
	$resultado = mysql_query($sql);
	
	if($resultado === false) {
		echo 'OCORREU UM ERRO PARA CADASTRAR.<br>';
		echo mysql_error();
		exit();
	}
	
	header('location:usuarios.php');
}


?>







</body>
</html>
