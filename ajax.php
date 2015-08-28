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

if ( isset($_GET['origem']) and ($_GET['origem'] != '')){
	
	$origem = $_GET['origem'];

	
	switch ($origem){
			case "entradaPro":
				/*busca produto na Entrada*/	
				$barras = $_GET['barras'];
					$sql = " select * from itemproduto where barras  = '$barras'	";
					
					$result = mysql_query($sql);
					$linha = mysql_fetch_assoc($result);
					//echo $linha['idpro'];
					$idpro = $linha['idpro'];
					$tam = $linha['tam'];
					
					if ($idpro == ''){
						$ret = array("erro"=>"1", "msg"=>"Produto Inexistente");
						_retorno($ret);
					}
					$sql = " select * from produto where idpro  = '$idpro'	";
					
					$result = mysql_query($sql);
					$linha = mysql_fetch_assoc($result);
					//echo $linha['descricao'];
					$desc = $linha['descricao'];					
					$ret = array("erro"=>"0","descricao"=>$desc,"tam"=>$tam);
					_retorno($ret);
				
				
				break;
				
				/*###################*/
				case 'vendaCliente' :
					/*busca cliente na Venda*/
					$cliente = $_GET['cliente'];
					$cliente = strtoupper($cliente);
					
					//$sql = " select * from clifor where  ( nome  like '%".$cliente."' ) or ( razsoc like '%".$cliente."' ) ";
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
				
				/*############################*/	 
				case 'vendaItem' :
					/* BUSCA produto pra venda*/	
					$barras = $_GET['codigo'];
					$sql = " select * from itemproduto where barras  = '$barras'	";
					
					$result = mysql_query($sql);
					$linha = mysql_fetch_assoc($result);
					//echo $linha['idpro'];
					$idpro = $linha['idpro'];
					
					if ($idpro == ''){
						$erro['erro'] =  'erro';
						echo json_encode($erro);
						exit;
					}
					$sql = " select * from produto where idpro  = '$idpro'	";
					
					$result = mysql_query($sql);
					$linha = mysql_fetch_assoc($result);
					echo json_encode($linha);
				break;
					
				
				
				/*###############*/
				case 'gravaCabecalhoVenda':
					if(empty($_GET['idcli']) ){echo("erro:cliente"); return;}
					/**/
					$cliente = $_GET['idcli'];
					$data = date("Y-m-d");
					
					//echo "salvou";
					$sql = " insert into venda ( cliente, dataemi) values ( '$cliente','$data' ) ";
					if ($resultado = mysql_query($sql)){
						echo $idVenda = mysql_insert_id();						
					}else{
						echo 'erro:SQL';
					}										
				break;
				
				
				/*###################*/
				case 'gravaItem':
					if(empty($_GET['codigo']) ){$ret = array("erro"=>"1","campo"=>"codigo"); _retorno($ret);}
					if(empty($_GET['qtd']) || $_GET['qtd'] == 0 ){$ret = array("erro"=>"1","campo"=>"qtd"); _retorno($ret);}
					if(empty($_GET['idvenda']) ){$ret = array("erro"=>"1","campo"=>"idvenda"); _retorno($ret);}
					/**/
					$barras = $_GET['codigo'];
					$qtd = (int) $_GET['qtd'];
					$idVenda = $_GET['idvenda'];
					
					//busco os dados do produto pelo codigo de barras que inserí.
					$sql = " select itemproduto.*, produto.valor from itemproduto,produto where itemproduto.idpro = produto.idpro and barras = '$barras' ";
					$resultado = mysql_query($sql);
					$produto = mysql_fetch_assoc($resultado);
					if ($qtd > $produto['estoque']){
						$ret = array("erro"=>"2","msg"=>"Estoque Insuficiente"); _retorno($ret); //significa estoque insuficiente
					}else{	
						$idPro = 	$produto['idpro'];
						$tam = 	$produto['tam'];
						$preco = (int) $produto['valor'];
						$valor = ($preco * $qtd);
																								
						//echo "salvou";
						//faco a insercao do item em itemvenda.
						
						$sql = " insert into itemvenda (venda, idpro, tam, qtd, valor) values ( '$idVenda','$idPro','$tam','$qtd', '$valor' ) ";
						
						if ($resultado = mysql_query($sql)){
							//$_SESSION['totalVenda'] += $valor;
							$ret = array("erro"=>"0","msg"=>"Item Gravado."); _retorno($ret);
												
						}else{
							$ret = array("erro"=>"2","msg"=>"Erro ao Gravar"); _retorno($ret);
						}	
					}					
				break;
				
				
				/*###################*/
				case 'deletaItem':
					if(empty($_GET['iditem']) ){$ret = array("erro"=>"1","campo"=>"item"); _retorno($ret);}
					if(empty($_GET['idvenda']) ){$ret = array("erro"=>"1","campo"=>"venda"); _retorno($ret);}
					/**/
					$idItem = $_GET['iditem'];
					$idVenda = $_GET['idvenda'];
					
					$linha1 = mysql_fetch_assoc($resultado = mysql_query($sql1 = " select idpro,tam from itemproduto where barras = '$idItem' "));
					//$linha2 = mysql_fetch_assoc($resultado = mysql_query($sql2 = " select tam from itemproduto where barras = '$idItem' "));
					$idpro = $linha1['idpro'];
					$tam = $linha1['tam'];
					
					$sql = " delete from itemvenda 
					where venda = '$idVenda' and 
					idpro = '$idpro' and 
					tam = '$tam' ";
									
					
					if (mysql_query($sql)){						
						$ret = array("erro"=>"0","msg"=>"Item Excluído."); _retorno($ret);
											
					}else{
						//$ret = array("erro"=>"2","msg"=>"Erro ao excluir Item."); _retorno($ret);
						$error = mysql_error();
						$ret = array("erro"=>"2","msg"=>$error); _retorno($ret);
					}	
										
				break;
				
				
				/*#########################*/	
				case 'gravaVenda':
					if(empty($_GET['venda']) ){echo("erro:venda"); return;}
					if(empty($_GET['prazo']) || $_GET['prazo'] == 0 ){echo("erro:prazo"); return;}
					if(empty($_GET['vendedor']) || $_GET['prazo'] == 0){echo("erro:vendedor"); return;}	
					/**/
					$venda = $_GET['venda'];										
					$prazo = $_GET['prazo'];
					$vendedor = $_GET['vendedor'];
					$total = $_SESSION['totalVenda'];
					if(isset($_GET['desconto']) && $_GET['desconto'] != ''){
						
						if(!is_numeric($_GET['desconto'])){echo("erro:desconto"); return;}
						
						$desconto = $_GET['desconto'];
					}else{
						$desconto = 0;
					}
					$total = $total - $desconto;
					
					//echo "salvou";
					$sql = " update venda set vendedor = '$vendedor', prazo = '$prazo', valortotal = '$total', status = '1' , desconto = '$desconto'
						where idvenda = '$venda' ";
					
					$res = mysql_query($sql);
					/*parcelas*/
					$sql = " select * from venda where idvenda = '$venda' ";
					$linha = mysql_fetch_assoc($resultado = mysql_query($sql));
					$cliente = $linha['cliente'];
					
					$aParcelas = $_SESSION['parcelas'];
					$data = date("Y-m-d");
					
					foreach($aParcelas as $aParcela){
						$num = $aParcela['num'];
						$venc = $aParcela['vencimento'];
						$valor = $aParcela['valor'];
						$sql = " insert into receber (cliente, venda, numparcela, emissao, vencimento, valor)
						values ( '$cliente', '$venda', '$num', '$data' , '$venc', '$valor' )
						 ";
							
						if ($resultado = mysql_query($sql)){
							echo "Venda Gravada.";						
						}else{
							//echo 'erro:'.$sql.'';
							echo 'erro:SQL';
						}
					}
				break;
				
				
				/*######################*/
				case 'alimentaGrid' :
					if(empty($_GET['venda']) ){ echo "erro:venda:Cabeçalho da venda não gravado.";}
					$venda = $_GET['venda'];
					
					$sql = "
		select itemproduto.barras, produto.descricao, itemproduto.tam, produto.valor as preco, sum(itemvenda.qtd) as qtd, sum(itemvenda.valor) as valor, (select sum(valor) from itemvenda where venda = '$venda') as valorTotal 
			from itemvenda, produto, itemproduto 
		where itemvenda.idpro = produto.idpro and itemvenda.idpro = itemproduto.idpro and itemvenda.tam = itemproduto.tam and itemvenda.venda = '$venda' 
			group by itemproduto.barras";
							
					if($resultado = mysql_query($sql)){
					
						while ( $linha = mysql_fetch_array($resultado)){
							$_SESSION['totalVenda'] = $linha['valorTotal'];
						?>
						<tr class="trGrid" data="<?php echo $linha['barras']; ?>">
							<td class="textRight">
								<?php echo $linha['barras']; ?>
							</td>
							<td>
								<?php echo $linha['descricao']." - ".$linha['tam'];; ?>
							</td>
							<td class="textRight">
								<?php echo str_replace(".",",",$linha['preco']) ; ?>
							</td>
                            <td class="textRight">
								<?php echo $linha['qtd']; ?>
							</td>
                            <td class="textRight">
								<?php echo str_replace(".",",",$linha['valor']) ; ?>
							</td>
                            <td class="textCenter">
								<a class="btDeleteItem" href="javascript:;" id="<?php echo $linha['barras']; ?>">X</a>
							</td>	
                         </tr>
							
							 
						<?php 
						}//fim do while
					
					}else{
						echo "erro:SQL:Erro na instrução.";
					}										
				break;	
				
				
				/*###################*/
				case 'atuValorTotal':									
					$tot = $_SESSION['totalVenda'];
					$ret = array("erro"=>"0", "valorTotal"=> $tot); _retorno($ret);
				
				break;												
				
				
				/**/
				/*############################*/	 
				case 'buscaParcelas' :
					/* BUSCA os dias do prazo escolhido */
					if(empty($_GET['prazo']) ){ echo "erro:prazo:Prazo não selecionado.";	}
					
					if(isset($_GET['desconto']) && $_GET['desconto'] != ''){
						
						if(!is_numeric($_GET['desconto'])){echo("erro:desconto:Corrija o campo Desconto"); return;}
						
						$desconto = $_GET['desconto'];
					}else{
						$desconto = 0;
					}
					/**/
					
					
					$prazo = $_GET['prazo'];
					$sql = " select * from itemprazo where prazo  = '$prazo' ";
					
					if($result = mysql_query($sql) ){
						/**/
						$_SESSION['parcelas'] = array();
						/**/
						$cont = mysql_num_rows($result);
						$i = 0;
						$valor = number_format($_SESSION['totalVenda'] , 2);
						$valor =  number_format($valor - $desconto);
						$valorParc =  number_format( $valor / $cont , 2 );
						
						while($linha = mysql_fetch_assoc($result)){
							$i++;
							//$dias[] = $linha['dias'];
							?>
							<tr class="trParc">
								<td class="textRight">
									<?php echo $i; ?>
								</td>
								<td>
									<?php 
										$data = date("d-m-Y");
										$dias = $linha['dias'];
										$venc = date( "d/m/Y" , strtotime( $data . " +".$dias." day") );
										echo $venc ;
									?>
								</td>
								<td class="textRight">
									<?php 
										//echo $valorParc;   
										if ($i != $cont){											 
											echo str_replace('.', ',' ,$valorParc);  
										}else{
											echo str_replace('.', ',' , $valorParc = number_format($valor - ($valorParc * $cont)+$valorParc,2));
										}
										/*aqui alimento a sessao com as parcelas da venda atual*/
											$venc = str_replace('/','-',$venc); //troco as barras por traco senao da erro de conversao abaixo.
											$venc = date( "Y-m-d" , strtotime($venc)); //coloco a data em formato EUA pra gravar no BD.
											$parcela = array("num"=>$i, "vencimento"=>$venc, "valor"=>$valorParc );
											$_SESSION['parcelas'][] = $parcela;
										/**/
									?>
								</td>                                                                                  	
							 </tr>
														 
							<?php 
						} //fim do while
					}else{
						echo "erro:SQL:Erro na instrução de busca.";
					}			
										
				break;
				
					
				default:
					echo 'default do ajax';
				break;
	}// fim do switch
	

} // fim do if(isset($_get));
/**/