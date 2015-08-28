<?php ob_start(); ?>
<?php require 'protect.php'; ?>
<?php require 'conecta.php'; ?>
<?php include 'menu'.$_SESSION['tipoUsu'].'.php';  ?>
<?php error_reporting(E_ERROR | E_PARSE);

	// inicialização das variáveis
	$id = '';
	$descricao = '';
	


/*	//se recebo parametro de edição da pesquisa
if (isset($_GET['pesquisa']) ) {	

	
	$sql = "select * from prazo ";
	
	$resultado = mysql_query($sql);
	if(mysql_num_rows($resultado) == 0) {
		//echo 'tipo doc INEXISTENTE'.mysql_error();		
		exit;
	}
	$linha = mysql_fetch_array($resultado);
	
}*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CSystem</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="funcoes.js"></script>
<?php include'links-tb.php'; ?>
</head>
<body onload="document.formItemPrazo.dias.focus()">


<div id="cadastro">
<?php 
	if (!$_GET){
 ?>
 
		<!-- FORMULARIO DESCRICAO DO PRAZO  -->
<div id="cadastro" class="well">

    <form name="formPrazo" id="formPrazo" method="get" action="cadastraPrazo.php" class="" onSubmit="return valida_form(this)">
        <b>Prazo de Pagamento</b>
        
        <br /><br />
        
       <a href="pesquisaPrazo.php" class="btn btn-primary" >Lista Prazos</a>
       <br />
        
        
        <p><label for="nome">Descrição:</label>
        <input type="text" name="descricao" id="descricao" size="20" maxlength="20" value="" alt="valida" required autofocus/>		 	</p>
        
        <input type="submit"  name="proximo" id="proximo" value="Proximo>>" class="btn btn-inverse"/>
    <!--    <input type="reset" name="limpar" id="limpar" value="Limpar"  class="formBotao"/>
    -->
        
    </form>
</div>
		<!-- FIM DO FORMULARIO DESCRICAO DO PRAZO  -->


<?php }else if ($_GET['descricao'] != '' ){ 
	$id = $_GET['id'];
	$descricao = ($_GET['descricao']);
?>
	
		<!-- FORMULARIO ITEM PRAZO  -->
      <div class="well">
	<form name="formItemPrazo" id="formItemPrazo" method="get" action="cadastraPrazo.php"  onSubmit="return valida_form(this)">
	
    <h3>Dias do Prazo de Pagamento</h3>
    <a class="btn" href="cadastraPrazo.php">Voltar</a>
    <br /> <br />
    
    <b>Prazo:</b>
    <a class=" label label-info">
    	<?php echo $_GET['descricao']; ?>
    </a>
            
   <br /> <br />
    <?php 		

		$sql = "select * from itemprazo where prazo = $id order by dias";
		if ( mysql_query($sql) ){	
			$resultado = mysql_query($sql);	  
			$numlinhas = mysql_num_rows($resultado);
			$i = 0;
			if (!empty($numlinhas) ){
			?> <table class="table table-pesq"> <?php
				while($linha = mysql_fetch_array($resultado)){
					$i++;
					?>
                    	<tr class="row">
                        	<td class="span3">							
                            	<?php echo "parcela ".$i." : ".$linha['dias']." dias"; ?>							
                        	</td>
                            <td class="">
<a id="" href="cadastraPrazo.php?id=<?php echo $id;?>&descricao=<?php echo $descricao;?>&iditem=<?php echo $linha['iditem']; ?>">
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
  
    <p><label for="nome">Dias:</label>
    
    <input type="text" name="dias" id="dias" size="4" maxlength="4" value="<?php echo $dias; ?>"  alt="valida" required autofocus/>
        	
	<input type="hidden" name="descricao" id="descricao" value="<?php echo $descricao; ?>" />    
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
    
    <input type="submit"  name="add" id="add" value="+ add" class="btn btn-success"/><br /><br />
   </p>
    <!-- <input type="submit"  name="salvar" id="salvar" value="Salvar" class="formBotao"/>
       	 <input type="reset" name="limpar" id="limpar" value="Limpar"  class="formBotao"/>
    -->
        
    </form>
    </div>
    <!-- FIM DO FORMULARIO ITEM PRAZO  -->



<?php } ?>

<!-- INICIO DAS VERIFICAÇÕES  -->

<?php  //salvar descricao do prazo

if ($_GET['proximo']){
	
	/*validacao no php*/
	if(empty($_GET['descricao']) ){	echo "Preencha o campo descricao."; exit;}
	/**/
	$descricao = strtoupper($_GET['descricao']);
	
	
	/**/
	$consulta = mysql_query( " select * from prazo where descricao = '$descricao' " );
	$numlinhas = mysql_num_rows($consulta);

	if($numlinhas >=1 ) {
		
		?> 
			<script type="text/javascript"> alert("Prazo de pagamento já cadastrado"); history.back(); </script> 
		<?php	
		exit();	 
	
	}else{	//faca a insercao
	$sql = "insert into prazo (descricao) values ('$descricao')";
	}
	
	if ( mysql_query($sql) ){
	  echo'<script type="text/javascript"> alert("Salvo com Sucesso.") </script>';
	  $sql = "select max(idprazo) as id from prazo";
	  $resultado = mysql_query($sql);
	  $resultado = mysql_fetch_assoc($resultado);
	  $id = $resultado['id']  ;
	
	  header("location:cadastraPrazo.php?descricao=$descricao&id=$id");				
	
	}else {
		echo 'Erro ao salvar os Dados!! '.mysql_error();
	}

}

