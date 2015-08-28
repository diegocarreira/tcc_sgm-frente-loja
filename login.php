<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<?php include 'links-tb.php'; ?>
</head>

<body onload="document.form1.usuario.focus()">

<form id="form1" name="form1" method="post" action="login.php" >

<div id="login" class="well">
	
	<table cellpadding="10" border="none" class="login font-login">
        <tr>
        <h1 align="center">SGM</h1>
        	<td style="font-style:oblique">Digite seu usuário e senha:</td>
        </tr>
        
        <tr>
            <td>
                <b> Usuário: </b> 
                <input type="text" name="usuario" id="usuario" autofocus />
            </td>
        </tr>
        
        <tr>
            <td>
                <b> Senha: </b>
                <input type="password" name="senha" id="senha" />
            </td>
        </tr>
        
        <tr>
            <td>
            	<input type="submit" name="entrar" id="entrar" value="Entrar" class="btn btn-primary"/>
            </td>
        </tr>
        
	</table>   
</div>     
        
</form>
</body>
</html>

<?php
	 // apaga todas as variaveis da sessao
	session_start();
	session_destroy();
	

if ($_POST ) {
	$usuario = $_POST['usuario'];
	$senha = $_POST['senha'];		
	
	
	if( $usuario == '' ) {
		echo '<span class="alert alert-danger top20">INFORME O NOME.</span>';		
		exit;
	}	
	if( $senha == '' ) {
		echo '<span class="alert alert-danger top20">INFORME A SENHA.</span>';		
		exit;
	}
	
	/**/
	$senha = md5('123' . $senha);

	
	require 'conecta.php'; 
	
	 $sql = "select * from usuario
			where (usuario = '$usuario')
			and (senha = '$senha')
			and ( STATUS = '1' )";
			
	$resultado = mysql_query($sql) or die(mysql_error());
	
	
	if (mysql_num_rows($resultado) <> 1 ) {
		echo '<span class="alert alert-danger top20">USUÁRIO OU SENHA INVÁLIDOS.</span>';	
		//header('location:login.php');
		exit;
	}
	
	$linha = mysql_fetch_assoc($resultado); //se meu retorno será apenas uma linha, não preciso usar um loop pra percorrer varias linhas(while)
	
	$usuario = $linha['usuario'];	
	$tipoUsu = $linha['tipo'];
	session_start();
	$_SESSION['usuario'] = $usuario;
	$_SESSION['tipoUsu'] =  $tipoUsu;
	$_SESSION['logado'] = true;
	
	
	header('location:index.php');
}

?>
