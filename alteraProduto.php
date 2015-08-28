<?php //ob_start(); ?>
<?php require 'protect.php'; ?>
<?php require 'conecta.php'; ?>
<?php include 'menu'.$_SESSION['tipoUsu'].'.php';  ?>
<?php error_reporting(0);


// inicialização das variáveis
	$id = '';
	$descricao = '';
	$custo = '';
	$valor = '';
	

	//se recebo parametro de edição do cadastro para alteracao
if (isset($_GET['alt']) and $_GET['alt'] != '' ) {	
	$idpro = $_GET['alt'];
	
	$sql = "select * from produto where idpro = '$idpro' ";
	
	
	if( ! $resultado = mysql_query($sql) ) {
		//echo 'tipo doc INEXISTENTE'.mysql_error();		
		echo 'erro'.mysql_error();
	}
	$linha = mysql_fetch_array($resultado);
		$descricao = $linha['descricao'];
		$custo = $linha['custo'];
		$valor = $linha['valor'];
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CSystem - Altera Produto</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="funcoes.js"></script>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>

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
<?php include 'links-tb.php'; ?>
</head>
<body>
<!-- FORMULARIO CABEÇALHO DO PRODUTO  -->

<form name="formProduto" id="formProduto" method="get" action="" class="well" onSubmit="return valida_form(this)">
	<b>Produto</b>
    
    <br /><br />
    
  <a href="pesquisaProduto.php" class="btn btn-primary" >
  	Lista Produtos
  </a>
  <br />
    
	<p>
    <label for="nome">Descrição:</label>
    <input type="text" name="descricao" id="descricao" size="40" maxlength="40" value="<?php echo $descricao; ?>" alt="valida" autofocus  required />
	
    <?php if (isset($_GET['alt']) ) {?>
    	<a href="?excluir=true&amp;alt=<?php echo $idpro; ?>" onclick="return false;" class="btExcluir"><i class="btn" style="margin-top:-8px;" title="Excluir"><i class="icon-trash"></i></i></a>
     <?php } ?>
     
    </p>
    
    <p>
    <label for="nome">Custo:</label>
    <input type="text" name="custo" id="custo" size="20" value="<?php echo $custo; ?>" alt="valida"  required/>
    </p>
    
    <p>
    <label for="nome">Valor:</label>
    <input type="text" name="valor" id="valor" size="20"  value="<?php echo $valor; ?>" alt="valida"  required/>
    </p>
    
    <input type="hidden"  name="update" id="update" value="true" />
    <input type="hidden"  name="id" id="id" value="<?php echo $idpro; ?>" />
    <input type="submit"  name="submit" id="submit" value="Salvar" class="btn btn-success"/>    
 
</form>


<?php


if ( isset($_GET['excluir']) and ($_GET['excluir'] == true) ){	// [X] EXCLUIR PRODUTO (corpo e cabecalho)

	$alt = $_GET['alt'];
	
		$sql1 = "delete from itemproduto where idpro = '$alt'";
		$sql2 = "delete from produto where idpro = '$alt'";
		
		if ( mysql_query($sql1) )
		{
			if ( mysql_query($sql2) ){		  		 	
		
				header("location:cadastraProduto.php");
				
			}else {
				echo 'Erro ao excluir os dados do cabecalho!! '.mysql_error();
			}
		}else{
			echo 'Erro ao excluir os itens!! '.mysql_error();						
		}
							
}



if ( isset($_GET['update']) and $_GET['update'] == true ){	// [Update no cbecalho] Alterar o cabecalho de um produto
	if ($_GET['id']){
		
			$id = $_GET['id'];
		
			$descricao = strtoupper($_GET['descricao']);
			$custo = $_GET['custo'];
			$valor =$_GET['valor'];
			
			$sql = "update produto set descricao = '$descricao', custo = '$custo', valor = '$valor' where idpro = '$id' ";		
			
			if ( mysql_query($sql) ){
			 /* echo'<script type="text/javascript"> alert("Alterado com Sucesso.") </script>';
			  $sql = "select max(idpro) as id from produto";
			  $resultado = mysql_query($sql);
			  $resultado = mysql_fetch_assoc($resultado);
			  $id = $resultado['id']  ;*/
			
			  header("location:pesquisaProduto.php?descricao=$descricao&id=$id");				
			
			}else {
				echo 'Erro ao salvar os Dados!! '.mysql_error();
			}
	}
}
?>

<script type="text/javascript">
	$(".btExcluir").live("click",function(){
		var href = $(this).attr('href');
		if ( confirm("Excluir Produto?") ){
			window.location.href = href;
		}
	});
</script>

</body>
</html>