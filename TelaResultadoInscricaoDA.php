<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Sistema de Análise da Dívida ativa</title>
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
	<script src="bootstrap-4.3.1-dist/js/bootstrap.js"></script>
	
	<script lang="javascript" src="js/jquery-3.4.1.min.js"></script>
	<script lang="javascript" src="js/xlsx.full.min.js"></script>
	<script lang="javascript" src="js/FileSaver.min.js"></script>

</head>
<body>

	<?php 
		require_once "menu.php";
		require_once "conexao.php";
		require_once "selecionarDados.php";
		//include 'PHPExcel\Classes\PHPExcel.php';

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
       <h6 align="left" style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Não foram considerados os débitos dos cadastros sem identificação do sujeito passivo.</h6>
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
       <h6 align="left" style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Não foram considerados os débitos dos cadastros sem identificação do sujeito passivo.</h6>
                  </div>
             </div>
        </div>
        </div>
<br>
		<div class="card" style="m">
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
										<button id="chamarFormulario" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
                                  </td>
                                  <td width="120" align="center" >
									<button id="gerarCSVProblemaCPFCNPJ" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
									
									<script>
		
										var wb = XLSX.utils.book_new();
										
										wb.Props = {
											Title: "SheetJS Tutorial",
											Subject: "Test file",
											Author: "Red Stapler",
											CreatedDate: new Date(2019,07,31)
										};
										
										wb.SheetsNames.push("Test Sheet");
										var ws_data = [['hello' , 'world']];  //a row with 2 columns
										var ws = XLSX.utils.aoa_to_sheet(ws_data);
										wb.Sheets["Test Sheet"] = ws;
										
										var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
										
										function s2ab(s) { 
											var buf = new ArrayBuffer(s.length); //convert s to arrayBuffer
											var view = new Uint8Array(buf);  //create uint8array as viewer
											for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF; //convert to octet
											return buf;    
										}
										
										$('#gerarCSVProblemaCPFCNPJ').click(function(){
										   saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), 'test.xlsx');
										});
									
									</script>
									
									<?php 
									
										/*$objPHPExcel = new PHPExcel();
										
										for ($i=0; $i< 5; $i++){
										   $tabelaProblemasCpfCnpj = retornarProblemasCadastroCPFCNPJ($array5ultimosAnos[$i], $natureza, $pdo);
										   
											
										     if($natureza == "Imobiliária"){
												 
												 $objWorkSheet = $objPHPExcel->createSheet($i);
												//criando cabeçalho
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('A1', 'InscriçãoImobiliária');
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('B1', 'Sequencial');
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('C1', 'CpfCnpjProprietário');
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('D1', 'NomeProprietário');
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('E1', 'Natureza');
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('F1', 'EndereçoImóvel');
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('G1', 'Regional');
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('H1', $array5ultimosAnos[$i]);
												
												foreach($tabelaProblemasCpfCnpj as $linha){  
													$l=2;
													for($c=0; $c<8; $c++){
														$objPHPExcel->setActiveSheetIndex($i)->setCellValue('A'.$l, $linha[$c]);
														$l++;
														//echo $linha[$c];
													 }
												}
											 }elseif($natureza == "Mercantil"){
												
												$objWorkSheet = $objPHPExcel->createSheet($i);
												//criando cabeçalho
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('A1', 'InscriçãoMercantil');
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('B1', 'CpfCnpj');
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('C1', 'RazãoSocial');
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('D1', 'Endereço');
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('E1', 'Situação');
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('F1', 'TipoPessoa');
												$objPHPExcel->setActiveSheetIndex($i)->setCellValue('G1', $array5ultimosAnos[$i]);
												
												foreach($tabelaProblemasCpfCnpj as $linha){  
													$l=2;
													for($c=0; $c<7; $c++){
														$objPHPExcel->setActiveSheetIndex($i)->setCellValue('A'.$l, $linha[$c]);
														$l++;
														//echo $linha[$c];
													 }
												}
											 }
										   }
										   
										   //formata o cabeçalho
											header('Content-Type: application/vnd.ms-excel');
											header('Content-Disposition: attachment;filename="lista.xls"');
											header('Cache-Control: max-age=50000');
											
											$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
											$objWriter->save('php://output');*/
									?>
									
                                  </td>
                                </tr>
                            </table>
                       <br>
       <h6 align="left" style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Estão considerados débitos com CPF/CNPJ em branco, inválidos ou fora do padrão.</h6>
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
								<button type="submit" id="chamarFormulario2" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
							  </td>
							  <td width="120" align="center" >
								<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
							  </td>
							</tr>
						</table>
						<br>
						<h6 align="left" style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Lançamentos de débitos no CNPJ 10.377.679/0001-96.</h6>
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
								<button type="submit" id="chamarFormulario3" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
							  </td>
							  <td width="120" align="center" >
								<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
							  </td>
							</tr>
						</table>
						<br>
						<h6 align="left" style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Lançamentos retroativos de débitos que necessitam de confirmação sobre a notificação para inscrição em D.A..</h6>
				</div>
             </div>
        </div>
        </div>
</div>
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