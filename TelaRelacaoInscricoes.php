<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Sistema de Análise da Dívida ativa</title>
</head>
<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
<script src="bootstrap-4.3.1-dist/js/bootstrap.js"></script>
<script>
	function primeira(value){
		var area = document.getElementById('area');
		area.select();
		if (value == 'copy'){
			
			document.execCommand('copy')
			}
		}
	function segunda(value){
		var areaDesparc = document.getElementById('areaDesparc');
		areaDesparc.select()
		if (value == 'copy'){
			document.execCommand('copy')
			}
		}
</script>
<body>
<?php
require_once "menu.php";
require_once "conexao.php";
require_once "selecionarDados.php";
$pdo = conectar();
$tratarInscricao = $_GET['DA'];
$tipo = substr($tratarInscricao, 0, 1);
$ex = substr($tratarInscricao, 1, 4);
$natureza = substr($tratarInscricao, 5);

?>

<div class="container">
    <div class="card">
       <div class="card-header" align="center">
	   
		<?php if($natureza == "Imobiliária"){ ?>
		
			<h5><strong>Relação de Sequenciais para Inscrição em Dívida Ativa<h4 style="color: #C00"><strong><?php echo $natureza; ?></strong></h4></strong></h5>
		
		<?php } else if($natureza == "Mercantil"){ ?>
		
			<h5><strong>Relação de Inscrições Mercantis para Inscrição em Dívida Ativa<h4 style="color: #C00"><strong><?php echo $natureza; ?></strong></h4></strong></h5>
		
		 <?php }?>
		
       </div>
           <div class="card-body">
			<?php if($tipo == "S"){ $relacaoInscrever = anosInscrever($ex,$natureza,$pdo);  ?>
              
				<div class="card">
					<div class="card-header" align="center" >
						<h5><strong>Relação sem interrupção prescricional</strong> <button class="btn btn-primary" onClick="primeira('copy')" id="copiar">Copy</button></h5>
					</div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="area" class="form-control"><?php if(!empty($relacaoInscrever)){foreach ($relacaoInscrever as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="area" class="form-control"><?php if(!empty($relacaoInscrever)){foreach ($relacaoInscrever as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
					
				</div>
            
            <?php } else if($tipo == "P") { $relacaoInscreverParc = anosDesparcelados($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Relação Desparcelados</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoInscreverParc)){ foreach ($relacaoInscreverParc as $relacaoParc){echo $relacaoParc[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoInscreverParc)){ foreach ($relacaoInscreverParc as $relacaoParc){echo $relacaoParc[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
			
			<?php } else if($tipo == "C") { $relacaoProblemasCadastroCPFCNPJ = retornarProblemasCadastroCPFCNPJ($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Relação Débitos com Problemas Cadastrais no CPF/CNPJ</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoProblemasCadastroCPFCNPJ)){ foreach ($relacaoProblemasCadastroCPFCNPJ as $inscricaoProblemaCadastro){echo $inscricaoProblemaCadastro[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoProblemasCadastroCPFCNPJ)){ foreach ($relacaoProblemasCadastroCPFCNPJ as $inscricaoProblemaCadastro){echo $inscricaoProblemaCadastro[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
			
			<?php } else if($tipo == "L") { $relacaoDebitosLancadosCNPJPrefeitura = retornarDebitosLancadosCNPJPrefeitura($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Relação Débitos Lançados no CNPJ da Prefeitura</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoDebitosLancadosCNPJPrefeitura)){ foreach ($relacaoDebitosLancadosCNPJPrefeitura as $inscricaoLancPrefeitura){echo $inscricaoLancPrefeitura[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoDebitosLancadosCNPJPrefeitura)){ foreach ($relacaoDebitosLancadosCNPJPrefeitura as $inscricaoLancPrefeitura){echo $inscricaoLancPrefeitura[0].";";}}?></textarea>
					
					 <?php }?>
				
                </div>
			
			<?php } else if($tipo == "R") { $relacaoDebitosLancadosRetroativamente = retornarLancamentosRetroativos($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Relação Débitos Lançados Retroativamente</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoDebitosLancadosRetroativamente)){ foreach ($relacaoDebitosLancadosRetroativamente as $inscricaoLancRetroativo){echo $inscricaoLancRetroativo[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoDebitosLancadosRetroativamente)){ foreach ($relacaoDebitosLancadosRetroativamente as $inscricaoLancRetroativo){echo $inscricaoLancRetroativo[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
            <?php }?>
        </div>
     </div>
</div>
</body>
</html>