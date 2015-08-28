<?php
$conexao = mysql_connect('127.0.0.1','root','') or die("Erro ao conectar ao mysql".mysql_error());
 mysql_select_db('tcc') or die("Banco de Dados não encontrado".mysql_error());

/*retorna uma variavel em json */
	function _retorno($ret)	{
		$ret = json_encode($ret);
		echo $ret;
		exit;
	}
	/**/
	

/*
###########################
	VALIDACAO CPF
###########################
*/
	
function validaCPF($cpf = null) {
 
    // Verifica se um número foi informado
    if(empty($cpf)) {
        return false;
    }
 
    // Elimina possivel mascara
    $cpf = ereg_replace('[^0-9]', '', $cpf);
    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
     
    // Verifica se o numero de digitos informados é igual a 11 
    if (strlen($cpf) != 11) {
        return false;
    }
    // Verifica se nenhuma das sequências invalidas abaixo 
    // foi digitada. Caso afirmativo, retorna falso
    else if ($cpf == '00000000000' || 
        $cpf == '11111111111' || 
        $cpf == '22222222222' || 
        $cpf == '33333333333' || 
        $cpf == '44444444444' || 
        $cpf == '55555555555' || 
        $cpf == '66666666666' || 
        $cpf == '77777777777' || 
        $cpf == '88888888888' || 
        $cpf == '99999999999') {
        return false;
     // Calcula os digitos verificadores para verificar se o
     // CPF é válido
     } else {   
         
        for ($t = 9; $t < 11; $t++) {
             
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
 
        return true;
    }
}	


/*
###########################
	VALIDACAO CNPJ
###########################
*/

function validaCNPJ( $cnpj ) 	
{	
$cnpj = preg_replace( "@[./-]@", "", $cnpj );
//	
if( strlen( $cnpj ) <> 14 or !is_numeric( $cnpj ) )	
{	
return false;	
}
if($cnpj == '00000000000000' || 
	$cnpj == '11111111111111' || 
	$cnpj == '22222222222222' || 
	$cnpj == '33333333333333' || 
	$cnpj == '44444444444444' || 
	$cnpj == '55555555555555' || 
	$cnpj == '66666666666666' || 
	$cnpj == '77777777777777' || 
	$cnpj == '88888888888888' || 
	$cnpj == '99999999999999') {
	return false;
}
//	
$k = 6;	
$soma1 = "";	
$soma2 = "";	
for( $i = 0; $i < 13; $i++ )	
{	
$k = $k == 1 ? 9 : $k;	
$soma2 += ( $cnpj{$i} * $k );	
$k--;	
if($i < 12)	
{	
if($k == 1)	
{	
$k = 9;	
$soma1 += ( $cnpj{$i} * $k );	
$k = 1;	
}	
else	
{	
$soma1 += ( $cnpj{$i} * $k );	
}	
}	
}	

$digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;	
$digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;


return ( $cnpj{12} == $digito1 and $cnpj{13} == $digito2 );	
}	

//retorna true em caso de valido e false se for invalido	
?>