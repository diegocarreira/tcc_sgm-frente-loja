// \\\\\\\\\busca os clientes pelas iniciais via AJAX ///////////////
function buscaCliente(){
	var cliente = $("#cliente").attr('value');
	//$(".boxClientes").show();
	if (cliente == ''){
		$(".spanCliente").css('color','red');
		$(".spanCliente").text("Cliente Inexistente"); 
		$("#idcli").val('');
	}else{
			$.get(
				"ajax.php",
				{ cliente: cliente, origem:'vendaCliente' },
				function(data){
					if (data == 'erro'){
						$(".spanCliente").css('color','red');
						$(".spanCliente").text("Cliente Inexistente");	
						$("#idcli").val('');
					}else{
						$(".boxClientes").show();						
						$(".boxClientes").html(data);
					}
			}, 'html');
	}
}

// \\\\\\\\\busca os dados de um produto pelo codigo via AJAX ///////////////
function buscaItem(){
	var codigo = $("#codigo").attr('value');
	var preco;
	if (codigo != ''){
			$.get(
				"ajax.php",
				{ codigo: codigo, origem:'vendaItem' },
				function(data){
					if (data.erro == 'erro'){
						alert("Produto inexistente");
						$("#codigo").val("");
						$("#codigo").focus();
					}else{
						$("#descricao").val(data.descricao);						
						preco = (data.valor).replace(".",",");
						$("#preco").val(preco);
					}
			}, 'json');
	}
}


// \\\\\\\\\Grava o Cabecalho da Venda via AJAX ///////////////	

function gravaCabecalhoVenda(idcli){
	var idvenda = $("#idvenda").attr('value');
	if(idvenda == ''){

			$.ajax({
				type: "GET",
				url: "ajax.php?origem=gravaCabecalhoVenda",
				data: "idcli="+idcli,
				success: function(data){
					//alert(data);
					if(data.substr(0,4) == "erro"){
						var aMsg = data.split(":");
						var campo = aMsg[1];
						if (campo = "SQL"){
							alert("Erro no SQL");
						}else{
							alert("Preencha o campo: "+campo);
							$("#"+campo).focus();
						}
					}else{
						//alert("Venda Gravada: "+data);
						$("#idvenda").val(data);
						$("#cliente").attr("disabled", true);						
					}
				}	
				
			});
	}
	
}
		
// \\\\\\\\\Grava um Item em itemVenda via AJAX ///////////////	

function gravaItem(codigo, qtd, idvenda){
	
	$.get(
		"ajax.php",
		{ codigo: codigo, qtd: qtd, idvenda: idvenda, origem:'gravaItem' },
		function(data){
			
			switch(data.erro){
				case '0':
					//alert(data.msg);										
					$("#formItemVenda input[type='text']").val("");
					$("#codigo").focus();
					alimentaGrid('normal');	
					$("#finalizarVenda").attr('disabled', false);
				break;
				
				case '1':
					if (data.campo == 'idvenda'){alert( "Selecione o Cliente." );
					}else{
						alert("Verifique o campo: "+data.campo);
					}
				break;
				
				case '2':
					alert(data.msg);
				break;
			}
			
	}, 'json');
	
}

// \\\\\\\\\Delete um Item em itemVenda via AJAX ///////////////	

function deletaItem(iditem, idvenda){
	
	$.get(
		"ajax.php",
		{ iditem: iditem, idvenda:idvenda, origem:'deletaItem' },
		function(data){
			
			switch(data.erro){
				case '0':
					//alert("Item Excluído.");					
					alimentaGrid('normal');
					//atuValorTotal();
				break;								
				
				case '2':
					alert(data.msg);
				break;
			}
			
	}, 'json');
	
}

	
/* \\\ 
Se e somente se o gravação do item deu certo,
pego os dados que estão nos campos do formItemVenda (corpo) 
e acrescento na GRID  
//// */

