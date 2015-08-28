<?php require 'protect.php' ?>
<?php require 'conecta.php' ?>
<?php include 'menu'.$_SESSION['tipoUsu'].'.php';  ?>
<?php error_reporting(E_ERROR | E_PARSE);

	// inicialização das variáveis
	$id = '';
	$cliente = '';
	$nome = '';
	$rg = '';
	$cpf = '';
	$endereco = '';
	$bairro = '';
	$uf = '';
	$cidade = '';
	$nome_cidade = '';
	$cep = '';
	$celular = '';
	$telefone = '';
	$email = '';
	$status = '';
	$tipo = '';
	$linha_cidade['nome'] = '';
	$linha_cidade['sigla'] = '';


	//se recebo parametro de edição da pesquisa
	
	if (isset($_GET['id']) ) {	
		$id = (int) $_GET['id'];
		
		$sql = "select * from clifor where idclifor = '$id'";
		
		$resultado = mysql_query($sql);
		if(mysql_num_rows($resultado) == 0) {
			//echo 'CLIENTE INEXISTENTE'.mysql_error();
			header('location:pesquisaClienteF.php');
			exit;
		}
		$linha = mysql_fetch_array($resultado);
		
		$cliente = $linha['cliente'];
		$nome = $linha['nome'];
		$rg = $linha['ierg'];
		$cpf = $linha['cnpjcpf'];
		$endereco = $linha['endereco'];
		$bairro = $linha['bairro'];
		$uf = $linha['uf'];
		$cidade = $linha['cidade'];	
		$cep = $linha['cep'];
		$celular = $linha['celular'];
		$telefone = $linha['telefone'];
		$email = $linha['email'];
		$status = $linha['status'];
		$tipo = $linha['tipo'];
	
		$sql_cidade = "select cidade.nome, cidade.idcid, uf.sigla, uf.iduf from cidade,uf 
		where cidade.idcid = '$cidade' and uf.iduf = '$uf'" ;
			$resultado_cidade = mysql_query($sql_cidade);
			$linha_cidade = mysql_fetch_array($resultado_cidade);	
			
			 $uf = $linha_cidade['iduf'];
			 $sigla = $linha_cidade['sigla'];
			 
			$id_cidade = $linha_cidade['idcid'];
			 $nome_cidade = $linha_cidade['nome'];
			


	}

//salvar Cliente

if ($_POST['salvar']){

	$id = (int) $_POST['id'];
		
	$nome = strtoupper($_POST['nome']);
	$rg = $_POST['rg'];
	$cpf = $_POST['cpf'];
	$endereco = strtoupper($_POST['endereco']);
	$bairro = strtoupper($_POST['bairro']);
	$uf = $_POST['uf'];
	$cidade = $_POST['idcidade'];
	$cep = $_POST['cep'];
	$celular = $_POST['celular'];
	$telefone = $_POST['telefone'];
	$email = strtoupper($_POST['email']);
	$status = $_POST['status'];
	$tipo = "C";

	/* validação no php */
		if(empty($_POST['nome']) ){	echo "Preencha o campo nome."; exit;}
		if(empty($_POST['rg']) ){	echo "Preencha o campo rg."; exit;}
		if(empty($_POST['cpf']) ){	echo "Preencha o campo cpf."; exit;}
		if(!validaCPF($_POST['cpf']) ){	echo "CPF Inválido."; exit;}
		if(empty($_POST['endereco']) ){	echo "Preencha o campo endereco."; exit;}
		if(empty($_POST['bairro']) ){	echo "Preencha o campo bairro."; exit;}
		if(empty($_POST['uf']) ){	echo "Preencha o campo uf."; exit;}
		if(empty($_POST['cidade']) ){	echo "Preencha o campo cidade."; exit;}
		if(empty($_POST['cep']) ){	echo "Preencha o campo cep."; exit;}
	
	/**/
	
	if( $id == 0 ) {
				
		/**/
		$consulta = mysql_query( " select * from clifor where cnpjcpf = '$cpf' or ierg = '$rg' " );
		$numlinhas = mysql_num_rows($consulta);
	
		if($numlinhas >=1 ) {
			
			?> 
				<script type="text/javascript"> 
					alert("Já existe um cliente cadastrado com esses dados, por favor revise o cpf e o rg."); 
					window.history.back(); 					
                </script> 
			<?php	
			exit();	 
		
		}else{	//faca a insercao
			
				$sql = "insert into clifor (nome,ierg,cnpjcpf,endereco,bairro,uf,cidade,cep,celular,telefone,email,status,tipo) 
			values ('$nome','$rg','$cpf','$endereco','$bairro','$uf','$cidade','$cep','$celular','$telefone','$email','$status','$tipo')";
		}
	}
	else {
		$sql = "UPDATE clifor SET nome='$nome', ierg='$rg', cnpjcpf='$cpf', endereco='$endereco', bairro='$bairro', uf='$uf', cidade='$cidade',
				cep='$cep',celular= '$celular', telefone='$telefone', email='$email', status='$status' WHERE idclifor=$id";
	}
	
	
	if ( mysql_query($sql) ){
		 echo'
		<script type="text/javascript"> 
		 	alert("Salvo com Sucesso.") 
			window.location.href = "cadastraClienteF.php ";
		</script>
		 
		 ';	
		 //header('location:cadastraClienteF.php');				
		}else {
			echo 'Erro ao salvar os Dados!! '.mysql_error();
		}


	

}

	
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CSystem</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="funcoes.js"></script>
<?php include 'links-tb.php'; ?>
</head>
<body onLoad="document.formClienteF.nome.focus()">
<!--onload="document.formClienteF.cpf.focus()"-->
<div id="cadastro" class="well" >

	<form name="formClienteF" id="formClienteF"  method="post" action="cadastraClienteF.php" class="" onSubmit="return valida_form(this)"  > 
    <fieldset class="">
	<b>Pessoa Física</b>
    <font class="red right">* campos obrigatórios</font>
    
    <br /><br />
 
    <a href="pesquisaClienteF.php" class="btn btn-primary" >Pesquisa</a>   
    
	<p>
        <label for="nome">
            Nome:<font class="red">*</font>
        </label>
        <input class="" type="text" name="nome" id="nome" size="40" maxlength="40" value="<?php echo $nome; ?>" alt="valida"  autofocus required/>
    </p>
    
	<p><label for="rg">
    	RG:<font class="red">*</font>
    </label>
