<?php require 'protect.php' ?>
<?php require 'conecta.php' ?>
<?php include 'menu'.$_SESSION['tipoUsu'].'.php';  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CSystem</title>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="funcoes.js"></script>
<script type="text/javascript" src="js/validate.js"></script>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<?php include 'links-tb.php'; ?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#valor").maskMoney({showSymbol:true,symbol:"R$", decimal:".", thousands:"", allowZero:true});
	});
</script>
</head>
<body>

<?php

if( isset($_GET['fornecedor']) and ($_GET['fornecedor'] != '') ){
	
	if(empty($_GET['fornecedor']) ){$ret = array("erro"=>"1","campo"=>"fornecedor"); _retorno($ret);}
	if(empty($_GET['valor']) ){$ret = array("erro"=>"1","campo"=>"valor"); _retorno($ret);}
	if(empty($_GET['vencimento']) ){$ret = array("erro"=>"1","campo"=>"vencimento"); _retorno($ret);}
	
	$fornecedor = $_GET['fornecedor'];
	$valor = $_GET['valor'];
	$vencimento = $_GET['vencimento'];
	$dataEmi = date('Y-m-d');
	
	$sql = "insert into pagar (fornecedor, valor, emissao, vencimento) 
	values ('$fornecedor', '$valor','$dataEmi', '$vencimento' )";
	
				
	if($resultado = mysql_query($sql)){
		$ret = array("erro"=>"0","msg"=>"Conta Gravada."); _retorno($ret);
	}else{
		$ret = array("erro"=>"2","campo"=>"SQL","msg"=>"Erro ao inserir a Conta"); _retorno($ret);
	}


}
?>


    	<!-- FORMULARIO CABEÇALHO DO PRODUTO  -->
<div  class="well">
<form name="formPagar" id="formPagar" method="post" action="" class="" onSubmit="return valida_form(this)">
	<h2>Lançamento - Contas a Pagar</h2>
        <br />

        <!--data -->
       <?php $dataEmi = date('d/m/Y'); ?>
       <span class="spanDate"> <b>Data: </b><?php echo $dataEmi; ?></span> 
       <!-- -->
    
  <!-- <a href="pesquisaProduto.php" class="btn btn-primary">Lista Produtos </a> -->
    <br />
  
	<p>
        <label for="fornecedor">
            Fornecedor:
        </label>
        <input class="fLeft" type="text" name="fornecedor" id="fornecedor" size="40" maxlength="9" value="" alt="valida" autofocus  required/>     
        <span class="spanFornecedor fLeft" ></span>
    </p>
    
    <div class="boxFornecedor w100" ></div>
    
    <br /><br />
    <p>
        <label for="valor">
            Valor:
        </label>
        <input type="text" name="valor" id="valor" size="40"  value="" alt="valida"  required/>     
    </p>
    
    <p>
        <label for="vencimento">
            Vencimento:
        </label>
        <input type="text" name="vencimento" id="vencimento" size="40" maxlength="10" value="" alt="valida" onkeypress="return formata(this,'##/##/####',event)"  required/>     
    </p>
    
    <!--<p>
    	<span class="descricao green"></span>
    </p>                -->
    
    <!--<input type="hidden" name="gravar" id="gravar" size="1" value="true" /> -->
    <input type="button"  name="submit" id="submit" value="Gravar" class="btn btn-inverse"/>    
 
    
    
</form>
</div>
		<!-- FIM DO FORMULARIO DESCRICAO DO produto  -->


<script type="text/javascript">

$("#fornecedor").bind("blur", function(){
	buscaFornecedor();
});

/*clico e seleciono um determinado fornecedor*/
$(".aNome").live("click",function(){
	var idFor = $(this).attr('id');
	var nomeFor = $(this).text();
	$(".spanFornecedor").css('color','green').text(nomeFor);
	$(".boxFornecedor").hide();
	$("#fornecedor").val('');
	$("#fornecedor").attr('disabled',true);
	$("#fornecedor").attr('data-id',idFor);	
	
});

$("#submit").bind("click",function(){		
	gravaPagar();
});


</script>

</body>
</html>