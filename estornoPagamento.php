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


<div id="cadastro" class="well w50">
<form name="formEntrada" id="formEntrada" method="post" action="" class="" onSubmit="return valida_form(this)">
	<h2>Estorna Pagamento</h2>
        <br />
    
    <br />
  
	<p>
    <label for="fornecedor">
    	Fornecedor:
    </label>
    <input type="text" name="fornecedor" id="fornecedor" size="40" maxlength="9" value="" alt="valida" class="md" autofocus  required/>     
    </p>
    <br />
    
    <div class="boxClientes w100" ></div>
   
                        
    <p>
    	<span class="descricao green"></span>
    </p>
                   
  <a class="btBuscar btn btn-inverse">Buscar</a>
 
    
    
</form>
</div>
		<!-- FIM DO FORMULARIO DESCRICAO DO produto  -->


<script type="text/javascript">

/*--------- Busca----------------*/

$(".btBuscar").bind("click", function(){

	buscaPagamento();
});

function buscaPagamento(){
	var cliente = $("#fornecedor").val();
	$.get(
		"ajax3.php",
		{ cliente: cliente, origem:"buscaPagamento" },
		function(data){
			if (data == 'erro'){
				alert('erro');
				//$(".descricao").css('color','red');
				//$(".descricao").text(data.msg);	
				
			}else{
				//$(".descricao").css('color','#000');
				//var btEstornar = "<a class='btEstornar btn btn-danger'>Estornar</a>" ;
				$(".boxClientes").show();						
				$(".boxClientes").html(data);
				//$(".descricao").append("  "+btEstornar);
			}
	}, 'html');
}


/*--------- Estorno----------------*/

$(".btEstornar").live("click", function(){
	var id = $(this).attr('id');
	if (confirm("Estornar Pagamento?")){		
		estornaPagamento(id);
	}
});


function estornaPagamento(id){
	var id = id;
	$.get(
		"ajax3.php",
		{ codigo: id, origem:"estornaPagamento" },
		function(data){
			if (data.erro == '1'){
				alert('erro');
				$(".boxClientes").css('color','red');
				$(".boxClientes").html(data.msg);	
				
			}else{
			alert('ok');
				$(".boxClientes").css('color','green');
				$(".boxClientes").html(data.msg);
			}
	}, 'json');
	
}






</script>

</body>
</html>