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
<form name="formRecebimento" id="formRecebimento" method="post" action="" class="" onSubmit="return valida_form(this)">
	<h2>Recebimento</h2>
        <br />
    
     <!--data -->
   <?php $dataEmi = date('d/m/Y'); ?>
   <span class="spanDate"> <b>Data: </b><?php echo $dataEmi; ?></span> 
   <!-- -->

    <br />
  
	<p>
        <label for="cliente">
            Cliente:
        </label>
        <input type="text" class="fLeft" name="cliente" id="cliente" size="40" maxlength="9" value="" alt="valida" autofocus  required/>     
        <span class="spanCliente fLeft" ></span>
    
    </p>   
    
    <div class="boxClientes w100" ></div>
    
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

$("#cliente").bind("blur", function(){
	buscaCliente2();
});


/*clico e seleciono um determinado cliente*/
$(".aNome").live("click",function(){
	var idCli = $(this).attr('id');
	var nomeCli = $(this).text();
	$(".spanCliente").css('color','green').text(nomeCli);
	$(".boxClientes").hide();
	$("#cliente").val('');	
	$("#cliente").attr('data-id',idCli);	
	buscaCReceber(idCli);
	
});

/*clico em uma parcela para paga-la*/
$(".aConta").live("click", function(){
	var idParcela = $(this).attr('id');
	if( confirm("Confirma recebimento da parcela?") ){			
		receberParcela(idParcela);
	}
});


</script>

</body>
</html>