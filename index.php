<?php
 require 'protect.php';
 
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CSystem</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
</head>
<body>



<div id="topo">
	<div id="menu">
    	<?php include 'menu'.$_SESSION['tipoUsu'].'.php'; ?>
    </div>
</div>


<div id="conteudo">
<?php  
		/*
			error_reporting(E_ERROR | E_WARNING | E_PARSE);

				
			$paginas_array = array(0 => 'home', 1 => 'cadastraClienteF', 2 => 'cadastraClienteJ', 3 => 'cadastraVendedor');
			
			$pagina = $_GET['pagina'];
			
			$result = array_search($pagina, $paginas_array); 
						
			$pagina = $paginas_array["$result"];
				
						
			
			if (!empty($result)) {
				include $pagina.".php";	
			}
			else {
				include 'home.php';
			}
		*/		
		
?>

	 <img src="imagens/logo.png" alt="logo" class="logo" />

</div>

<div id=""> <!--rodape-->


<span style="font-weight:bold; text-transform:uppercase; color:#004080; bottom:10px; position:absolute; right:1%">
	Usuário: <?php echo $_SESSION['usuario']; ?>
</span>

</div>

</body>
</html>
 