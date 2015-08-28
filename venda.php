<?php ob_start(); ?>
<?php require 'protect.php' ?>
<?php require 'conecta.php' ?>
<?php include 'menu'.$_SESSION['tipoUsu'].'.php';  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CSystem - Venda</title>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="funcoes.js"></script>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<?php include 'links-tb.php'; ?>

<script type="text/javascript">
$(document).ready(function(){
	$("#desconto").maskMoney({showSymbol:true,symbol:"R$", decimal:".", thousands:"", allowZero:true});
});
</script> 
</head>
<body> 
<?php $_SESSION['totalVenda'] = 0; ?>
<div class="well cabecalho">
	<h2 style="display:inline-block;">Venda</h2> <input type="text" class="pq txVenda" style="display:inline-block;" />
    <div class="btn btRefresh" style="margin-top:-8px;"><i class="icon-refresh"></i></div>
	<br />
    
    <!--data -->
   <?php $dataEmi = date('d/m/Y'); ?>
   <span class="spanDate"> <b>Data: </b><?php echo $dataEmi; ?></span> 
   <!-- -->
   
   <!-- Botão Finalizar Venda -->
		<a id="finalizarVenda" href="javascript:;" class="btn btn-success fRight">Finalizar Venda</a>
   <!-- -->
   
   <br />
   
    <p>
        <label for="cliente" class="pq">
            Cliente:<font class="red">*</font>
        </label>
        <input class="fLeft" type="text" name="cliente" id="cliente"  value="" alt="valida" required autofocus/>
            <span class="spanCliente fLeft" ></span>
    </p>

    <div class="boxClientes w100" ></div>
    
    	<br /><br />
        <form name="formVenda" id="formVenda" method="post" action="" class="" onSubmit="return valida_form(this)">
        
            <!-- Hidden com id do cliente -->
            <input type="hidden" name="idcli" id="idcli" value=""/>
            <!--  -->
             <!-- Hidden com id da venda -->
            <input type="hidden" name="idvenda" id="idvenda" value=""/>
            <!--  -->
            
            <p class="fLeft">
                <label for="prazo" class="pq">
                Prazo:<font class="red">*</font>
                </label>
                
                <select name="prazo" id="prazo" class="md">
                    <option value="0"></option>
                    <?php $sql = "select * from prazo 
					WHERE idprazo in ( select prazo from itemprazo )
					"; 
                    $result = mysql_query($sql);
                    while ($linha = mysql_fetch_array( $result )){
                    
                    ?><option value="<?php echo $linha['idprazo']; ?>"><?php echo $linha['descricao']; ?></option>
                    
                    <?php }?>
                </select>
            </p>
            
              <p class="fLeft" style="margin-left:20px;">
                <label for="prazo" class="pq">
                Vendedor:<font class="red">*</font>
                </label>
                
                <select name="vendedor" id="vendedor" class="md" style="margin-left:20px;">
                    <option value="0"></option>
                    <?php $sql = "select * from vendedor"; 
                    $result = mysql_query($sql);
                    while ($linha = mysql_fetch_array( $result )){
                    
                    ?><option value="<?php echo $linha['idvendedor']; ?>"><?php echo $linha['nome']; ?></option>
                    
                    <?php }?>
                </select>
            </p>
            
            
                <label for="desconto" class="pq" style="margin-left:20px;">
	                Desconto(R$):
                </label>
                <input class="fLeft pq" type="text" name="desconto" id="desconto"  value="" alt="valida" required autofocus style="margin-left:40px;"/>
                
              
            
            <!--<input type="button" name="submitCabecalho" id="submitCabecalho" /> -->
        
        </form>
    
</div> <!-- fim da div cabecalho-->
<div class="well corpo" style="min-height:80px;">

	 <form name="formItemVenda" id="formItemVenda" method="post" action="" class="" onSubmit="return valida_form(this)">
		
         <p class="fLeft">
            <label for="codigo" class="pq">
                Código:
            </label><br /><br />
            <input class="pq" type="text" name="codigo" id="codigo"  value="" alt="" maxlength="9"/>
        </p>
        
        <p class="fLeft">
            <label for="descricao" class="gr" >
                Descricao:
            </label><br /><br />
            <input class="gr" type="text" name="descricao" id="descricao"  value="" alt="" disabled="disabled"/>
        </p>
		
        <p class="fLeft">
            <label for="preco" class="pq">
                Preço:
            </label><br /><br />
            <input class="pq" type="text" name="preco" id="preco"  value="" alt="" disabled="disabled"/>
        </p>
        
         <p class="fLeft">
            <label for="qtd" class="pq">
                Qtd:
            </label><br /><br />
            <input class="pq" type="text" name="qtd" id="qtd"  value="" alt="" />
        </p>
        

            <span class="spanValorTotal">
            	Total R$:
                <br />
                <span class="total">0,00</span>
            </span>

        <br /><br />
        <p class="fLeft" style="margin-top:-3px;">
            <input class="btn btn-inverse" type="button" name="add" id="add"  value="add"/>
        </p>

	</form>
