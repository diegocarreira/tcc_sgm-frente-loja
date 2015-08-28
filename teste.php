<?php $_SESSION['nome'] = 'diego'?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php



$texto = "Com a intenção de promover o contato dos estudantes com os avanços tecnológicos das empresas, o curso de Tecnologia em Análise e Desenvolvimento de Sistemas' da 'Universidade Paranaense – 'Unipar, 'Unidade de Cianorte', promoveu visita técnica a uma das maiores empresas de 'desenvolvimento'. de software do 'sul' do país, a Virtual Age (em 26/03).";


$escaped = mysql_escape_string($texto);

echo $escaped;

echo '<br /><br /><br /><br /><br /><br />';

echo date('dmyHis'); 



function no_barras($texto) { return str_replace("\\","",$texto); } //Deixa a string somente (retira as barras inversas)
echo no_barras($escaped);




?>
</body>
</html>