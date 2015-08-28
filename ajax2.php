<?php ob_start();
	require 'conecta.php'; 
	session_start();
	
	/*retorna uma variavel em json */
	/*function _retorno($ret)	{
		$ret = json_encode($ret);
		echo $ret;
		exit;
	}*/
	/**/
	
	function validaData($dat){
		$data = explode("/","$dat"); // fatia a string $dat em pedados, usando / como referência
		$d = $data[0];
		$m = $data[1];
		$y = $data[2];
	
		// verifica se a data é válida!
		// 1 = true (válida)
		// 0 = false (inválida)
		$res = checkdate($m,$d,$y);
		/*
		if ($res == 1){
		   echo "data ok!";
		} else {
		   echo "data inválida!";
		}
		*/
		return $res;
	}		
	
	/**/
	function dataToEua($data){
		$data2 = str_replace("/","-",$data);
		$data = date('Y-m-d', strtotime($data2));
		return $data;
	}
	
	function dataToBra($data){
		$data2 = date('d/m/Y', strtotime($data));
		return $data2;
	}
	
	/**/

if ( isset($_GET['origem']) and ($_GET['origem'] != '')){
	
	$origem = $_GET['origem'];

	
	switch ($origem){			
				
				/*###################*/
				case 'buscarFornecedor' :
					/*busca fornecedores no lancamento de C.Pagar e na tela de pagamento*/
					$fornecedor = $_GET['fornecedor'];
					$fornecedor = strtoupper($fornecedor);
					
					$sql = "select * from clifor where tipo = 'F' and nome LIKE '%".$fornecedor."%' or razsoc LIKE '%".$fornecedor."%' ";
					
					$result = mysql_query($sql);	
					$num = mysql_num_rows($result);
					if ($num == 0){	
						echo 'erro';
						exit;	
					}
				
					?> <table class="table table-pesq">
						<tr>
							<td class="formTitulo">Nome:</td>
							<td class="formTitulo">CPF:</td>
							<td class="formTitulo">Cidade:</td>
							<td class="formTitulo">UF:</td>
						</tr>
					<?php
						
					while ( $linha = mysql_fetch_array($result)){
							
						$idFor = $linha['idclifor'];
						
						if ( $linha['razsoc'] == '' ){
							$nomeFor = $linha['nome'];
						}else{
							$nomeFor = $linha['razsoc'];
						}
						
						$idcid = $linha['cidade']; 
						$sql = "select nome from cidade where idcid = '$idcid' ";
						$cidade = mysql_fetch_assoc(mysql_query($sql));
						?>
						<tr>
							<td>
								<a href="javascript:;" id="<?php echo $idFor; ?>" class="aNome"><?php echo $nomeFor; ?></a>
							</td>
							<td>
								<?php echo $linha['cnpjcpf']; ?>
							</td>
							<td>
								<?php echo $cidade['nome']; ?>
							</td>
							<td>
								<?php
								$iduf = $linha['uf']; 
								$sql = "select sigla from uf where iduf = '$iduf' ";
								$uf = mysql_fetch_assoc(mysql_query($sql));
								echo $uf['sigla']; ?>
							</td>
						</tr>
						<?php
						
						
					} //fim do while
					?> </table>	
					<?php
					break;


					/*#############*/
					case 'gravaPagar':  
						if(empty($_GET['fornecedor']) ){$ret = array("erro"=>"1","campo"=>"fornecedor"); _retorno($ret);}
						if(empty($_GET['valor']) ){$ret = array("erro"=>"1","campo"=>"valor"); _retorno($ret);}
						if(empty($_GET['vencimento']) ){$ret = array("erro"=>"1","campo"=>"vencimento"); _retorno($ret);}
						
						$fornecedor = $_GET['fornecedor'];
						$valor = $_GET['valor'];
						$vencimento = $_GET['vencimento'];
						
						$retorno = validaData($vencimento);
						
						if($retorno != 1){						
							$ret = array("erro"=>"3","campo"=>"vencimento","msg"=>"Verifique a data de vencimento.");
							 _retorno($ret);						 
						}
							/**/
							$venc = str_replace('/','-',$vencimento); //troco as / por - senao da erro de conversao abaixo.
							$vencimento = date( "Y-m-d" , strtotime($venc)); //coloco a data em formato EUA pra gravar no BD.
							/**/
							
						$dataEmi = date('Y-m-d');
						
						$sql = "insert into pagar (fornecedor, valor, emissao, vencimento) 
						values ('$fornecedor', '$valor','$dataEmi', '$vencimento' )";
						
									
						if($resultado = mysql_query($sql)){
							$ret = array("erro"=>"0","msg"=>"Conta Gravada."); _retorno($ret);
						}else{
							$error = mysql_error();
							$ret = array("erro"=>"2","campo"=>"SQL","msg"=>$error); _retorno($ret);
						}
						
					break;
					
					/*###################*/
				case 'buscarCPagar' :
					/*busca contas a pagar em aberto do fornecedore passado*/
					$idFor = $_GET['idFor'];
					
					$sql = "select * from pagar where fornecedor = '$idFor' and status = '0' ";
					
					$result = mysql_query($sql);	
					$num = mysql_num_rows($result);
					if ($num == 0){	
						echo 'erro';
						exit;	
					}
				
					?> <table class="table table-pesq">
						<tr>
							<td class="formTitulo fRight">Emiss&atilde;o:</td>
							<td class="formTitulo">Valor</td>
							<td class="formTitulo">Vencimento:</td>
                            <td class="formTitulo">&nbsp;</td>
						</tr>
					<?php
						
					while ( $linha = mysql_fetch_array($result)){
													
						?>
						<tr>							
							<td>
								<?php echo $data = date('d/m/Y', strtotime($linha['emissao'])); ?>
							</td>
							<td>
								<?php echo $valor = str_replace(".",",",$linha['valor']); ?>
							</td>
							<td>
								<?php echo $data = date('d/m/Y', strtotime($linha['vencimento']) ); ?>
							</td>
                            <td>
								<a href="javascript:;" id="<?php echo $linha['idpagar']; ?>" class="aConta">Pagar</a>
							</td>
						</tr>
						<?php
						
						
					} //fim do while
					?> </table>	
					<?php
					break;
															
					/*#############*/
					case 'pagarParcela':  
						if(empty($_GET['idParcela']) ){$ret = array("erro"=>"1","campo"=>"idParcela"); _retorno($ret);}						
						
						$idParcela = $_GET['idParcela'];												
						
						
							
						$dataHoje = date('Y-m-d');
						
						$sql = "update pagar set status = '1', datapago = '$dataHoje'
						where idpagar = '$idParcela' ";
						
									
						if($resultado = mysql_query($sql)){
							$ret = array("erro"=>"0","msg"=>"Conta Paga."); _retorno($ret);
						}else{
							$error = mysql_error();
							$ret = array("erro"=>"2","campo"=>"SQL","msg"=>$error); _retorno($ret);
						}
						
					break;
					
					
					
					/*------------------------------*/
							/* Recebimento */
					/*------------------------------*/
					
					/*###################*/
				case 'buscarCliente' :
					/*busca clientes na tela de recebimento de conta*/
					$cliente = $_GET['cliente'];
					$cliente = strtoupper($cliente);
					
					$sql = "select * from clifor where nome LIKE '%".$cliente."%' or razsoc LIKE '%".$cliente."%' ";
					
					$result = mysql_query($sql);	
					$num = mysql_num_rows($result);
					if ($num == 0){	
						echo 'erro';
						exit;	
					}
				
					?> <table class="table table-pesq">
						<tr>
							<td class="formTitulo">Nome:</td>
							<td class="formTitulo">CPF:</td>
							<td class="formTitulo">Cidade:</td>
							<td class="formTitulo">UF:</td>
						</tr>
					<?php
						
					while ( $linha = mysql_fetch_array($result)){
							
						$idCli = $linha['idclifor'];
						
						if ( $linha['razsoc'] == '' ){
							$nomeCli = $linha['nome'];
						}else{
							$nomeCli = $linha['razsoc'];
						}
						
						$idcid = $linha['cidade']; 
						$sql = "select nome from cidade where idcid = '$idcid' ";
						$cidade = mysql_fetch_assoc(mysql_query($sql));
						?>
						<tr>
							<td>
								<a href="javascript:;" id="<?php echo $idCli; ?>" class="aNome"><?php echo $nomeCli; ?></a>
							</td>
							<td>
								<?php echo $linha['cnpjcpf']; ?>
							</td>
							<td>
								<?php echo $cidade['nome']; ?>
							</td>
							<td>
								<?php
								$iduf = $linha['uf']; 
								$sql = "select sigla from uf where iduf = '$iduf' ";
								$uf = mysql_fetch_assoc(mysql_query($sql));
								echo $uf['sigla']; ?>
							</td>
						</tr>
						<?php
						
						
					} //fim do while
					?> </table>	
					<?php
					break;
					
					/*###################*/
				case 'buscarCReceber' :
					/*busca contas a receber em aberto do cliente passado*/
					$idCli = $_GET['idCli'];
					
					$sql = "select * from receber where cliente = '$idCli' and status = '0' ";
					
					$result = mysql_query($sql);	
					$num = mysql_num_rows($result);
					if ($num == 0){	
						echo 'erro';
						exit;	
					}
				
					?> <table class="table table-pesq">
						<tr>
							<td class="formTitulo fRight">Emiss&atilde;o:</td>
							<td class="formTitulo">Valor</td>
							<td class="formTitulo">Vencimento:</td>
                            <td class="formTitulo">&nbsp;</td>
						</tr>
					<?php
						
					while ( $linha = mysql_fetch_array($result)){
													
						?>
						<tr>							
							<td>
								<?php echo $data = date('d/m/Y', strtotime($linha['emissao'])); ?>
							</td>
							<td>
								<?php echo $valor = str_replace(".",",",$linha['valor']); ?>
							</td>
							<td>
								<?php echo $data = date('d/m/Y', strtotime($linha['vencimento']) ); ?>
							</td>
                            <td>
								<a href="javascript:;" id="<?php echo $linha['idrec']; ?>" class="aConta">Receber</a>
							</td>
						</tr>
						<?php
						
						
					} //fim do while
					?> </table>	
					<?php
					break;
															
					/*#############*/
					case 'receberParcela':  
						if(empty($_GET['idParcela']) ){$ret = array("erro"=>"1","campo"=>"idParcela"); _retorno($ret);}						
						
						$idParcela = $_GET['idParcela'];												
																			
						$dataHoje = date('Y-m-d');
						
						$sql = "update receber set status = '1', datarec = '$dataHoje'
						where idrec = '$idParcela' ";
						
									
						if($resultado = mysql_query($sql)){
							$ret = array("erro"=>"0","msg"=>"Conta Recebida."); _retorno($ret);
						}else{
							$error = mysql_error();
							$ret = array("erro"=>"2","campo"=>"SQL","msg"=>$error); _retorno($ret);
						}
						
					break;
					
					
					/*#############*/
					case 'recarregaVenda':  
						if(empty($_GET['idVenda']) ){$ret = array("erro"=>"1","msg"=>"Venda não existe."); _retorno($ret);}						
						
						$idVenda = $_GET['idVenda'];												
												
						$sql = "select * from venda	where idvenda = '$idVenda' ";
																		
									
						if($resultado = mysql_query($sql)){
							
							if( mysql_num_rows($resultado) != '1' ){$ret = array("erro"=>"1","msg"=>"Venda nao existe."); _retorno($ret);}
							
							$linha = mysql_fetch_assoc($resultado);
							
							if( $linha['status'] == '1' ){$ret = array("erro"=>"1","msg"=>"Venda Finalizada"); _retorno($ret);}
							if( $linha['status'] == '2' ){$ret = array("erro"=>"1","msg"=>"Venda Cancelada"); _retorno($ret);}
							
							/**/
							$idcli = 	$linha['cliente'];
							
							$sql = "select * from clifor where idclifor = '$idcli' ";							
							
							$linha = mysql_fetch_array( mysql_query($sql) );
							
							if ( $linha['razsoc'] == '' ){
								$cliente = $linha['nome'];
							}else{
								$cliente = $linha['razsoc'];
							}
							
							
							$sql = " SELECT *,sum(valor) as total FROM itemvenda WHERE venda = '$idVenda' ";							
							
							$linha = mysql_fetch_array( mysql_query($sql) );
							$total = $linha['total'];
							
							/**/
							
							$ret = array(
							"erro"=>"0",
							"idcli"=>$idcli,
							"cliente"=>$cliente,
							"total"=>$total
							); 
							_retorno($ret);
							
							
							
						}else{
							$error = mysql_error();
							$ret = array("erro"=>"1","msg"=>"Erro no SQL"); _retorno($ret);
						}
						
					break;
					
				
				
				default:
					echo 'default do ajax';
				break;
	}// fim do switch
	

} // fim do if(isset($_get));
/**/