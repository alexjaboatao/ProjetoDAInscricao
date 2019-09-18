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
require_once "selecionarDadosInscricao.php";
$pdo = conectar();
$tratarInscricao = $_GET['DA'];
$tipo = substr($tratarInscricao, 0, 3);
$ex = substr($tratarInscricao, 3, 4);
$natureza = substr($tratarInscricao, 7);

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
			<?php if($tipo == "AI4"){ $relacaoResultado = selectViewAnaliseInscricaoCPFBrancoApenasNome($exercicio, $natureza, $pdo);  ?>
              
				<div class="card">
					<div class="card-header" align="center" >
						<h5><strong>Análise Para Inscrição<br> CPF/CNPJ em branco + Apenas 1 Nome</strong> <button class="btn btn-primary" onClick="primeira('copy')" id="copiar">Copy</button></h5>
					</div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="area" class="form-control"><?php if(!empty($relacaoResultado)){foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="area" class="form-control"><?php if(!empty($relacaoResultado)){foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
					
				</div>
            
            <?php } elseif($tipo == "AI5") { $relacaoResultado = selectViewAnaliseInscricaoCPFInvalidoApenasNome($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Análise Para Inscrição<br> CPF/CNPJ Inválido + Apenas 1 Nome</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
			
			<?php } elseif($tipo == "AI6") { $relacaoResultado = selectViewAnaliseInscricaoCPFValidoApenasNome($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Análise Para Inscrição<br> CPF/CNPJ Válido + Apenas 1 Nome</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
			
			<?php } elseif($tipo == "AI7") { $relacaoResultado = selectViewAnaliseInscricaoCPFBrancoNomeSobrenome($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Análise Para Inscrição<br> CPF/CNPJ em branco + Nome e Sobrenome</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
				
                </div>
			
			<?php } elseif($tipo == "AI8") { $relacaoResultado = selectViewAnaliseInscricaoCPFInvalidoNomeSobrenome($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Análise Para Inscrição<br> CPF/CNPJ Inválido + Nome e Sobrenome</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
            
			
			<?php } elseif($tipo == "AI9") { $relacaoResultado = selectViewAnaliseInscricaoCDAsBaixadas($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Análise Para Inscrição<br> CDA's Baixadas</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
				
                </div>
			
			<?php } elseif($tipo == "CC1") { $relacaoResultado = selectViewCadastroCompletoSemInterrupcao($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Inscrição<br>Débitos sem Interrupção Prescricional</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
			
			<?php } elseif($tipo == "CC2") { $relacaoResultado = selectViewCadastroCompletoDesparcelado($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Inscrição<br>Débitos Desparcelados</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
			
			<?php } elseif($tipo == "CC3") { $relacaoResultado = selectViewCadastroCompletoRelancado($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Inscrição<br>Débitos Relançados</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
			
			<?php } elseif($tipo == "P14") { $relacaoResultado = selectViewCNPJPrefeituraNaoPrescritosAcimaInfimo($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Débitos Lançados CNPJ Prefeitura<br>Débitos Prescritos Acima do Valor Ínfimo</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
				
			<?php } elseif($tipo == "P15") { $relacaoResultado = selectViewCNPJPrefeituraNaoPrescritosValorInfimo($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Débitos Lançados CNPJ Prefeitura<br>Débitos Não Prescritos Abaixo do Ínfimo</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
				
			<?php } elseif($tipo == "P16") { $relacaoResultado = selectViewCNPJPrefeituraPrescritos($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Débitos Lançados CNPJ Prefeitura<br>Débitos Prescritos</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
				
			<?php } elseif($tipo == "P17") { $relacaoResultado = selectViewCNPJPrefeituraExigSuspensa($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Débitos Lançados CNPJ Prefeitura<br>Débitos com Exigibilidade Suspensa</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>

			<?php } elseif($tipo == "ES1") { $relacaoResultado = selectViewAnaliseNaoInscricaoExigSuspensa($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Débitos Lançados CNPJ Prefeitura<br>Débitos com Exigibilidade Suspensa</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
				
			<?php } elseif($tipo == "NI1") { $relacaoResultado = selectViewAnaliseNaoInscricaoCPFBrancoApenasNomeValorInfimo($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Débitos Abaixo do Valor Ínfimo<br>CPF/CNPJ Branco + Apenas 1 Nome</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
				
			<?php } elseif($tipo == "NI2") { $relacaoResultado = selectViewAnaliseNaoInscricaoCPFInvalidoApenasNomeValorInfimo($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Débitos Abaixo do Valor Ínfimo<br>CPF/CNPJ Inválido + Apenas 1 Nome</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
				
			<?php } elseif($tipo == "NI3") { $relacaoResultado = selectViewAnaliseNaoInscricaoCPFValidoApenasNomeValorInfimo($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Débitos Abaixo do Valor Ínfimo<br>CPF/CNPJ Válido + Apenas 1 Nome</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
				
			<?php } elseif($tipo == "NI4") { $relacaoResultado = selectViewAnaliseNaoInscricaoCPFValidoNomeSobrenomeValorInfimo($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Débitos Abaixo do Valor Ínfimo<br>CPF/CNPJ Válido + Nome e Sobrenome</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
				
			<?php } elseif($tipo == "NI5") { $relacaoResultado = selectViewAnaliseNaoInscricaoCPFBrancoNomeSobrenomeValorInfimo($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Débitos Abaixo do Valor Ínfimo<br>CPF/CNPJ Branco + Nome e Sobrenome</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
				
			<?php } elseif($tipo == "NI6") { $relacaoResultado = selectViewAnaliseNaoInscricaoCPFInvalidoNomeSobrenomeValorInfimo($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Débitos Abaixo do Valor Ínfimo<br>CPF/CNPJ Inválido + Nome e Sobrenome</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
				
			<?php } elseif($tipo == "NI7") { $relacaoResultado = selectViewAnaliseNaoInscricaoAtividadeEncerradaPrescrito($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>CMC em atividade encerrada com débitos<br>Débitos Prescritos</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
				
			<?php } elseif($tipo == "NI8") { $relacaoResultado = selectViewAnaliseNaoInscricaoAtividadeEncerradaNaoPrescrito($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>CMC em atividade encerrada com débitos<br>Débitos Não Prescritos</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
				
			<?php } elseif($tipo == "NI9") { $relacaoResultado = selectViewAnaliseNaoInscricaoDemaisCNPJPrescritosComCDA($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Débitos Passíveis de Prescrição<br>Com Histórico de CDA</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
				
			<?php } elseif($tipo == "N10") { $relacaoResultado = selectViewAnaliseNaoInscricaoDemaisCNPJPrescritosSemCDA($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                    <div class="card-header" align="center">
                        <h5><strong>Débitos Passíveis de Prescrição<br>Sem Histórico de CDA</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                    </div>
					
					<?php if($natureza == "Imobiliária"){ ?>
		
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[1].";";}}?></textarea>
					
					<?php } else if($natureza == "Mercantil"){ ?>
					
						<textarea id="areaDesparc" class="form-control"><?php if(!empty($relacaoResultado)){ foreach ($relacaoResultado as $relacao){echo $relacao[0].";";}}?></textarea>
					
					 <?php }?>
					
                </div>
			
			<?php }?>
			
        </div>
     </div>
</div>
</body>
</html>