function alimentaGrid(tipo){		
	var idvenda = $("#idvenda").val();
	var tipo = tipo;
	
	$.get(
		"ajax.php",
		{ venda: idvenda , origem:'alimentaGrid' },
		function(data){	
			if(data.substr(0,4) == "erro"){
				var aMsg = data.split(":");
				alert(aMsg[2]);	 //erro no cab venda ou no SQL										
			}else{					
				$(".tGrid").html(data);
				if(tipo != 'recuperacao'){
					atuValorTotal();
				}
			}
	}, 'html');	
	
	
}

// \\\\\\\\\ ATUALIZA O VALOR TOTAL DA VENDA ATUAL NA TELA ///////////////

function atuValorTotal(){			
	$.get(
		"ajax.php",
		{ origem:'atuValorTotal' },
		function(data){				
			if (data.erro == '0'){
				$(".spanValorTotal .total").html(data.valorTotal.replace(".",","));
				//$(".spanValorTotal .total").html(data.valorTotal);
			}else{
				alert('errou');
			}
			
	}, 'json');	
	
	
}

/**/

// \\\\\\\\\ busca os dias do prazo escolhido na venda//////////////
function buscaParcelas(idprazo){
var desconto = $("#desconto").attr('value');
	$.get(
		"ajax.php",
		{ prazo:idprazo ,origem:'buscaParcelas' , desconto:desconto},
		function(data){				
			if(data.substr(0,4) == "erro"){
				var aMsg = data.split(":");
				alert(aMsg[2]);				
			}else{				
				$(".tParcelas").html(data);
				$(".fadeParcelas").css({display:"block"}).animate({opacity:1},"normal", function(){
					$(".divContainerParcelas").slideDown("slow");
				});
			}
			
	}, 'html');	



}


// \\\\\\\\\grava a venda completa via AJAX ///////////////

function gravaVenda(){
	
	var venda = $("#idvenda").attr('value');
	var prazo = $("#prazo").attr('value');
	var vendedor = $("#vendedor").attr('value');
	var desconto = $("#desconto").attr('value');
	
	if(idvenda != ''){
	
			$.ajax({
				type: "GET",
				url: "ajax.php?origem=gravaVenda",
				data: "venda="+venda+"&prazo="+prazo+"&vendedor="+vendedor+"&desconto="+desconto,
				success: function(data){
					//alert(data);
					if(data.substr(0,4) == "erro"){
						var aMsg = data.split(":");
						var campo = aMsg[1];
						alert("Preencha o campo: "+campo);
						//$("#"+campo).focus();
					}else{
						alert("Venda Gravada.");						
						$(".divContainerParcelas").slideUp("slow", function(){
							$(".fadeParcelas").css({display:"none"}).animate({opacity:0},"normal", function(){
								window.location.href = "venda.php";	
							});
						});	
					}
				}	
				
			});
	}
	
	
	
}
/**//**//**/

// \\\\\\\\\ Recarrega Venda ///////////////

function recarregaVenda(idVenda){
	
		$.get(
		"ajax2.php",
		{ idVenda:idVenda ,origem:'recarregaVenda' },
		function(data){				
			switch(data.erro){
				case '0':
					//alert(data.total);
					$("#idcli").val(data.idcli);
					$(".spanCliente").css('color','green').text(data.cliente);
					$("#cliente").attr("disabled", true);					
					$("#idvenda").val(idVenda);
					if(data.total != null){
						$(".spanValorTotal .total").html(data.total.replace(".",","));
						$("#finalizarVenda").attr('disabled', false);
					}
					alimentaGrid('recuperacao');
				break;								
				
				case '1':
					alert(data.msg);
				break;
			}
			
	},'json');	

}



/*------------
	pagar
------------*/	

// \\\\\\\\\ gravar Conta a Pagar lançada via ajax ///////////////

function gravaPagar(){
	var fornecedor = $("#fornecedor").attr('data-id'); // id do cara e nao o nome.
	var valor = $("#valor").val();
	var vencimento = $("#vencimento").val();
	
	$.get(
		"ajax2.php",
		{ fornecedor: fornecedor, valor:valor, vencimento:vencimento, origem:'gravaPagar' },
		function(data){
			switch(data.erro){
				case '0':
					alert(data.msg);
					window.location.href = "pagar.php";	// gravacao com Sucesso.				
				break;								
				
				case '1':
					alert("Preencha o campo: "+data.campo); // campo em branco
				break;
				
				case '2':
					alert(data.msg); // erro no sql
				break;
				
				case '3':
					alert(data.msg); //data invalida
					$("#"+data.campo).focus();
				break;
								
			}
			
	}, 'json');
	
}