if ($_GET['add']){	//salvar item de prazo
	
	
	if ($_GET['dias'] < 0 ){
	?> 
		<script type="text/javascript"> 
            alert("Número de dias deve ser positivo."); 
            window.history.back(); 					
        </script> 
    <?php	
    exit();
	}	
	
	
	/*validacao no php*/
	if($_GET['dias'] == '' ){	echo "Preencha o campo dias."; exit;}
	/**/
	
	$dias = ($_GET['dias']);
	$id = ($_GET['id']); //id do prazo (cabecalho)
	$descricao = ($_GET['descricao']);
	
	
	/**/
	$consulta = mysql_query( " select * from itemprazo where prazo = '$id' and dias = '$dias' " );
	$numlinhas = mysql_num_rows($consulta);

	if($numlinhas >=1 ) {
		
		?> 
			<script type="text/javascript"> alert("Prazo de pagamento já cadastrado"); history.back(); </script> 
		<?php	
		exit();	 
	
	}else{	//faca a insercao

		$sql = "insert into itemprazo (prazo,dias) values ('$id','$dias')";
	}
	
	if ( mysql_query($sql) ){		  
		 		
		  header("location:cadastraPrazo.php?descricao=$descricao&id=$id");				
		
	}else {
		echo 'Erro ao salvar os Dados!! '.mysql_error();
	}


}

if ($_GET['iditem']){	// [X] EXCLUIR item de prazo
		
	$id = ($_GET['id']); //id do prazo
	$descricao = ($_GET['descricao']);
	$iditem = ($_GET['iditem']);

	$sql = "delete from itemprazo where prazo = $id and iditem = $iditem";
	
	if ( mysql_query($sql) ){		  		 	

		header("location:cadastraPrazo.php?descricao=$descricao&id=$id");				
		/*
		?>
         <script type="text/javascript"> 
		 	alert("Prazo Excluído"); 
			window.location.href = "cadastraPrazo.php?descricao=<?php echo $descricao;?>&id=<?php echo $id;?>";
         </script> 
		<?php
		*/
		
	}else {
		echo 'Erro ao salvar os Dados!! '.mysql_error();
	}


}





/*
if ($_GET['salvar']){
}
*/

?>
</div>

</body>
</html>