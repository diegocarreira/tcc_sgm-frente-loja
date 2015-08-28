<?php ob_start(); ?>
<?php require 'protect.php'; ?>
<?php require 'conecta.php'; ?>
<?php include 'menu'.$_SESSION['tipoUsu'].'.php';  ?>
<?php error_reporting(0);

	// inicialização das variáveis
	$id = '';
	$descricao = '';
	$custo = '';
	$valor = '';
	
/*
	//se recebo parametro de edição da pesquisa
if (isset($_GET['alt']) and $_GET['alt'] != '' ) {	
	$idpro = $_GET['alt'];
	
	$sql = "select * from produto where idpro = '$idpro' ";
	
	$resultado = mysql_query($sql);
	if(mysql_num_rows($resultado) == 0) {
		//echo 'tipo doc INEXISTENTE'.mysql_error();		
		exit;
	}
	$linha = mysql_fetch_array($resultado);
		$descricao = $linha['descricao'];
		$custo = $linha['custo'];
		$valor = $linha['valor'];
	
}*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CSystem</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<?php include 'links-tb.php'; ?>
<script type="text/javascript" src="funcoes.js"></script>
<script type="text/javascript" src="js/jquery1.6.4.js"></script>

<script type="text/javascript" >
$(document).ready(function(){
	$("#custo").maskMoney({showSymbol:true,symbol:"R$", decimal:".", thousands:"", allowZero:true});
	$("#valor").maskMoney({showSymbol:true,symbol:"R$", decimal:".", thousands:"", allowZero:true});
});

///////////

function valida_form(ele){
	numero = ele.elements.length
	erro = "";
	for(i=0; i<numero; i++){
		if(ele.elements[i].alt == "valida"){
			if(ele.elements[i].name == "email" || ele.elements[i].name == "e-mail" || ele.elements[i].name == "mail"){
				if(ele.elements[i].value.indexOf('@')==-1 || ele.elements[i].value.indexOf('.')==-1){
				erro = erro + "Preencha o campo '"+ ele.elements[i].name.toUpperCase() +"' corretamente. \n"
				}
			}else{
				if(ele.elements[i].value==""){
				erro = erro + "Preencha o campo '"+ ele.elements[i].name.toUpperCase() +"'. \n"
				}
			}
		}
		if(ele.elements[i].title == "valida"){
			if(ele.elements[i].value==""){
			erro = erro + "Preencha o campo '"+ ele.elements[i].name.toUpperCase() +"'. \n"
			}
		}
		
		
	}

	if(erro != ""){
		alert("Atenção:\n"+erro);
		return false
	}else{
		return true
	}
}

</script>
</head>
<body onload="document.formItemProduto.tam.focus()">
<!--onload="document.formClienteF.cpf.focus()"-->
<?php 
//pra saber se devo mostra o form de cabecalho ou item (se tiver descricao no get mostro o item, senao mostro o cabecalho
	if (!isset($_GET['descricao'] )){ 
 ?>
 
 
		<!-- FORMULARIO CABEÇALHO DO PRODUTO  -->
<div id="cadastro" class="well">
<form name="formProduto" id="formProduto" method="get" action="cadastraProduto.php" class="" onSubmit="return valida_form(this)">
	<b>Produto</b>
    <font class="red right">* campos obrigatorios</font>
    
    <br /><br />
    
  <a href="pesquisaProduto.php" class="btn btn-primary">Lista Produtos </a>
    <br /><br />

    
    
   <!-- <p>
    <label for="idPro">Código do produto:</label>
    <input type="text" name="idpro" id="idpro" size="20" maxlength="20" value="" alt="valida"  />
    </p>-->
    
	<p>
    <label for="nome">
    	Descrição:<font class="red">*</font>
    </label>
    <input type="text" name="descricao" id="descricao" size="40" maxlength="40" value="<?php echo $descricao; ?>" alt="valida" autofocus  required/>     
    </p>
    
    <p>
    <label for="nome">
    	Custo:
    </label>
    <input type="text" name="custo" id="custo" size="20"  value="<?php echo $custo; ?>" alt="valida"  required/>
    </p>
    
    <p>
    <label for="nome">
    	Preço:<font class="red">*</font>
   </label>
    <input type="text" name="valor" id="valor" size="20" value="<?php echo $valor; ?>" alt="valida" required/>
    </p>
    
    <input type="hidden"  name="proximo" id="proximo" value="true" />
    <input type="submit"  name="submit" id="submit" value="Próximo>>" class="btn btn-inverse"/>    
 
    
    
</form>

		<!-- FIM DO FORMULARIO DESCRICAO DO produto  -->


<?php }else if ( $_GET['descricao'] != '' && ($_GET['valor'] > 0 || $_GET['alt'] == '1' )  ){ 
	$id = $_GET['id'];
	$descricao = $_GET['descricao'];
	// implementar custo e valor
?>
	
		<!-- FORMULARIO ITEM PRODUTO  -->
	<div class="well">        
	<form name="formItemProduto" id="formItemProduto" method="get" action="cadastraProduto.php"  onSubmit="return valida_form(this)">
	
    <h3>Tamanhos do Produto</h3>
  <a class="btn" href="cadastraProduto.php">Voltar</a>
  <br /> <br />
        
  <b>Item Produto:</b>
  <a class="label label-info" href="alteraProduto.php?alt=<?php echo $id; ?>"><?php echo $_GET['descricao'];?>   
  </a><br /> <!--Aqui eu mando o cara pra alterar o cabecalho-->
    
    
   <br />
    <?php 		

		$sql = "select * from itemproduto where idpro = $id";
		if ( mysql_query($sql) ){	
			$resultado = mysql_query($sql);	  
			$numlinhas = mysql_num_rows($resultado);
			$i = 0;
			if (!empty($numlinhas) ){
			echo ' <table class="table table-pesq"> ';
				while($linha = mysql_fetch_array($resultado)){
					$i++;
					?>
                    	<tr class="row">
                        	<td class="span2">							
                            	<?php echo "tamanho ".$i." = ".$linha['tam']; ?>							
                        	</td>
                            <td>
<a href="cadastraProduto.php?id=<?php echo $id;?>&descricao=<?php echo $descricao;?>&tam=<?php echo $linha['tam']; ?>">
                                    <img src="imagens/delete.gif" style="border:none" alt="editar">
                              </a>
                              	
                             <?php /*?>   <input type="text" name="iditem" id="iditem" value="<?php echo $linha['iditem'] ?>">
								<input type="submit"  name="excluir" value="excluir" title="Excluir" />
                                 <?php */?>
                          </td>
	                  </tr>
                  <?php
				}
				?> <table> <?php
			}
		}
	 ?>
  
  <p>
    <label for="tam">Tam:</label>    
    <input type="text" name="tam" id="tam" size="4" maxlength="4" alt="valida" required autofocus/>
    <br />
   
    <label for="estoqueIni">Estoque Inicial:</label>    
    <input type="text" name="estoqueIni" id="estoqueIni" size="4" maxlength="4" class="pq" alt="valida" required />
    <br />
    
    <label for="barras">Código de Barras:</label>    
    <input type="text" name="barras" id="barras" size="4" maxlength="9" class="pq" alt="valida" required />
   
   <br />
        	
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
    <input type="hidden" name="descricao" id="descricao" value="<?php echo $descricao; ?>" />
    
    <input type="hidden"  name="add" id="add" value="true" />

    <input type="submit"  name="submit2" id="submit2" value="+ add"  class="btn btn-success"/><br /><br />
  </p>
    <!-- <input type="submit"  name="salvar" id="salvar" value="Salvar" class="formBotao"/>
       	 <input type="reset" name="limpar" id="limpar" value="Limpar"  class="formBotao"/>
    -->
        
    </form>
    </div>
    <!-- FIM DO FORMULARIO ITEM PRODUTO  -->



