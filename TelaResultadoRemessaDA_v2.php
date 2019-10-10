<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Sistema de Análise da Dívida ativa</title>
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
	<script src="bootstrap-4.3.1-dist/js/bootstrap.js"></script>
	
	<script lang="javascript" src="js/jquery-3.4.1.min.js"></script>
	
	<style>
		#lista{
			font-size:11px;
		}
	</style>

</head>
<body>

	<?php 
		require_once "menu.php";
		require_once "conexao.php";
		require_once "selecionarDadosRemessa.php";

		$pdo = conectar();
		$natureza = $_POST["natureza"];
		
		if($tableExists = $pdo->query("SHOW TABLES LIKE 'baseacompanhamento$natureza'")->rowCount() > 0){
			
			$arrayexerciciosEDados = buscarColunasExercicosEDados($pdo, $natureza);
			$select = selectGerarViewRemessa($natureza, $arrayexerciciosEDados, $pdo);
			criarViewRemessa($select, $natureza, $pdo);
		?>		
			<div class="container">
				<div class="card">
					<div class="card-header" align="center">
						<h5><strong>Remessa - Cadastro Completo <h4 style="color: #C00"><strong>Dívida Ativa <?php echo $natureza; ?></strong></h4></strong></h5>
					</div>
					<div class="card-body float-left" align="center">
						 <div class="card" style="width: 21rem; margin-top:20px; margin-left:5%;">
							<div class="card-header" align="center">
							  <strong>Débitos tratados para a remessa</strong>
							</div>
							<br>
							<div align="left" style="margin-left:10%;">
								<strong style="font-size:13px">QTD de Sequenciais: </strong><strong style="font-size:13px; color: #F00;"><?php $retornoSelect = somaCountViewTratadosRemessa($natureza, $pdo); echo $retornoSelect[0][1];?></strong>	
								<br>
								<strong style="font-size:13px">Valor em Aberto:</strong><strong style="font-size:13px; color: #F00;"> R$ <?php $retornoSelect = somaCountViewTratadosRemessa($natureza, $pdo); echo number_format($retornoSelect[0][0],2,",",".");?></strong>
							</div>
							<hr>
							<table align="center">
								<tr width="120" align="center">
								  <td>
										<form method="post" action="GeracaoCSVRemessa.php">
											<input type="hidden" name="natureza" value="<?php echo $natureza?>">
											<input type="hidden" name="tipoacao" value="tratadosRemessa">
											<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar Remessa </button>
										</form>
								   </td>
								</tr>
							</table>
							<br>
							<h6 align="left" style="font-size:11px; margin-left:10px;">Critérios:</h6>
							   <ul align="left"; id="lista">
								<li>Com CPF Válido</li>
								<li>Com Nome e pelo menos um Sobrenome</li>
								<li>Débitos Não Prescritos</li>
								<li>Débitos Sem Suspensão de Exigibilidade</li>
								<li>Soma dos Débitos acima do Valor de Alçada</li>
								<li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
							   </ul>
							   <h6 align="left" style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Os últimos 2 exercícios, foram considerados para remessa, apenas em necessidade de serem juntados com anos anteriores para atingir o Valor de Alçada.</h6>
						</div>  
					</div>
				</div>
				<br>
				
				<div class="card">
					<div class="card-header" align="center">
						<h5><strong>Análise para Remessa</strong></h4></strong></h5>
					</div>
					<div class="card-body float-left" align="center">
						<div class="float-left">
							<div class="card" style="width: 21rem; margin-top:20px; margin-left:5%;">
							  <div class="card-header" align="center">
								<strong>CPF/CNPJ em Branco + <br> Apenas 1 Nome</strong>
							  </div><br>
								<div align="left" style="margin-left:10%;">
									<strong style="font-size:13px">QTD de Sequenciais: </strong><strong style="font-size:13px; color: #F00;"><?php $retornoSelect = somaCountViewAnaliseRemessaCPFBrancoApenasNome($natureza, $pdo); echo $retornoSelect[0][1];?></strong>	
									<br>
									<strong style="font-size:13px">Valor em Aberto:</strong><strong style="font-size:13px; color: #F00;"> R$ <?php $retornoSelect = somaCountViewAnaliseRemessaCPFBrancoApenasNome($natureza, $pdo); echo number_format($retornoSelect[0][0],2,",",".");?></strong>
								</div>
								<hr>
								<table align="center" width="280">
									<tr>
									  <td width="80" align="left">
											<button id="chamarFormulario" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
									  </td>
									  <td width="120" align="center" >
										<form method="post" action="GeracaoCSVRemessa.php">
											<input type="hidden" name="natureza" value="<?php echo $natureza?>">
											<input type="hidden" name="tipoacao" value="RemessaAnaliseRemessaBrancoUm">
											<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
										</form>
									  </td>
									</tr>
								</table>
								   <br>
							<h6 align="left" style="font-size:11px; margin-left:10px;">Critérios:</h6>
							   <ul align="left"; id="lista">
								<li>Débitos Não Prescritos</li>
								<li>Débitos Sem Suspensão de Exigibilidade</li>
								<li>Soma dos Débitos acima do Valor de Alçada</li>
								<li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
							   </ul>
							   <h6 align="left" style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Os últimos 2 exercícios, foram considerados para remessa, apenas em necessidade de serem juntados com anos anteriores para atingir o Valor de Alçada.</h6>
							</div>																	  
						 </div>
						 <div class="float-left">
							<div class="card" style="width: 21rem; margin-top:20px; margin-left:10%; ">
							 <div class="card-header" align="center">
								<strong>CPF/CNPJ Inválido + <br> Apenas 1 Nome</strong>
							  </div>
									<br>
									<div align="left" style="margin-left:10%;">
										<strong style="font-size:13px">QTD de Sequenciais: </strong><strong style="font-size:13px; color: #F00;"><?php $retornoSelect = somaCountViewAnaliseRemessaCPFInvalidoApenasNome($natureza, $pdo); echo $retornoSelect[0][1];?></strong>	
										<br>
										<strong style="font-size:13px">Valor em Aberto:</strong><strong style="font-size:13px; color: #F00;"> R$ <?php $retornoSelect = somaCountViewAnaliseRemessaCPFInvalidoApenasNome($natureza, $pdo); echo number_format($retornoSelect[0][0],2,",",".") ;?></strong>
									</div>
									<hr>
										
									<table align="center" width="280">
										<tr>
										  <td width="80" align="left">
											<button type="submit" id="chamarFormulario2" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
										  </td>
										  <td width="120" align="center" >
											<form method="post" action="GeracaoCSVRemessa.php">
												<input type="hidden" name="natureza" value="<?php echo $natureza?>">
												<input type="hidden" name="tipoacao" value="RemessaAnaliseRemessaInvalidoUm">
												<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
											</form>
										  </td>
										</tr>
									</table>
									<br>
									<h6 align="left" style="font-size:11px; margin-left:10px;">Critérios:</h6>
									   <ul align="left"; id="lista">
										<li>Débitos Não Prescritos</li>
										<li>Débitos Sem Suspensão de Exigibilidade</li>
										<li>Soma dos Débitos acima do Valor de Alçada</li>
										<li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
									   </ul>
									<h6 align="left" style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Os últimos 2 exercícios, foram considerados para remessa, apenas em necessidade de serem juntados com anos anteriores para atingir o Valor de Alçada.</h6>
							</div>
						 </div>
						 <div class="float-left">
							<div class="card" style="width: 21rem; margin-top:20px; margin-left:15%; ">
							  <div class="card-header" align="center">
								<strong>CPF/CNPJ Válido + <br> Apenas 1 Nome</strong>
							  </div><br>
							  <div align="left" style="margin-left:10%;">
									<strong style="font-size:13px">QTD de Sequenciais: </strong><strong style="font-size:13px; color: #F00;"><?php $retornoSelect = somaCountViewAnaliseRemessaCPFValidoApenasNome($natureza, $pdo); echo $retornoSelect[0][1];?></strong>	
									<br>
									<strong style="font-size:13px">Valor em Aberto:</strong><strong style="font-size:13px; color: #F00;"> R$ <?php $retornoSelect = somaCountViewAnaliseRemessaCPFValidoApenasNome($natureza, $pdo); echo number_format($retornoSelect[0][0],2,",",".");?></strong>
								</div>
								<hr>
								<table align="center" width="280">
									<tr>
									  <td width="80" align="left">
										<button type="submit" id="chamarFormulario3" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
									  </td>
									  <td width="120" align="center" >								  
										<form method="post" action="GeracaoCSVRemessa.php">
											<input type="hidden" name="natureza" value="<?php echo $natureza?>">
											<input type="hidden" name="tipoacao" value="RemessaAnaliseRemessaValidoUm">
											<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
										</form>
									  </td>
									</tr>
								</table>
								<br>
								<h6 align="left" style="font-size:11px; margin-left:10px;">Critérios:</h6>
								   <ul align="left"; id="lista">
									<li>Débitos Não Prescritos</li>
									<li>Débitos Sem Suspensão de Exigibilidade</li>
									<li>Soma dos Débitos acima do Valor de Alçada</li>
									<li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
								   </ul>
								<h6 align="left" style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Os últimos 2 exercícios, foram considerados para remessa, apenas em necessidade de serem juntados com anos anteriores para atingir o Valor de Alçada.</h6>
							</div>
						 </div>
						 
						 <div class="float-left">
							<div class="card" style="width: 21rem; margin-top:20px; margin-left:5%;">
							  <div class="card-header" align="center">
								<strong>CPF/CNPJ em Branco + <br> Nome e Sobrenome</strong>
							  </div><br>
							  <div align="left" style="margin-left:10%;">
									<strong style="font-size:13px">QTD de Sequenciais: </strong><strong style="font-size:13px; color: #F00;"><?php $retornoSelect = somaCountViewAnaliseRemessaCPFBrancoNomeSobrenome($natureza, $pdo); echo $retornoSelect[0][1];?></strong>	
									<br>
									<strong style="font-size:13px">Valor em Aberto:</strong><strong style="font-size:13px; color: #F00;"> R$ <?php $retornoSelect = somaCountViewAnaliseRemessaCPFBrancoNomeSobrenome($natureza, $pdo); echo number_format($retornoSelect[0][0],2,",",".");?></strong>
								</div>
								<hr>
								<table align="center" width="280">
									<tr>
									  <td width="80" align="left">
											<button id="chamarFormulario" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
									  </td>
									  <td width="120" align="center" >
										<form method="post" action="GeracaoCSVRemessa.php">
											<input type="hidden" name="natureza" value="<?php echo $natureza?>">
											<input type="hidden" name="tipoacao" value="RemessaAnaliseRemessaBrancoDois">
											<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
										</form>
									  </td>
									</tr>
								</table>
								<br>
								<h6 align="left" style="font-size:11px; margin-left:10px;">Critérios:</h6>
								   <ul align="left"; id="lista">
									<li>Débitos Não Prescritos</li>
									<li>Débitos Sem Suspensão de Exigibilidade</li>
									<li>Soma dos Débitos acima do Valor de Alçada</li>
									<li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
								   </ul>
								<h6 align="left" style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Os últimos 2 exercícios, foram considerados para remessa, apenas em necessidade de serem juntados com anos anteriores para atingir o Valor de Alçada.</h6>
							</div>  
						 </div>
						 <div class="float-left">
							<div class="card" style="width: 21rem; margin-top:20px; margin-left:10%; ">
							  <div class="card-header" align="center">
								<strong>CPF/CNPJ Inválido + <br> Nome e Sobrenome</strong>
							  </div><br>
							  
							  <div align="left" style="margin-left:10%;">
									<strong style="font-size:13px">QTD de Sequenciais: </strong><strong style="font-size:13px; color: #F00;"><?php $retornoSelect = somaCountViewAnaliseRemessaCPFInvalidoNomeSobrenome($natureza, $pdo); echo $retornoSelect[0][1];?></strong>	
									<br>
									<strong style="font-size:13px">Valor em Aberto:</strong><strong style="font-size:13px; color: #F00;"> R$ <?php $retornoSelect = somaCountViewAnaliseRemessaCPFInvalidoNomeSobrenome($natureza, $pdo); echo number_format($retornoSelect[0][0],2,",",".") ;?></strong>
								</div>
								<hr>
									<table align="center" width="280">
										<tr>
										  <td width="80" align="left">
											<button type="submit" id="chamarFormulario2" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
										  </td>
										  <td width="120" align="center" >
											<form method="post" action="GeracaoCSVRemessa.php">
												<input type="hidden" name="natureza" value="<?php echo $natureza?>">
												<input type="hidden" name="tipoacao" value="RemessaAnaliseRemessaInvalidoDois">
												<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
											</form>
										  </td>
										</tr>
									</table>
									<br>
									<h6 align="left" style="font-size:11px; margin-left:10px;">Critérios:</h6>
									   <ul align="left"; id="lista">
										<li>Débitos Não Prescritos</li>
										<li>Débitos Sem Suspensão de Exigibilidade</li>
										<li>Soma dos Débitos acima do Valor de Alçada</li>
										<li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
									   </ul>
									<h6 align="left" style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Os últimos 2 exercícios, foram considerados para remessa, apenas em necessidade de serem juntados com anos anteriores para atingir o Valor de Alçada.</h6>
							</div>
						 </div>
						 
					</div>
				</div>
				<br>
				<div class="card">
					<div class="card-header" align="center">
						<h5><strong>Não Remeter</strong></h4></strong></h5>
					</div>
					<div class="card-body float-left" align="center">
						<div class="float-left">
							<div class="card" style="width: 21rem; margin-top:20px; margin-left:5%;">
							  <div class="card-header" align="center">
								<strong>Débitos abaixo do <br> Valor de Alçada</strong>
							  </div><br>
							  
							  <div align="left" style="margin-left:10%;">
									<strong style="font-size:13px">QTD de Sequenciais: </strong><strong style="font-size:13px; color: #F00;"><?php $retornoSelect = somaCountViewNaoRemeterValorInfimo($natureza, $pdo); echo $retornoSelect[0][1];?></strong>	
									<br>
									<strong style="font-size:13px">Valor em Aberto:</strong><strong style="font-size:13px; color: #F00;"> R$ <?php $retornoSelect = somaCountViewNaoRemeterValorInfimo($natureza, $pdo); echo number_format($retornoSelect[0][0],2,",",".") ;?></strong>
								</div>
								<hr>
										<table align="center" width="280">
											<tr>
											  <td width="80" align="left">
													<button id="chamarFormulario" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
											  </td>
											  <td width="120" align="center" >
												<form method="post" action="GeracaoCSVRemessa.php">
													<input type="hidden" name="natureza" value="<?php echo $natureza?>">
													<input type="hidden" name="tipoacao" value="NaoRemeterValorInfimo">
													<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
												</form>
											  </td>
											</tr>
										</table>
								   <br>
									<h6 align="left" style="font-size:11px; margin-left:10px;">Critérios:</h6>
									   <ul align="left"; id="lista">
										<li>Débitos Não Prescritos</li>
										<li>Débitos Sem Suspensão de Exigibilidade</li>
										<li>Soma dos Débitos abaixo do Valor de Alçada</li>
										<li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
									   </ul>
									<h6 align="left" style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Os últimos 2 exercícios, foram considerados para remessa, apenas em necessidade de serem juntados com anos anteriores para atingir o Valor de Alçada.</h6>
							</div>  
						 </div>
						 <div class="float-left">
							<div class="card" style="width: 21rem; margin-top:20px; margin-left:10%; ">
							  <div class="card-header" align="center">
								<strong>CMC com ATIVIDADE ENCERRADA <br> com Débitos</strong>
							  </div><br>
							  <div align="left" style="margin-left:10%;">
									<strong style="font-size:13px">QTD de Sequenciais: </strong><strong style="font-size:13px; color: #F00;"><?php $retornoSelect = somaCountViewNaoRemeterAtivEncerrada($natureza, $pdo); echo $retornoSelect[0][1];?></strong>	
									<br>
									<strong style="font-size:13px">Valor em Aberto:</strong><strong style="font-size:13px; color: #F00;"> R$ <?php $retornoSelect = somaCountViewNaoRemeterAtivEncerrada($natureza, $pdo); echo number_format($retornoSelect[0][0],2,",",".") ;?></strong>
								</div>
								<hr>
									<table align="center" width="280">
										<tr>
										  <td width="80" align="left">
											<button type="submit" id="chamarFormulario3" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
										  </td>
										  <td width="120" align="center" >							  
											<form method="post" action="GeracaoCSVRemessa.php">
												<input type="hidden" name="natureza" value="<?php echo $natureza?>">
												<input type="hidden" name="tipoacao" value="NaoRemeterAtvEncerrada">
												<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
											</form>
										  </td>
										</tr>
									</table>
									<br>
									<h6 align="left" style="font-size:11px; margin-left:10px;">Critérios:</h6>
									   <ul align="left"; id="lista">
										<li>Débitos Sem Suspensão de Exigibilidade</li>
										<li>CMC com Situação em Ativ. Encerrada (Mercantil)</li>
									   </ul>
									   <br>
									   <br>
									   <br>
							</div>
						 </div>
						 
						 <div class="float-left">
							<div class="card" style="width: 21rem; margin-top:20px; margin-left:15%;">
							  <div class="card-header" align="center">
								<strong>Débitos Passíveis de <br> Prescrição</strong>
							  </div><br>
							  
								<div align="left" style="margin-left:10%;">
									<strong style="font-size:13px">QTD de Sequenciais: </strong><strong style="font-size:13px; color: #F00;"><?php $retornoSelect = somaCountViewNaoRemeterPrescritos($natureza, $pdo); echo $retornoSelect[0][1];?></strong>	
									<br>
									<strong style="font-size:13px">Valor em Aberto:</strong><strong style="font-size:13px; color: #F00;"> R$ <?php $retornoSelect = somaCountViewNaoRemeterPrescritos($natureza, $pdo); echo number_format($retornoSelect[0][0],2,",",".") ;?></strong>
								</div>
								<hr>
								<table align="center" width="280">
									<tr>
									  <td width="80" align="left">
											<button id="chamarFormulario" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
									  </td>
									  <td width="120" align="center" >
										<form method="post" action="GeracaoCSVRemessa.php">
											<input type="hidden" name="natureza" value="<?php echo $natureza?>">
											<input type="hidden" name="tipoacao" value="NaoRemeterPrescritos">
											<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
										</form>
									  </td>
									</tr>
								</table>
								<br>
								<h6 align="left" style="font-size:11px; margin-left:10px;">Critérios:</h6>
								   <ul align="left"; id="lista">
									<li>Débitos Prescritos</li>
									<li>Débitos Sem Suspensão de Exigibilidade</li>
								   </ul>
								   <br>
								   <br>
								   <br>
							</div>  
						 </div>
						 <br>
						 <div class="float-left">
							<div class="card" style="width: 21rem; margin-top:20px; margin-left:5%; ">
							  <div class="card-header" align="center">
								<strong>Débitos com Exigibilidade <br> Suspensa</strong>
							  </div><br>
							  
							<div align="left" style="margin-left:10%;">
								<strong style="font-size:13px">QTD de Sequenciais: </strong><strong style="font-size:13px; color: #F00;"><?php $retornoSelect = somaCountViewNaoRemeterExigSuspensa($natureza, $pdo); echo $retornoSelect[0][1];?></strong>	
								<br>
								<strong style="font-size:13px">Valor em Aberto:</strong><strong style="font-size:13px; color: #F00;"> R$ <?php $retornoSelect = somaCountViewNaoRemeterExigSuspensa($natureza, $pdo); echo number_format($retornoSelect[0][0],2,",",".") ;?></strong>
							</div>
							<hr>
							<table align="center" width="280">
								<tr>
								  <td width="80" align="left">
									<button type="submit" id="chamarFormulario2" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
								  </td>
								  <td width="120" align="center" >
									<form method="post" action="GeracaoCSVRemessa.php">
										<input type="hidden" name="natureza" value="<?php echo $natureza?>">
										<input type="hidden" name="tipoacao" value="NaoRemeterExigSuspensa">
										<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
									</form>
								  </td>
								</tr>
							</table>
							<br>
							<h6 align="left" style="font-size:11px; margin-left:10px;">Critérios:</h6>
							   <ul align="left"; id="lista">
								<li>Débitos com Suspensão de Exigibilidade</li>
							   </ul>
							</div>
						 </div>
						 
					</div>
				</div>
				<br>
				<div class="card">
					<div class="card-header" align="center">
						<h5><strong>Débitos Lançados CNPJ da Prefeitura</strong></h4></strong></h5>
					</div>
					<div class="card-body" align="center">
						<div align="center">
							<div class="card" style="width: 21rem; margin-top:20px; margin-left:5%;">
							<div class="card-header" align="center">
								<strong>Débitos Inscritos<br>no CNPJ da Prefeitura </strong>
							</div><br>
							
							<div align="left" style="margin-left:10%;">
								<strong style="font-size:13px">QTD de Sequenciais: </strong><strong style="font-size:13px; color: #F00;"><?php $retornoSelect = somaCountViewCNPJPref($natureza, $pdo); echo $retornoSelect[0][1];?></strong>	
								<br>
								<strong style="font-size:13px">Valor em Aberto:</strong><strong style="font-size:13px; color: #F00;"> R$ <?php $retornoSelect = somaCountViewCNPJPref($natureza, $pdo); echo number_format($retornoSelect[0][0],2,",",".");?></strong>
							</div>
							<hr>
							<table align="center" width="280">
								<tr>
								  <td width="80" align="left">
										<button id="chamarFormulario" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
								  </td>
								  <td width="120" align="center" >
									<form method="post" action="GeracaoCSVRemessa.php">
										<input type="hidden" name="natureza" value="<?php echo $natureza?>">
										<input type="hidden" name="tipoacao" value="CnpjPref">
										<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
									</form>
								  </td>
								</tr>
							</table>
							<br>
							<h6 align="left" style="font-size:11px; margin-left:10px;">Critérios:</h6>
							<ul align="left"; id="lista">
								<li>Débitos lançados no CNPJ da Prefeitura</li>
							</ul>
							</div>  
						 </div>
					</div>
				</div>
				<br>
				
			</div>
		<?php
		}else{
			echo "<script>window.location='TelaEnviarArquivo_v2.php?tipo=Remessa';alert('Carregue uma Base de Acompanhamento DAT através da opção Upload dos Arquivos');</script>" ;
		}
	 ?>