/*-----------------------
	Pagamento
--------------------*/

 // \\\\\\\\\busca os Fornecedores pelas iniciais via AJAX ///////////////
function buscaFornecedor(){
	var fornecedor = $("#fornecedor").attr('value');
	//$(".boxClientes").show();
	if (fornecedor == ''){
		$(".spanFornecedor").css('color','red');
		$(".spanFornecedor").text("Cliente Inexistente"); 
		//$("#idcli").val('');
	}else{
			$.get(
				"ajax2.php",
				{ fornecedor: fornecedor, origem:'buscarFornecedor' },
				function(data){
					if (data == 'erro'){
						$(".spanFornecedor").css('color','red');
						$(".spanFornecedor").text("Cliente Inexistente");	
						//alert('erro');
						//$("#idcli").val('');
					}else{
						$(".boxFornecedor").show();						
						$(".boxFornecedor").html(data);
					}
			}, 'html');
	}
}


function buscaCPagar(idFor){
	//alert(idFor);				
	$.get(
		"ajax2.php",
		{ idFor: idFor, origem:'buscarCPagar' },
		function(data){
			if (data == 'erro'){
				$(".boxFornecedor").show();		
				$(".boxFornecedor").css('color','red');
				$(".boxFornecedor").html("Não há debitos para esse fornecedor.");
				
			}else{
				$(".boxFornecedor").show();						
				$(".boxFornecedor").html(data);
				$("#fornecedor").attr('disabled',true);
			}
	}, 'html');
	

}




// \\\\\\\\\ pagar uma parcela via ajax ///////////////

function pagarParcela(idParcela){	
	
	$.get(
		"ajax2.php",
		{ idParcela: idParcela, origem:'pagarParcela' },
		function(data){
			switch(data.erro){
				case '0':
					alert(data.msg);
					window.location.href = "pagamento.php";	// pgto gravado com Sucesso.				
				break;								
				
				case '1':
					alert("Verifique o campo: "+data.campo); // campo em branco
				break;
				
				case '2':
					alert(data.msg); // erro no sql
				break;								
								
			}
			
	}, 'json');
	
}



/**//**//**//**//**//**/

/* --------------------
	Recebimento
----------------------*/

 // \\\\\\\\\busca os Clientes pelas iniciais via AJAX ///////////////
function buscaCliente2(){
	var cliente = $("#cliente").attr('value');
	//$(".boxClientes").show();
	if (cliente == ''){
		$(".spanCliente").css('color','red');
		$(".spanCliente").text("Cliente Inexistente"); 
		//$("#idcli").val('');
	}else{
			$.get(
				"ajax2.php",
				{ cliente: cliente, origem:'buscarCliente' },
				function(data){
					if (data == 'erro'){
						$(".spanCliente").css('color','red');
						$(".spanCliente").text("Cliente Inexistente");	
						//alert('erro');
						//$("#idcli").val('');
					}else{
						$(".boxClientes").show();						
						$(".boxClientes").html(data);
					}
			}, 'html');
	}
}



function buscaCReceber(idCli){
	//alert(idFor);				
	$.get(
		"ajax2.php",
		{ idCli: idCli, origem:'buscarCReceber' },
		function(data){
			if (data == 'erro'){
				$(".boxClientes").show();		
				$(".boxClientes").css('color','red');
				$(".boxClientes").html("Não há debitos para esse cliente.");
				
			}else{
				$(".boxClientes").show();						
				$(".boxClientes").html(data);
				$("#cliente").attr('disabled',true);
			}
	}, 'html');
	

}


// \\\\\\\\\ receber uma parcela via ajax ///////////////

