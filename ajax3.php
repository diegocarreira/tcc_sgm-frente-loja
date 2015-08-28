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
				// busca os dados de uma venda para estornar, na tela de estorno da venda
				case 'buscaVenda' :
					
					if(empty($_GET['codigo']) ){$ret = array("erro"=>"1","msg"=>"Informe o numero da Venda"); _retorno($ret);}
					
					$codigo = $_GET['codigo'];
					
					$sql = " select * from venda where idvenda = '$codigo' and status <> '2'	";
					
					if($resultado = mysql_query($sql)){
					
						if ( mysql_num_rows($resultado) != '1'){
							$ret = array("erro"=>"1","msg"=>"Venda Inexistente ou cancelada."); _retorno($ret);
						}else{
						
							/**/
							$linha = mysql_fetch_assoc($resultado);
							$cli = $linha['cliente'];
							$dataemi = dataToBra($linha['dataemi']);
							
							$sql = " select * from clifor where idclifor = '$cli' ";
							$resultado = mysql_query($sql);
							$linha2 = mysql_fetch_assoc($resultado);
							
							if($linha2['nome'] == 'NULL' || $linha2['nome'] == ''){
								$cli = $linha2['razsoc'];
							}else{
								$cli = $linha2['nome'];
							}
						
							
						
							$ret = array("erro"=>"0","cliente"=>$cli,"dataemi"=>$dataemi,"codigo"=>$codigo); _retorno($ret);
							/**/
						}
						
						
					}else{
						$error = mysql_error();
						$ret = array("erro"=>"1","msg"=>"erro no mysql_query"); _retorno($ret);
					}
					
					
				
				break;


				/*#############*/
				//faz o estorno de uma venda
				case 'estornaVenda' :
					
					if(empty($_GET['codigo']) ){$ret = array("erro"=>"1","msg"=>"Numero da Venda nao encontrado"); _retorno($ret);}
					
					$codigo = $_GET['codigo']; // id da venda
					
					/* Preencher o valor total da tabela Venda para ter no relatorio */
					
						$sql = "select sum(valor) as total 
						from itemvenda
						where venda = '$codigo' ";
						
						$linha = mysql_fetch_assoc( $resultado = mysql_query($sql));
						
						$valor = $linha['total'];
						
						$sql = " update venda set valortotal = '$valor' where idvenda = '$codigo' ";
						
						mysql_query($sql);
					
					
					/**/
					
					
					$sql1 = " update venda set status = '2' where idvenda = '$codigo' ";
															
					$sql2 = " delete from itemvenda where venda = '$codigo' ";
					
					$sql3 = " update receber set status = '2' where venda = '$codigo' ";
					
					if($resultado = mysql_query($sql3)){
						
						if($resultado = mysql_query($sql2)){
						
							if($resultado = mysql_query($sql1)){
								
								$ret = array("erro"=>"0","msg"=>"Venda Cancelada"); _retorno($ret);
																
							}else{//sql1
							
								$ret = array("erro"=>"1","msg"=>"Erro ao cancelar Venda."); _retorno($ret);
					
							} 
						
						
						}else{//sql2
					
							$ret = array("erro"=>"1","msg"=>"Erro ao cancelar Itens."); _retorno($ret);
						} 
					
					
					}else{//sql3
					
						$ret = array("erro"=>"1","msg"=>"Erro ao cancelar Parcela."); _retorno($ret);
					
					} 														
					
				
				break;
				
				
				
				
				
				
				
				/*###############################################*/
				//Recebimento
				
				// busca os dados de uma Recebimento para estornar, na tela de estorno da Recebimento
				case 'buscaconta' :
					
					if(empty($_GET['cliente']) ){echo "Informe o cliente"; exit; } 
					
					$cliente = $_GET['cliente'];
					
					/*$sql = "
					select rec.*, cli.nome,cli.razsoc from receber rec, clifor cli 
					where rec.cliente = cli.idclifor
					and rec.status = '1'
					and cli.nome LIKE '%".$cliente."%' or cli.razsoc LIKE '%".$cliente."%'
					
					";*/
					
					$sql = "select rec.*, cli.nome, cli.razsoc from receber rec
					LEFT JOIN clifor cli
					ON rec.cliente = cli.idclifor					
					where rec.status = '1'
					and cli.razsoc LIKE '%".$cliente."%' or cli.nome LIKE '%".$cliente."%'
					";
					
					if($resultado = mysql_query($sql)){
					
						
						
							?> <table class="table table-pesq">
								<tr>
									<td class="formTitulo">Cliente:</td>
									<td class="formTitulo">Data Recebimento:</td>
									<td class="formTitulo">valor:</td>
								</tr>
							<?php
								
							while ( $linha = mysql_fetch_array($resultado)){
									
								$cli = $linha['nome'];															
								
								if($cli == 'NULL' || $cli == ''){
									$cli = $linha['razsoc'];
								}
								
								if( $linha['datarec'] == NULL ){
									$datarec = "";
								}else{
									$datarec = dataToBra($linha['datarec']);									
								}
								
								
								?>
								<tr>
									<td>
										<?php echo $cli; ?>
									</td>
									<td>
										<?php echo $datarec; ?>
									</td>
									<td>
										<?php echo str_replace(".",",",$linha['valor']); ?>
									</td>
									<td>
										<a href="javascript:;" id="<?php echo $linha['idrec']; ?>" class='btEstornar btn btn-danger'>Estornar</a>
									</td>
								</tr>
								<?php
								
								
							} //fim do while
							?> </table>	
							<?php
						
						
						
					}else{
						$error = mysql_error();
						//$ret = array("erro"=>"1","msg"=>"erro no mysql_query"); _retorno($ret);
						echo "erro";
					}
					
					
				
				break;


				/*#############*/
				//faz o estorno de uma recebimento
				case 'estornaRecebimento' :
					
					if(empty($_GET['codigo']) ){$ret = array("erro"=>"1","msg"=>"Recebimento não pôde ser estornado"); _retorno($ret);}
					
					$codigo = $_GET['codigo']; // id da conta									
					
					
						$sql = " update receber set status = '0' where idrec = '$codigo' ";
			
						
							if($resultado = mysql_query($sql)){
								
								$ret = array("erro"=>"0","msg"=>"Recebimento Estornado."); _retorno($ret);
																
							}else{
							
								$ret = array("erro"=>"1","msg"=>"Erro ao Estornar Recebimento."); _retorno($ret);
					
							}												
					
					
				
				break;
				
				
				
				
				
				
				/*###############################################*/
				//PAGAMENTO
				
				// busca os dados de uma pagamento para estornar, na tela de estorno da Recebimento
				case 'buscaPagamento' :
					
					if(empty($_GET['cliente']) ){echo "Informe o Fornecedor"; exit; } 
					
					$cliente = $_GET['cliente'];
					
					$sql = "
					select pag.*, cli.nome,cli.razsoc from pagar pag, clifor cli 
					where pag.fornecedor = cli.idclifor
					and pag.status = '1'
					and cli.nome LIKE '%".$cliente."%' or cli.razsoc LIKE '%".$cliente."%'
					
					";
					
					if($resultado = mysql_query($sql)){
					
						
						
							?> <table class="table table-pesq">
								<tr>
									<td class="formTitulo">Cliente:</td>
									<td class="formTitulo">Data Pagamento:</td>
									<td class="formTitulo">valor:</td>
								</tr>
							<?php
								
							while ( $linha = mysql_fetch_array($resultado)){
									
								$cli = $linha['nome'];															
								
								if($cli == 'NULL' || $cli == ''){
									$cli = $linha['razsoc'];
								}
								
								if( $linha['datapago'] == NULL ){
									$datapago = "";
								}else{
									$datapago = dataToBra($linha['datapago']);									
								}
								
								
								?>
								<tr>
									<td>
										<?php echo $cli; ?>
									</td>
									<td>
										<?php echo $datapago; ?>
									</td>
									<td>
										<?php echo str_replace(".",",",$linha['valor']); ?>
									</td>
									<td>
										<a href="javascript:;" id="<?php echo $linha['idpagar']; ?>" class='btEstornar btn btn-danger'>Estornar</a>
									</td>
								</tr>
								<?php
								
								
							} //fim do while
							?> </table>	
							<?php
						
						
						
					}else{
						$error = mysql_error();
						//$ret = array("erro"=>"1","msg"=>"erro no mysql_query"); _retorno($ret);
						echo "erro";
					}
					
					
				
				break;


				/*#############*/
				//faz o estorno de uma pagamento
				case 'estornaPagamento' :
					
					if(empty($_GET['codigo']) ){$ret = array("erro"=>"1","msg"=>"Pagamento não pôde ser estornado"); _retorno($ret);}
					
					$codigo = $_GET['codigo']; // id da conta									
					
					
						$sql = " update pagar set status = '0' where idpagar = '$codigo' ";
			
						
							if($resultado = mysql_query($sql)){
								
								$ret = array("erro"=>"0","msg"=>"Pagamento Estornado."); _retorno($ret);
																
							}else{
							
								$ret = array("erro"=>"1","msg"=>"Erro ao Estornar Pagamento."); _retorno($ret);
					
							}												
					
					
				
				break;				
				
				
				
				
				/*###############################################*/
				//ESTORNO DA conta a pagar
				
				// busca os dados de uma conta a pagar para estornar
				case 'buscaPagar' :
					
					if(empty($_GET['cliente']) ){echo "Informe o Fornecedor"; exit; } 
					
					$cliente = $_GET['cliente'];
					
					$sql = "
					select pag.*, cli.razsoc from pagar pag
					LEFT JOIN clifor cli
					ON pag.fornecedor = cli.idclifor					
					where pag.status <> '2'
					and cli.razsoc LIKE '%".$cliente."%'
					
					";
					
					
					if($resultado = mysql_query($sql)){
					
						
						
							?> <table class="table table-pesq">
								<tr>
									<td class="formTitulo">Cliente:</td>
									<td class="formTitulo">Emitido em:</td>
									<td class="formTitulo">Valor:</td>
                                    <td class="formTitulo">Status:</td>
								</tr>
							<?php
								
							while ( $linha = mysql_fetch_array($resultado)){
									
							
								$cli = $linha['razsoc'];
								
								
								
								$dataemi = dataToBra($linha['emissao']);									
								
								
								
								?>
								<tr>
									<td>
										<?php echo $cli; ?>
									</td>
									<td>
										<?php echo $dataemi; ?>
									</td>
									<td>
										<?php echo str_replace(".",",",$linha['valor']); ?>
									</td>
                                    
                                    <td style="color:#333">
										<?php
                                        	if($linha['status'] == '0'){
												echo 'Aberta';
											}else{
												echo 'Paga';
											}
											
										?>
									</td>
									
                                    <td>
										<a href="javascript:;" id="<?php echo $linha['idpagar']; ?>" class='btEstornar btn btn-danger'>Estornar</a>
									</td>
								</tr>
								<?php
								
								
							} //fim do while
							?> </table>	
							<?php
						
						
						
					}else{
						$error = mysql_error();
						//$ret = array("erro"=>"1","msg"=>"erro no mysql_query"); _retorno($ret);
						echo "erro";
					}
					
					
				
				break;


				/*#############*/
				//faz o estorno de uma conta a pagar
				case 'estornaPagar' :
					
					if(empty($_GET['codigo']) ){$ret = array("erro"=>"1","msg"=>"Conta nao pode ser estornada"); _retorno($ret);}
					
					$codigo = $_GET['codigo']; // id da conta									
					
					
						$sql = " update pagar set status = '2' where idpagar = '$codigo' ";
			
						
							if($resultado = mysql_query($sql)){
								
								$ret = array("erro"=>"0","msg"=>"Conta a Pagar Cancelada."); _retorno($ret);
																
							}else{
							
								$ret = array("erro"=>"1","msg"=>"Erro ao Estornar Conta."); _retorno($ret);
					
							}												
														
				break;
				
				
				
				
				default:
					echo 'default do ajax';
				break;
	}// fim do switch
	

} // fim do if(isset($_get));
/**/