<div id="gerarCIProblemasCadastroCPFCNPJ">
  <p class="validateTips" align="center">Preencher dados para a C.I. - Problemas no CNPJ/CPF</p>
 
  <form action="GeracaoCIProblemasCpfCnpj.php" target="_blank" method="post" enctype="multipart/form-data">
    <fieldset>
      <label for="ci">Nº da C.I.</label>
      <input type="text" name="nCI" id="name" value="" class="form-control">
      <label for="destinatario">Destinatário</label>
      <input type="text" name="destinatario" id="destinatario" value="" class="form-control">
      <label for="text">Cargo do destinatário: </label>
      <input type="text" name="cargo" id="cargo" value="" class="form-control">
      <input type="hidden" name="natureza" value="<?php echo $natureza;?>">
      <hr>
      <input type="submit" class="btn btn-primary btn-lg btn-block" value="Gerar" style="font-size:12px">
    </fieldset>
  </form>
</div>
<div id="gerarCILancadosCNPJPrefeitura">
  <p class="validateTips" align="center">Preencher dados para a C.I. - CNPJ da Prefeitura</p>
  
  <form action="GeracaoCICnpjPrefeitura.php" target="_blank" method="post" enctype="multipart/form-data">
    <fieldset>
      <label for="ci">Nº da C.I.</label>
      <input type="text" name="nCI" id="name" value="" class="form-control">
      <label for="destinatario">Destinatário</label>
      <input type="text" name="destinatario" id="destinatario" value="" class="form-control">
      <label for="text">Cargo do destinatário: </label>
      <input type="text" name="cargo" id="cargo" value="" class="form-control">
      <input type="hidden" name="natureza" value="<?php echo $natureza;?>">
      <hr>
      <input type="submit" class="btn btn-primary btn-lg btn-block" value="Gerar" style="font-size:12px">
    </fieldset>
  </form>
