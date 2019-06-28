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
		areaDesparc.select();
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
         <h5><strong>Relação de Sequencial/CMC para Inscrição em Dívida Ativa<h4 style="color: #C00"><strong><?php echo $natureza; ?></strong></h4></strong></h5>
       </div>
           <div class="card-body">
        <?php if($tipo == "S"){ $relacaoInscrever = anosInscrever($ex,$natureza,$pdo);  ?>
              
                <div class="card">
                      <div class="card-header" align="center" >
                        <h5><strong>Relação sem interrupção prescricional</strong> <button class="btn btn-primary" onClick="primeira('copy')" id="copiar">Copy</button></h5>
                        </div>
                        	<textarea id="area" class="form-control">
								<?php 
								if(!empty($relacaoInscrever)){
                                    foreach ($relacaoInscrever as $relacao){
                                        echo $relacao[0].";";
                                    }
								}
                                ?>
                      		</textarea>
            </div>
            
            <?php } else if($tipo == "P") { $relacaoInscreverParc = anosDesparcelados($ex,$natureza,$pdo); ?>
            
                <div class="card" >
                      <div class="card-header" align="center">
                        <h5><strong>Relação Desparcelados</strong> <button class="btn btn-primary" onClick="segunda('copy')" id="copiarDesparc">Copy</button></h5>
                        </div>
                        	<textarea id="areaDesparc" class="form-control">
								<?php 
                                    foreach ($relacaoInscreverParc as $relacaoParc){
                                        echo $relacaoParc[0].";";
                                    }
                                ?>
                        	</textarea>
                </div>
            <?php }?>
        </div>
     </div>
</div>
</body>
</html>