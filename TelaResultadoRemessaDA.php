<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Sistema de Análise da Dívida ativa</title>
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
	<script src="bootstrap-4.3.1-dist/js/bootstrap.js"></script>
	
	<script lang="javascript" src="js/jquery-3.4.1.min.js"></script>

</head>
<body>

	<?php 
		require_once "menu.php";
		require_once "conexao.php";
		require_once "selecionarDados.php";

		$pdo = conectar();
		$natureza = $_POST["natureza"];
		$buscarExercicio = buscarExercicio($pdo,$natureza);
		$qtdColuna = count($buscarExercicio);
		$anos5 = $qtdColuna;
		
		$exercicios = $_POST['matrizExercicios'];
		$exercicios = substr($exercicios, 0,strlen($exercicios)-1);
		$arrayExercicios = explode(",",$exercicios);
		
		$select = retornaAnosRemessa($natureza, $arrayExercicios, $pdo);
		criarViews($select, $natureza, $pdo);
		
	 ?>

 <div class="container">
  	<div class="card">
    	<div class="card-header" align="center">
            <h5><strong>Débitos para Remeter à Procuradoria <h4 style="color: #C00"><strong>Dívida Ativa <?php echo $natureza; ?></strong></h4></strong></h5>
        </div>
        <div class="card-body float-left" align="center">
        	 <div class="card" style="width: 21rem; margin-top:20px; margin-left:5%;">
                  <div class="card-header" align="center">
                    <strong>Débitos tratados para a remessa</strong>
                  </div>
                  <br>
                            <table align="center">
								<tr width="80" style="font-size:12px">
                                  <td>
									<strong>QTD de Sequenciais: <?php $retornoSelect = selectCountAnosRemessa($natureza, $pdo); echo $retornoSelect[0][0];?></strong>
                                  </td>
                                </tr>
                                <tr width="80" style="font-size:12px">
                                  <td>
									<strong>Valor Total da Remessa:<?php ?></strong>
                                  </td>
                                </tr>
                                <tr width="120" align="center">
                                  <td>
                                        <form method="post" action="GeracaoCSV.php">
											<input type="hidden" name="natureza" value="<?php echo $natureza?>">
											<input type="hidden" name="matrizExercicios" value="<?php for($i=11; $i<$qtdColuna; $i++){echo $buscarExercicio[$i][0].",";}?>">
											<input type="hidden" name="tipoacao" value="anosRemessa">
											<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar Remessa </button>
                                        </form>
                                   </td>
                                </tr>
                            </table>
                       <br>
       <h6 align="left" style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Estão considerados débitos com CPF/CNPJ em branco, inválidos ou fora do padrão.</h6>
                </div>  
             </div>
        </div>
<br>
		<div class="card">
    	<div class="card-header" align="center">
            <h5><strong>Débitos com Problemas na Remessa</strong></h4></strong></h5>
        </div>
        <div class="card-body float-left" align="center">
      		<div class="float-left">
                <div class="card" style="width: 21rem; margin-top:20px; margin-left:5%;">
                  <div class="card-header" align="center">
                    <strong>Débitos Passíveis de Prescrição</strong>
                  </div><br>
                            <table align="center" width="280">
                                <tr width="80" style="font-size:12px">
                                  <td>
									<strong>QTD de Sequenciais:<?php ?>	</strong>
                                  </td>
                                </tr>
                                <tr width="80" style="font-size:12px">
                                  <td>
									<strong>Valor em Aberto:<?php ?></strong>
                                  </td>
                                </tr>
								<tr>
                                  <td width="80" align="left">
										<button id="chamarFormulario" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Gerar CI</button>
                                  </td>
                                  <td width="120" align="center" >
									<button id="gerarCSVProblemaCPFCNPJ" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Relatório CSV</button>
									
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
                    <strong>Débitos com Problemas de Cadastro</strong>
                  </div><br>
						<table align="center" width="280">
							<tr width="80" style="font-size:12px">
                                  <td>
									<strong>QTD de Sequenciais:<?php ?>	</strong>
                                  </td>
                                </tr>
                                <tr width="80" style="font-size:12px">
                                  <td>
									<strong>Valor em Aberto:<?php ?></strong>
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
                    <strong>Débitos com Exigibilidade Suspensa</strong>
                  </div><br>
						<table align="center" width="280">
							<tr width="80" style="font-size:12px">
                                  <td>
									<strong>QTD de Sequenciais:<?php ?>	</strong>
                                  </td>
                                </tr>
                                <tr width="80" style="font-size:12px">
                                  <td>
									<strong>Valor em Aberto:<?php ?></strong>
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