</div>
<div id="gerarCILancamentosRetroativos">
  <p class="validateTips" align="center">Preencher dados para a C.I. - Lançamento retroativo</p>
 
  <form action="GeracaoCILancRetroativos.php" target="_blank" method="post" enctype="multipart/form-data">
    <fieldset>
      <label for="ci">Nº da C.I.</label>
      <input type="text" name="nCI" id="name" value="" class="form-control">
      <label for="destinatario">Destinatário</label>
      <input type="text" name="destinatario" id="destinatario" value="" class="form-control">
      <label for="text">Cargo do destinatário: </label>
      <input type="text" name="cargo" id="cargo" value="" class="form-control">
      <input type="hidden" name="natureza" value="<?php echo $natureza;?>">
      <hr>
      <input type="submit" class="btn btn-primary btn-lg btn-block" value="Gerar" style="font-size:12px">
    </fieldset>
  </form>
</div>
 
<?php desconectar($pdo);?>
</body>
<link rel="stylesheet" href="js/jquery-ui-1.12.1.custom/jquery-ui-1.12.1.custom/jquery-ui.min.css">
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/jquery-ui-1.12.1.custom/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script>
	$(function(){
		$( "#gerarCIProblemasCadastroCPFCNPJ" ).dialog({
		  autoOpen: false,
		  modal: true,
		  height: 400,
		  width: 450,
		  show: {
			effect: "blind",
			duration: 1000
		  },
		  hide: {
			effect: "explode",
			duration: 1000
		  }
		});
		
		$( "#chamarFormulario" ).on( "click", function() { $( "#gerarCIProblemasCadastroCPFCNPJ" ).dialog( "open" ); });

    });	
	$(function(){
		$( "#gerarCILancadosCNPJPrefeitura" ).dialog({
		  autoOpen: false,
		  modal: true,
		  height: 400,
		  width: 450,
		  show: {
			effect: "blind",
			duration: 1000
		  },
		  hide: {
			effect: "explode",
			duration: 1000
		  }
		});
		
		$( "#chamarFormulario2" ).on( "click", function() { $( "#gerarCILancadosCNPJPrefeitura" ).dialog( "open" ); });

    });	
	$(function(){
		$( "#gerarCILancamentosRetroativos" ).dialog({
		  autoOpen: false,
		  modal: true,
		  height: 400,
		  width: 450,
		  show: {
			effect: "blind",
			duration: 1000
		  },
		  hide: {
			effect: "explode",
			duration: 1000
		  }
		});
		
		$( "#chamarFormulario3" ).on( "click", function() { $( "#gerarCILancamentosRetroativos" ).dialog( "open" ); });

    });	
	
</script>

</html>