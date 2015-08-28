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
	<h2>Estorno</h2>
        <br />
    
    <br />
  
	<p>
    <label for="codigo">
    	Código:
    </label>
    <input type="text" name="codigo" id="codigo" size="40" maxlength="9" value="" alt="valida" class="pq" autofocus  required/>     
    </p>
    
   
                        
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

	buscaVenda();
});

function buscaVenda(){
	var codigo = $("#codigo").val();
	$.get(
		"ajax3.php",
		{ codigo: codigo, origem:"buscaVenda" },
		function(data){
			if (data.erro == '1'){

				$(".descricao").css('color','red');
				$(".descricao").text(data.msg);	
				
			}else{
				$(".descricao").css('color','#000');
				var btEstornar = "<a class='btEstornar btn btn-danger'>Estornar</a>" ;
				var descricao = data.cliente+" - "+data.dataemi;
				$("#codigo").attr('data-id',data.codigo);
				$(".descricao").text(descricao);
				$(".descricao").append("  "+btEstornar);
			}
	}, 'json');
}


/*--------- Estorno----------------*/

$(".btEstornar").live("click", function(){
	if (confirm("Estornar Venda?")){
		estornaVenda();
	}
});



function estornaVenda(){
	var codigo = $("#codigo").attr('data-id');
	$.get(
		"ajax3.php",
		{ codigo: codigo, origem:"estornaVenda" },
		function(data){
			if (data.erro == '1'){

				$(".descricao").css('color','red');
				$(".descricao").text(data.msg);	
				
			}else{
				$(".descricao").css('color','green');
				$(".descricao").text(data.msg);
			}
	}, 'json');
}






</script>

</body>
</html>