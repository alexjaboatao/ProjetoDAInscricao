<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Sistema de Análise da Dívida Ativa</title>
</head>

<body>

		<?php 
		require_once "conexao.php";
		require_once "crud.php";

		$nomearquivo = $_FILES["arquivo"]["tmp_name"];	
		$tipo = $_POST["tipo"];
		
		
		if (!empty($nomearquivo)){
			
			$localizacao = substr($_FILES["arquivo"]["name"], strlen($_FILES["arquivo"]["name"])-7,3);
			$objeto = fopen ($nomearquivo, 'r');		
			$arquivo = fgetcsv($objeto, 0, ";");
			$natureza = utf8_encode(substr ($arquivo[0], 9, 11));
			$pdo = conectar();
				
			if($localizacao == "EAN" && $tipo == "Inscrição"){
				
				carregarTabelaInscricao($natureza, $pdo, $arquivo, $objeto);
				
			} elseif($localizacao == "DAT" && $tipo == "Remessa"){
				
				carregarTabelaRemessa($natureza, $pdo, $arquivo, $objeto);
				
			} else {
				
				if($tipo == "Inscrição"){
					
					echo "<script>window.location='TelaEnviarArquivo_v2.php?tipo=Inscrição';alert('Selecione o arquivo Base de Acompanhamento EAN');</script>" ;
						
				}elseif($tipo == "Remessa"){
					
					echo "<script>window.location='TelaEnviarArquivo_v2.php?tipo=Remessa';alert('Selecione o arquivo Base de Acompanhamento DAT');</script>" ;
				}
				
			}
			
			desconectar($pdo);
			fclose($objeto);			

		}else{
			echo "<script>window.location='TelaEnviarArquivo_v2.php';alert('Não foi enviado arquivo!');</script>" ;
		}
		
		function carregarTabelaInscricao($natureza, $pdo, $arquivo, $objeto){
			
			deletarTabelaBaseAcompInsc($natureza, $pdo);
			criarTabelaBaseAcompInsc($arquivo, $natureza, $pdo);
			incluirDadosBaseAcompInsc($arquivo, $natureza, $objeto, $pdo);
			
		}
		
		function carregarTabelaRemessa($natureza, $pdo, $arquivo, $objeto){
			
			deletarTabelaBaseAcompRemessa($natureza, $pdo);
			criarTabelaBaseAcompRemessa($arquivo, $natureza, $pdo);
			incluirDadosBaseAcompRemessa($arquivo, $natureza, $objeto, $pdo);
		
			
		}

        ?>
</body>
</html>