function receberParcela(idParcela){	
	
	$.get(
		"ajax2.php",
		{ idParcela: idParcela, origem:'receberParcela' },
		function(data){
			switch(data.erro){
				case '0':
					alert(data.msg);
					window.location.href = "recebimento.php";	// pgto gravado com Sucesso.				
				break;								
				
				case '1':
					alert("Verifique o campo: "+data.campo); // campo em branco
				break;
				
				case '2':
					alert(data.msg); // erro no sql
				break;								
								
			}
			
	}, 'json');
	
}





/**//**//**//**//**//**/
			
							
 // \\\\\\\\\\\\\\\\\\\VALIDACAO FORMULARIO DE CADASTRO - PREENCHER TDS OS CAMPOS corretamente /////////////////////////////////
/* 
	- COLOQUE O EVENTO onSubmit desta forma
	<form method="post" onSubmit="return valida_form(this)">

	- Os inputs que serão obrigatórios,  terão de ter o complemento alt="valida"
	- qd for textarea e for obrigatório, terá de ter o complemento title="valida"
	 - a correspondencia entre a funcao e o formulario tbm é estabelecida pelo nome dos campos.
	
*/



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
		
		
		
		if(ele.elements[i].name == "cpf" || ele.elements[i].name == "cpf" || ele.elements[i].name == "cpf"){
				if(ele.elements[i].value == "11111111111" || ele.elements[i].value == "22222222222"){
				erro = erro + "Preencha o campo '"+ ele.elements[i].name.toUpperCase() +"' corretamente. \n"
				}
		}
		
		if(ele.elements[i].name == "cep" || ele.elements[i].name == "telefone" || ele.elements[i].name == "celular" || ele.elements[i].name == "rg" || ele.elements[i].name == "ie"){
				if( isNaN(   ele.elements[i].value  ) ){
				erro = erro + "Preencha o campo '"+ ele.elements[i].name.toUpperCase() +"' corretamente (somente numeros) . \n"
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

 // \\\\\\\\\\\\\\\\\\\ abre a busca de cidade /////////////////////////////////
 
 function abreJanela(uf,form){
	var iduf = uf;
	var form = form;
	window.open("buscaCidade.php?uf="+iduf+"&form="+form, "Buscar Cidade",'scrollbars=yes,resizable=no,width=500px,height=600px');
}


 // \\\\\\\\\\\\\\\\\\\ validacao do cpf /////////////////////////////////
 

<!--
function verifica_CPF(form) {
	var form = form;
var CPF = form.cpf.value; // Recebe o valor digitado no campo

// Verifica se o campo é nulo
	if (CPF == ''){
		exit();	
	}
	
// Aqui começa a checagem do CPF
var POSICAO, I, SOMA, DV, DV_INFORMADO;
var DIGITO = new Array(10);
DV_INFORMADO = CPF.substr(9, 2); // Retira os dois últimos dígitos do número informado

// Desemembra o número do CPF na array DIGITO
for (I=0; I<=8; I++) {
  DIGITO[I] = CPF.substr( I, 1);
}

// Calcula o valor do 10º dígito da verificação
POSICAO = 10;
SOMA = 0;
   for (I=0; I<=8; I++) {
      SOMA = SOMA + DIGITO[I] * POSICAO;
      POSICAO = POSICAO - 1;
   }
DIGITO[9] = SOMA % 11;
   if (DIGITO[9] < 2) {
        DIGITO[9] = 0;
}
   else{
       DIGITO[9] = 11 - DIGITO[9];
}

// Calcula o valor do 11º dígito da verificação
POSICAO = 11;
SOMA = 0;
   for (I=0; I<=9; I++) {
      SOMA = SOMA + DIGITO[I] * POSICAO;
      POSICAO = POSICAO - 1;
   }
DIGITO[10] = SOMA % 11;
   if (DIGITO[10] < 2) {
        DIGITO[10] = 0;
   }
   else {
        DIGITO[10] = 11 - DIGITO[10];
   }

// Verifica se os valores dos dígitos verificadores conferem
DV = DIGITO[9] * 10 + DIGITO[10];
   if (DV != DV_INFORMADO) {	   
      alert('CPF inválido');
      //form.cpf.value = '';	
      form.cpf.focus();
      return false;
   }
}
//-->

 // \\\\\\\\\\\\\\\\\\\ validacao do CNPJ/////////////////////////////////
 
 
 function verifica_CNPJ(campo, form){
	
	var form = form;
	var cnpj = campo;
	
	if (cnpj == ''){
		exit();	
	}
	
	sp = cnpj.split(/[\.\-\/]/);
	cnpj = '';
	qtde = sp.length;
  	for (i=0; i < qtde; i++){
    	cnpj += sp[i];
    }
	var i, dig1, dig2, cpf_ver = 0;
	var j = [5,6,7,8,9,2,3,4,5,6,7,8,9];
	var soma = 0;
	var novoCnpj = '';
	
	switch(cnpj){
		case "00000000000000":
			alert( "CNPJ Inválido");
			//document.forms[form].cnpj.value = '';
			document.forms[form].cnpj.focus();
			exit();
		break;
		case "11111111111111":
			alert( "CNPJ Inválido");
			//document.forms[form].cnpj.value = '';
			document.forms[form].cnpj.focus();
			exit();
		break;
		case "22222222222222":	
			alert( "CNPJ Inválido");
			document.forms[form].cnpj.focus();
			exit();
		break;
		case "33333333333333":
			alert( "CNPJ Inválido");
			//document.forms[form].cnpj.value = '';
			document.forms[form].cnpj.focus();
			exit();
		break;
		case "44444444444444":
			alert( "CNPJ Inválido");
			//document.forms[form].cnpj.value = '';
			document.forms[form].cnpj.focus();
			exit();
		break;
		case "55555555555555":
			alert( "CNPJ Inválido");
			//document.forms[form].cnpj.value = '';
			document.forms[form].cnpj.focus();
			exit();
		break;
		case "66666666666666":
			alert( "CNPJ Inválido");
			//document.forms[form].cnpj.value = '';
			document.forms[form].cnpj.focus();
			exit();
		break;
		case "77777777777777":
			alert( "CNPJ Inválido");
			//document.forms[form].cnpj.value = '';
			document.forms[form].cnpj.focus();
			exit();
		break;
		case "88888888888888":			
			alert( "CNPJ Inválido");
			//document.forms[form].cnpj.value = '';
			document.forms[form].cnpj.focus();
			exit();
		break;
		case "99999999999999":
			alert( "CNPJ Inválido");
			//document.forms[form].cnpj.value = '';
			document.forms[form].cnpj.focus();
			exit();
		break;
	}

	cnpj_ver = cnpj.substr(0 ,12);
	for (i = 0; i < 12; i++){
		soma += parseInt(cnpj_ver.charAt(i)) * j[i + 1];
	}

	if((soma % 11 < 2) || (soma % 11 == 10)){
		dig1 = 0;
	}else{
		dig1 = soma % 11;
	}
	
	cnpj_ver = cnpj_ver+""+dig1;

	i = 0;
	soma = 0;
	dig2 = 0;
	
	for(i = 0; i < 13; i++){
		soma += parseInt(cnpj_ver.charAt(i)) * j[i];
	}
	
	if((soma % 11 < 2) || (soma % 11 == 10)){
		dig2 = 0;
	}else{
		dig2 = soma % 11;
	}
	cnpj_ver = cnpj_ver+""+dig2;

	if(cnpj != cnpj_ver){
		alert( "CNPJ Inválido");
		//document.forms[form].cnpj.value = '';
		document.forms[form].cnpj.focus();
		exit();
	}
	
	// aplica a mascara
	
	/*if(cnpj_ver.length == 14){
		for(i = 0; i < 14; i++){
			if((i == 2) || (i == 5)){
				novoCnpj = novoCnpj + '.';
			}
			if(i == 8){
				novoCnpj = novoCnpj + '/';
			}
			if(i == 12){
				novoCnpj = novoCnpj + '-';
			}
		
			novoCnpj = novoCnpj + cnpj_ver[i];
		}
	}
	
	return novoCnpj;
	*/
	return cpnj_ver;

}
////////////////////////////