<?php } ?>

<!-- INICIO DAS VERIFICAÇÕES  -->

<?php  //salvar descricao e valores do produto

if ( isset($_GET['proximo']) and ($_GET['proximo'] == true) ){
	
	/* validação no php */
		if(empty($_GET['descricao']) ){	echo "Preencha o campo descricao."; exit;}
		//if(empty($_GET['custo']) ){	echo "Preencha o campo custo."; exit;}
		if(empty($_GET['valor']) || $_GET['valor'] <= 0 ){	echo "Preencha o campo valor."; exit; break;}		
	
	/**/
	
	$descricao = strtoupper($_GET['descricao']);
	$custo = $_GET['custo'];
	$valor =$_GET['valor'];
		
	
	/**/
	$consulta = mysql_query( " select * from produto where descricao = '$descricao' " );
	$numlinhas = mysql_num_rows($consulta);

	if($numlinhas >=1 ) {
		
		?> 
			<script type="text/javascript"> alert("Já existe produto cadastrado com essa descricao."); window.history.back(); </script> 
		<?php
		exit();		 
	
	}else{	//faca a insercao
	
		$sql = "insert into produto (descricao,custo,valor) values ('$descricao',$custo,$valor)";
	}
	
	if ( mysql_query($sql) ){
	  $sql = "select max(idpro) as id from produto";
	  $resultado = mysql_query($sql);
	  $resultado = mysql_fetch_assoc($resultado);
	  $id = $resultado['id']  ;
	
	  header("location:cadastraProduto.php?descricao=$descricao&valor=$valor&id=$id");				
	
	}else {
		echo 'Erro ao salvar os Dados!! '.mysql_error();
	}

}

