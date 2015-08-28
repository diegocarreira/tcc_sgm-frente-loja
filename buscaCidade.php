<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
	function adiciona(cidade,idcid,form){
		var form = form;
		window.opener.document.forms[form].cidade.value = cidade;
		window.opener.document.forms[form].idcidade.value = idcid;
		window.opener.document.forms[form].cep.focus();
		self.close();
	}
	function fecha(form){
		var form = form;
		window.opener.document.forms[form].uf.focus();
		self.close();
	}
</script>
<title>Busca de Cidades</title>
<style type="text/css">
	table tr td {border:2px solid #069; background-color:#EEE; color:#000; text-decoration:none; }
	
	#titulo{background-color:lightblue; color:#000; font-weight:bold; border:1px solid #069}
	
	* {text-decoration:none;}	
	
	#btFechar{float:right}
	
</style>
<link href="estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<?php
	error_reporting(E_ERROR | E_PARSE);
	
		require 'conecta.php';
		$iduf = $_GET['uf'];
		$form = $_GET['form'];
		$sql = "select cidade.*,uf.* from cidade,uf where uf = $iduf and uf.iduf = cidade.uf";
		$resultado = mysql_query($sql);
		?>
        <input type="button" onclick="fecha('<?php echo $form; ?>');" value="Cancelar" id="btFechar" class="formBotao"  />
        <br />
       
        <table>
        	<tr >
            	<!--<td id="titulo">Codigo</td>--> 
                <td id="titulo">Cidade</td>
                <td id="titulo">UF</td> 
            </tr>
        <?php
		while($linha = mysql_fetch_array($resultado)){
			$idcid = $linha['idcid'];
			$nome = $linha['nome'];
			$uf = $linha['sigla'];
			?>
            <tr>
	    	<?php /*?><td><?php echo $idcid; ?></td><?php */?>			
                <td><a href= "#" onclick = "adiciona('<?php echo $nome; ?>','<?php echo $idcid; ?>','<?php echo $form; ?>' )"> <?php echo $nome;?> </a></td>
                <td><?php echo $uf; ?></td>
            </tr>
            <?php
		}
		?>
        </table>
        
        <?php
	?>
</body>
</html>