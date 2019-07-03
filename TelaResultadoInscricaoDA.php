﻿<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Sistema de Análise da Dívida ativa</title>
</head>
<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
<script src="bootstrap-4.3.1-dist/js/bootstrap.js"></script>
<body>
<?php 
require_once "menu.php";
require_once "conexao.php";
require_once "selecionarDados.php";
require_once "GeracaoCI.php";
	$pdo = conectar();
	$natureza = $_POST["natureza"];
	$bucarExercicio = buscarExercicio($pdo,$natureza);
	$qtdColuna = count($bucarExercicio);
	$anos5 = $qtdColuna - 5;
	$array5ultimosAnos = array(
	$ex1 = substr(implode($bucarExercicio[$anos5]), 0, 4),
	$ex2 = substr(implode($bucarExercicio[$anos5 + 1]), 0, 4),
	$ex3 = substr(implode($bucarExercicio[$anos5 + 2]), 0, 4),
	$ex4 = substr(implode($bucarExercicio[$anos5 + 3]), 0, 4),
	$ex5 = substr(implode($bucarExercicio[$anos5 + 4]), 0, 4));
	
 ?>
 <div class="container">
  	<div class="card">
    	<div class="card-header" align="center">
            <h5><strong>Débitos Para Inscrição em Dívida Ativa <h4 style="color: #C00"><strong><?php echo $natureza; ?></strong></h4></strong></h5>
        </div>
        <div class="card-body float-left" align="center">
      		<div class="float-left">
                <div class="card" style="width: 21rem; margin-top:20px; margin-left:40%;">
                  <div class="card-header" align="center">
                    <strong>Débitos sem interrupção Prescricional</strong>
                  </div>
                            <table align="center">
                                <tr>
                                  <td width="50" align="left">
                                    <strong>
                                  	<?php 
                                            for ($i=0; $i< 5; $i++){
                                                echo $array5ultimosAnos[$i].":<br>";
                                            }
                                        ?>
                                     </strong>
                                  </td>
                                  <td width="50" align="center" >
                                          <?php 
                                                for ($i=0; $i< 5; $i++){
                                                   $qtdDebitosInscricao = count(anosInscrever($array5ultimosAnos[$i], $natureza, $pdo));
												   echo '<a href="TelaRelacaoInscricoes.php?DA=S'.$array5ultimosAnos[$i].$natureza.' ">'.$qtdDebitosInscricao.'<br></a>';
                                                }
                                            ?>
                                  </td>
                                </tr>
                            </table>
                       <br>
       <h6 style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Não foram considerados os débitos dos cadastros sem identificação do sujeito passivo.</h6>
                </div>  
             </div>
             <div class="float-left">
                <div class="card" style="width: 21rem; margin-top:20px; margin-left:70%; ">
                  <div class="card-header" align="center">
                    <strong>Débitos Desparcelados</strong>
                  </div>
                            <table align="center">
                                <tr>
                                  <td width="50" align="left">
                                    <strong>
                                  	<?php 
                                            for ($i=0; $i< 5; $i++){
                                                echo $array5ultimosAnos[$i].":<br>";
                                            }
                                        ?>
                                     </strong>
                                  </td>
                                  <td width="50" align="center" >
                                          <?php 
												
											   for ($i=0; $i< 5; $i++){
                                                   $inscreverDesparcelado = count(anosDesparcelados($array5ultimosAnos[$i], $natureza, $pdo));
                                                   echo '<a href="TelaRelacaoInscricoes.php?DA=P'.$array5ultimosAnos[$i].$natureza.' ">'.$inscreverDesparcelado.'<br></a>';
                                                }
                                            ?>
                                  </td>
                                </tr>
                            </table>
                             <br>
       <h6 style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Não foram considerados os débitos dos cadastros sem identificação do sujeito passivo.</h6>
                  </div>
             </div>
        </div>
        </div>
		
		<div class="card">
    	<div class="card-header" align="center">
            <h5><strong>Débitos Não Inscritos em Dívida Ativa <h4 style="color: #C00"><strong><?php echo $natureza; ?></strong></h4></strong></h5>
        </div>
        <div class="card-body float-left" align="center">
      		<div class="float-left">
                <div class="card" style="width: 21rem; margin-top:20px; margin-left:5%;">
                  <div class="card-header" align="center">
                    <strong>Débitos com Problemas Cadastrais no CPF/CNPJ</strong>
                  </div>
                            <table align="center">
                                <tr>
                                  <td width="50" align="left">
                                    <strong>
                                  	<?php 
                                            for ($i=0; $i< 5; $i++){
                                                echo $array5ultimosAnos[$i].":<br>";
                                            }
                                        ?>
                                     </strong>
                                  </td>
                                  <td width="50" align="center" >
                                          <?php 
                                                for ($i=0; $i<5; $i++){
                                                   
												   $qtdDebitosProblemaCPFCNPJ = count(retornarProblemasCadastroCPFCNPJ($array5ultimosAnos[$i], $natureza, $pdo));
												   echo '<a href="TelaRelacaoInscricoes.php?DA=C'.$array5ultimosAnos[$i].$natureza.' ">'.$qtdDebitosProblemaCPFCNPJ.'<br></a>';
                                                }
                                            ?>
                                  </td>
                                </tr>
								<tr>
                                  <td width="80" align="left">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
                                  </td>
                                  <td width="120" align="center" >
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
                                  </td>
                                </tr>
                            </table>
                       <br>
       <h6 style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Estão considerados débitos com CPF/CNPJ em branco, inválidos ou fora do padrão.</h6>
                </div>  
             </div>
             <div class="float-left">
                <div class="card" style="width: 21rem; margin-top:20px; margin-left:10%; ">
                  <div class="card-header" align="center">
                    <strong>Débitos Lançados no CNPJ da Prefeitura </strong>
                  </div>
						<table align="center">
							<tr>
							  <td width="50" align="left">
								<strong>
								<?php 
										for ($i=0; $i< 5; $i++){
											echo $array5ultimosAnos[$i].":<br>";
										}
									?>
								 </strong>
							  </td>
							  <td width="50" align="center" >
									  <?php 
											
										  for ($i=0; $i< 5; $i++){
											   $qtdDebitosLancadosCNPJPrefeitura = count(retornarDebitosLancadosCNPJPrefeitura($array5ultimosAnos[$i], $natureza, $pdo));
											   echo '<a href="TelaRelacaoInscricoes.php?DA=L'.$array5ultimosAnos[$i].$natureza.' ">'.$qtdDebitosLancadosCNPJPrefeitura.'<br></a>';
											}
										?>
							  </td>
							</tr>
							<tr>
							  <td width="80" align="left">
								<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
							  </td>
							  <td width="120" align="center" >
								<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
							  </td>
							</tr>
						</table>
						<br>
						<h6 style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Lançamentos de débitos no CNPJ 10.377.679/0001-96.</h6>
				</div>
             </div>
			 <div class="float-left">
                <div class="card" style="width: 21rem; margin-top:20px; margin-left:15%; ">
                  <div class="card-header" align="center">
                    <strong>Débitos Lançados <br/> Retroativamente </strong>
                  </div>
						<table align="center">
							<tr>
							  <td width="50" align="left">
								<strong>
								<?php 
										for ($i=0; $i< 5; $i++){
											echo $array5ultimosAnos[$i].":<br>";
										}
									?>
								 </strong>
							  </td>
							  <td width="50" align="center" >
									  <?php 
											
										  for ($i=0; $i< 5; $i++){
											   $qtdLacadosRetroativos = count(retornarLancamentosRetroativos($array5ultimosAnos[$i], $natureza, $pdo));
											   echo '<a href="TelaRelacaoInscricoes.php?DA=R'.$array5ultimosAnos[$i].$natureza.' ">'.$qtdLacadosRetroativos.'<br></a>';
											}
										?>
							  </td>
							</tr>
							<tr>
							  <td width="80" align="left">
								<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
							  </td>
							  <td width="120" align="center" >
								<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
							  </td>
							</tr>
						</table>
						<br>
						<h6 style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Lançamentos de débitos no CNPJ 10.377.679/0001-96.</h6>
				</div>
             </div>
        </div>
        </div>
</div>
  
         
<?php desconectar($pdo);?>
</body>
</html>