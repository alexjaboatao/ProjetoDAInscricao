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
		
			if (!empty($nomearquivo)){
				
				$objeto = fopen ($nomearquivo, 'r');
			
				$arquivo = fgetcsv($objeto, 0, ";");
				
				$natureza = utf8_encode(substr ($arquivo[0], 9, 11));

				$pdo = conectar();
				
				deletarTabelaBaseAcomp($natureza, $pdo);
				criarTabelaBaseAcomp($arquivo, $natureza, $pdo);
			    incluirDadosBaseAcomp($arquivo, $natureza, $objeto, $pdo);
				
				desconectar($pdo);
				
				fclose($objeto);

			} else {
				echo "<script>window.location='TelaEnviarArquivo.php';alert('Não foi enviado arquivo!');</script>" ;
			}
        ?>
</body>
</html>