<input class="" type="text"  name="rg" id="rg" size="40" maxlength="9" placeholder="" value="<?php echo $rg; ?>" alt="valida" required/></p>
    
	<p><label  class="control-label" for="cpf">
    	CPF:<font class="red">*</font>
    </label>
    <input type="text" name="cpf" id="cpf" size="40" maxlength="11" placeholder="apenas os numeros" value="<?php echo $cpf; ?>"  alt="valida" onBlur="verifica_CPF(formClienteF)" required class="control-group alert-error"/></p>
    
	<p><label for="endereco">
    	Endereço:<font class="red">*</font>
    </label>
    <input type="text" name="endereco" id="endereco" size="40" maxlength="40"  value="<?php echo $endereco; ?>"  alt="valida" required/></p>    	
    
	<p><label for="bairro">
    	Bairro:<font class="red">*</font>
    </label>
    <input type="text" name="bairro" id="bairro" size="40" maxlength="30" value="<?php echo $bairro; ?>" alt="valida" required /></p>
    
    
	 <p><label for="uf">
     	UF:<font class="red">*</font>
     </label>
    <select name="uf" id="uf" size="1" maxlength="2" alt="valida" onChange="abreJanela(uf.value,form.name)">		
            <option value="<?php echo $uf; ?>"><?php echo $sigla; ?></option>
                <?php
                    $sql = "select iduf,sigla from uf where iduf <> '$uf' order by descricao";
                    $resultado = mysql_query($sql);
                    while( $linha = mysql_fetch_array($resultado) ) {
                ?>
            <option value="<?php echo $linha['iduf']; ?>"><?php echo $linha['sigla']; ?></option>
                <?php } ?>      
    </select>
    </p>


    
    <p><label for="cidade">
    	Cidade:<font class="red">*</font>
    </label>
    	<input type="hidden" name="idcidade" id="idcidade" value="<?php echo $cidade; ?>"/>
    <input type="text" name="cidade" id="cidade" size="40" maxlength="40" value="<?php echo $nome_cidade; ?>" alt="valida" readonly
    onclick="abreJanela(uf.value,form.name)" required/></p>
    
   
	<p><label for="cep">
    	CEP:<font class="red">*</font>
    </label>
    <input type="text" name="cep" id="cep" size="40" maxlength="8" placeholder="apenas os numeros"  value="<?php echo $cep; ?>"  
    alt="valida" required/>
    </p>
    
    <p><label for="celular">Celular:</label>
    <input type="text" name="celular" id="celular" size="40" maxlength="10"  value="<?php echo $celular; ?>" alt="" /></p>

	<p><label for="telefone">Telefone:</label>
    <input type="text" name="telefone" id="telefone" size="40" maxlength="11"  value="<?php echo $telefone; ?>" alt="" /></p>
    
    </p><label for="email">E-mail:</label>
    <input type="text" name="email" id="email" size="40" maxlength="60" value="<?php echo $email; ?>" alt="" /></p>
    
   
    <p><label for="status">Status:</label>
    <input type="radio" name="status" id="status" value="1" checked="checked"  /><code>Ativo</code>    
    <input type="radio" name="status" id="status" value="2" /><code>Inativo</code>
    </p>    
   
    
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
    
    <input type="submit"  name="salvar" id="salvar" value="Salvar" class="btn btn-success"/>
    <a href="cadastraClienteF.php" class="btn" >Novo</a>
<!--    <input type="reset" name="limpar" id="limpar" value="Limpar"  class="formBotao"/>
-->
 </fieldset>   
</form>
</div>




</body>
</html>