if ( isset($_GET['add']) and ($_GET['add'] == true) ){	//salvar ITEM de produto

	

	$tam = $_GET['tam'];
	$id = $_GET['id'];
	$descricao = $_GET['descricao'];
	$estoqueIni = $_GET['estoqueIni'];
	$barras = $_GET['barras'];
	
	if ($estoqueIni < 0){
	?> 
		<script type="text/javascript"> 
            alert("Estoque de ser maior ou igual a zero."); 
            window.history.back(); 					
        </script> 
    <?php	
    exit();
	}
	/*//////////// vewrifica o codigo de barras nao e negativo ou zero /////////// */
	if ($barras < 0 || $barras < 1){
	?> 
		<script type="text/javascript"> 
            alert("Preencha o Código de Barras Corretamente."); 
            window.history.back(); 					
        </script> 
    <?php	
    exit();
	}
	
	
	
	/* validação no php */
		if(empty($_GET['tam']) ){	echo "Preencha o campo tam."; exit;}
		if( $_GET['estoqueIni'] < 0 || $_GET['estoqueIni'] == '' ){	echo "Preencha o campo estoqueIni."; exit;}
		if(empty($_GET['barras']) || $_GET['barras'] < 1 ){echo "Preencha o campo Código de Barras."; exit; break;}		
	
	/**/
	/*testa integridade do codigo de barras*/
		$consulta = mysql_query( " select * from itemproduto where barras = '$barras'" );
		$numlinhas = mysql_num_rows($consulta);
	
		if($numlinhas >=1 ) {
			
			?> 
				<script type="text/javascript"> 
					alert("Código de Barras já usado, digite outro código."); 
					window.history.back(); 					
                </script> 
			<?php	
			exit();	 
		
		}else{	//faca a insercao

			$sql = "insert into itemproduto (idpro,tam, estoque,barras) values ($id,'$tam',$estoqueIni,$barras)";
			if  ($resultado = mysql_query($sql)){
				
				header("location:cadastraProduto.php?descricao=$descricao&id=$id&alt=1");				
				exit();
				
			}else{
				$erro = mysql_error();
				?>
                <script type="text/javascript">
					console.log("<?php echo $erro; ?>");
				</script>
                <?php
				 exit;
			}
		}
	
	
	
	

}

if ( isset($_GET['tam']) and ($_GET['tam'] == true) ){	// [X] EXCLUIR item de produto
		
	$id = ($_GET['id']); //id do prazo
	$descricao = ($_GET['descricao']);
	$tam = ($_GET['tam']);

	$sql = "delete from itemproduto where idpro = $id and tam = $tam";
	
	if ( mysql_query($sql) )
	{		  		 	

		header("location:cadastraProduto.php?descricao=$descricao&id=$id&alt=1");				
		
	}else {
		echo 'Erro ao salvar os Dados!! '.mysql_error();
	}



}





?>
</div>

</body>
</html>