</div>

<!-- GRID de itens -->
<div class="well grid">
	<table class="table table-pesq">
 		<thead>
        	<tr>
            	<td class="formTitulo textRight" >Código:</td>
                <td class="formTitulo">Descrição - Tam:</td>
                <td class="formTitulo textRight">Preço:</td>
                <td class="formTitulo textRight">Qtd:</td>
                <td class="formTitulo textRight">Preço Total:</td>
            </tr>
        </thead>
        <tbody class="tGrid"></tbody>
	</table>
</div>




<!-- Parcelas -->
<div class="fadeParcelas">
    <div class="divContainerParcelas">
      <div class="divParcelas">
            <table class="table">
                <thead>
                    <tr>
                        <th><font class="textRight" color="#FFFFFF">Num</font></th>
                        <th><font color="#FFFFFF">Vencimento</font></th>
                        <th><font class="textRight" color="#FFFFFF">R$</font></th>
                    </tr>
                </thead>
                <tbody class="tParcelas"></tbody>
            </table>        
        </div>
        <div class="botoes">
            <input type="button" value="Confirmar" class="btn btn-success btConfirmar" />
            <input type="button" value="Cancelar" class="btn btn-danger btCancelar" />
        </div>
        
        
    </div> <!-- container -->
</div> <!-- fade -->
<!-- -->

<script type="text/javascript">
	$("#finalizarVenda").attr('disabled', true);	
	$(".fadeParcelas").css({opacity:0, display:"none"});
	$(".divContainerParcelas").hide();
	
	/*buscar os clientes pelas iniciais do nome*/
	$("#cliente").bind("blur", function(){
		buscaCliente();
	});
	
	/*clico e seleciono um determinado cliente*/
	$(".aNome").live("click",function(){
		var idCli = $(this).attr('id');
		var nomeCli = $(this).text();
		$(".spanCliente").css('color','green').text(nomeCli);
		$(".boxClientes").hide();
		$("#idcli").val(idCli);
		gravaCabecalhoVenda(idCli);
		
	});
	
	/*traz a descricao do produto atraves do codigo*/
	$("#codigo").bind("blur", function(){
		buscaItem();
	});
	
	/*gravar cabecalho da venda - vai ser chamado por trigger()
	$("#submitCabecalho").bind("click", function(){
		gravaCabecalho("#formVenda");
		//$(".corpo").slideDown("slow");
	});*/
	
	/*grava um item*/
		$("#add").bind("click", function(){
		var codigo = $("#codigo").attr('value');
		var qtd  = $("#qtd").attr('value');
		var idvenda  = $("#idvenda").attr('value');
		if (codigo != '' ){
			if (qtd >= 1 ){			
				gravaItem(codigo, qtd, idvenda);
			}else{alert("Digite a quantidade."); $("#qtd").focus()}
		}else{alert("Digite o código do produto."); $("#codigo").focus()}		
		//$(".corpo").slideDown("slow");
	});
	/**/
		$("#qtd").keypress(function(e){
			var tecla = (e.keyCode?e.keyCode:e.which);
			if(tecla == 13) { //Enter keycode
				$("#add").trigger("click");
			}
		});
		
	/**/
	
	
	/*deleta um item*/
		$(".btDeleteItem").live("click",function(){
			if( confirm("Excluir Item?") ){			
				var iditem = $(this).attr('id');
				var idvenda = $("#idvenda").val();
				deletaItem(iditem,idvenda);				
			}
		});
	/**/

	/*Alteracao de um item (qtd)*/
		/*$(".trGrid").live("dblclick",function(){
			var id = $(this).attr('data');
			alert("dbclick: "+id);
		});*/
	
	/**/
	
	
	/*chama as parcelas na tela*/
	$("#finalizarVenda").bind("click",function(){
		var disable = $("#finalizarVenda").attr('disabled');
		//alert(disable);
		if( disable != 'disabled' ){
			var idprazo = $("#prazo").val();
			var vendedor = $("#vendedor").val();
			if( idprazo != 0 ){			
				
				if( vendedor != 0 ){
					//alert("pode chama a parcela");
					
					buscaParcelas(idprazo);
					
				}else{
					alert("Preencha o vendedor.");
				}
				
			}else{
				alert("Preencha o prazo.");
			}
		}
		
	});
	/**/
	
	/*Confirmação das parcelas*/	
	$(".btCancelar").bind("click",function(){		
		$(".divContainerParcelas").slideUp("slow",function(){
			$(".fadeParcelas").css({display:"none"}).animate({opacity:0},"normal");
		});
	});
	/**/
		
	$(".btConfirmar").bind("click",function(){
		//$(".divContainerParcelas").slideUp("slow");
		gravaVenda();
	});	
	/**/
	
	
	/*Recarregar Venda*/
	$(".btRefresh").bind("click",function(){
		var idVenda = $(".txVenda").val();
		if(idVenda != ''){			
			recarregaVenda(idVenda);
		}
	});
	
	
	
</script>
</body>
</html>
