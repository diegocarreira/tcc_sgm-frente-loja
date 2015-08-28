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
<link href="estilo.css" rel="stylesheet" type="text/css" />
<?php include 'links-tb.php'; ?>
</head>
<body>

    	<!-- FORMULARIO CABEÇALHO  -->
<div class="well">
<form name="formPagar" id="formPagar" method="post" action="" class="" onSubmit="return valida_form(this)">
	<h2>Pagamento</h2>
        <br />
    
     <!--data -->
   <?php $dataEmi = date('d/m/Y'); ?>
   <span class="spanDate"> <b>Data: </b><?php echo $dataEmi; ?></span> 
   <!-- -->

    <br />
  
	<p>
        <label for="fornecedor">
            Fornecedor:
        </label>
        <input type="text" class="fLeft" name="fornecedor" id="fornecedor" size="40" maxlength="9" value="" alt="valida" autofocus  required/>     
        <span class="spanFornecedor fLeft" ></span>
    
    </p>   
    
    <div class="boxFornecedor w100" ></div>
    
    <br /><br />   
                        
   <!-- <p>
    	<span class="descricao green"></span>
    </p> -->
    
    
    
   
    
    <input type="hidden" name="gravar" id="gravar" size="1" value="true" />
    <input type="button"  name="submit" id="submit" value="Pagar" class="btn btn-success"/>    
 
    
    
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
	$("#fornecedor").attr('data-id',idFor);	
	buscaCPagar(idFor);
	
});

/*clico em uma parcela para paga-la*/
$(".aConta").live("click", function(){
	var idParcela = $(this).attr('id');
	if( confirm("Confirma pagamento da parcela?") ){			
		pagarParcela(idParcela);
	}
});


</script>

</body>
</html>