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

<?php

if( isset($_POST['gravar'])  ){
	
	$barras = $_POST['barras'];
	$qtd = $_POST['qtd'];
	
	if ($qtd < 0 ){
		?> 
			<script type="text/javascript"> 
				alert("Quantidade deve ser positiva."); 
				window.history.back(); 					
			</script> 
		<?php	
		exit();
	}
	if ( !is_numeric($qtd) ){
		?> 
			<script type="text/javascript"> 
				alert("Quantidade deve ser numérica."); 
				window.history.back(); 					
			</script> 
		<?php	
		exit();
	}	

	$sql = "select estoque from itemproduto where barras = '$barras' ";
	$linha = mysql_fetch_assoc($resultado = mysql_query($sql));
	$oldQtd = $linha['estoque'];
	$newQtd = ( (int) $oldQtd + (int) $qtd );	
	
	$sql = "update itemproduto set estoque = '$newQtd' where barras = '$barras' ";
	
	if($resultado = mysql_query($sql)){
		echo' <script type="text/javascript"> alert("Produto Salvo com Sucesso"); </script> ';
	}else{
		echo' <script type="text/javascript"> alert("Erro"); </script> ';
	}


}
?>


    	<!-- FORMULARIO CABEÇALHO DO PRODUTO  -->
<div id="cadastro" class="well w50">
<form name="formEntrada" id="formEntrada" method="post" action="" class="" onSubmit="return valida_form(this)">
	<h2>Entrada de produtos</h2>
        <br />
    
  <!-- <a href="pesquisaProduto.php" class="btn btn-primary">Lista Produtos </a> -->
    <br />
  
	<p>
    <label for="barras">
    	Código:
    </label>
    <input type="text" name="barras" id="barras" size="40" maxlength="9" value="" alt="valida" autofocus  required/>     
    </p>
    
   
                        <!--
                            <p>
                            <label for="tam">
                                Tam:
                            </label>
                            <select name="tam" id="tam">
                                <option value=""></option>
                            </select>
                            </p>
						-->    
                        
                        
    <p>
    	<span class="descricao green"></span>
    </p>
    
    
    
    <p>
    <label for="qtd">
    	Quantidade:
   </label>
    <input type="text" name="qtd" id="qtd" size="20" value="" alt="valida" required/>
    </p>
    
    <input type="hidden" name="gravar" id="gravar" size="1" value="true" />
    <input type="submit"  name="submit" id="submit" value="Gravar" class="btn btn-inverse"/>    
 
    
    
</form>
</div>
		<!-- FIM DO FORMULARIO DESCRICAO DO produto  -->


<script type="text/javascript">

$("#barras").bind("blur", function(){
	//var barras = $("#barras").attr('value');
	buscaProduto();
});

function buscaProduto(){
	var barras = $("#barras").val();
	$.get(
		"ajax.php",
		{ barras: barras, origem:"entradaPro" },
		function(data){
			if (data['erro'] == '1'){

				$(".descricao").css('color','red');
				$(".descricao").text(data.msg);	
				
			}else{
				$(".descricao").css('color','green');
				var descricao = data.descricao+" - "+data.tam;
				$(".descricao").text(descricao);
			}
	}, 'json');
}
</script>

</body>
</html>