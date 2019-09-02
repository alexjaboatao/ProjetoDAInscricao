<?php 
require_once "conexao.php";

function criarTabelaBaseAcompInsc($arquivo, $natureza, $pdo){
	$primeira = "CREATE TABLE BaseAcompanhamento".$natureza."(";
	$cont = count($arquivo)- 1;

	$segunda = "";
		for ($i=0;$i<$cont;$i++){
			
			if($natureza == "Imobiliária"){
				
				$segunda = $segunda."`".$arquivo[$i]."` varchar(255) NOT NULL,";	

			}elseif($natureza == "Mercantil"){
				$segunda = $segunda."`".$arquivo[$i]."` varchar(255) NOT NULL,";	
				}			
		}

		$segunda = $segunda." PRIMARY KEY ($arquivo[0])";
		$consulta = $primeira.utf8_encode($segunda).")";
		$criarTabela = $pdo->prepare($consulta);
		$criarTabela->execute();
	   echo "<script>alert('Tabela criada com sucesso!');</script>" ;
	}
	

function criarTabelaBaseAcompRemessa($arquivo, $natureza, $pdo){
	$primeira = "CREATE TABLE BaseAcompanhamento".$natureza."DAT(";
	$cont = count($arquivo)- 1;

	$segunda = "";
	$maisclounas = 0;
	for ($i=0;$i<$cont;$i++){
		
		if($i>10){
			
			$segunda = $segunda."`".$arquivo[$i]."` decimal (10,2) NOT NULL,";
			$segunda = $segunda."`Situacao_".$arquivo[$i]."` varchar(255) NOT NULL,";
			$segunda = $segunda."`DataSituacao_".$arquivo[$i]."` datetime NOT NULL,";
			$segunda = $segunda."`CDA_".$arquivo[$i]."` varchar(255) NOT NULL,";
			
		}else{
			
			$segunda = $segunda."`".$arquivo[$i]."` varchar(255) NOT NULL,";
		}
						
	}

	$segunda = $segunda." PRIMARY KEY ($arquivo[0])";
	$consulta = $primeira.utf8_encode($segunda).")";
	$criarTabela = $pdo->prepare($consulta);
	$criarTabela->execute();
    echo "<script>alert('Tabela criada com sucesso!');</script>" ;
}

	
function incluirDadosBaseAcompInsc($arquivo, $natureza, $objeto, $pdo){

	$cont = count($arquivo);
	$arraycabecalho = array();
	
	for ($i2=0;$i2<$cont;$i2++){
		$arraycabecalho[$i2] = $arquivo[$i2];
	}
	
	while(($arquivo1=fgetcsv($objeto, 0, ";"))!== false){
		
		$cont = count($arquivo1);
		$colunas = "";
		$valores = "";
		
		for($a=0;$a<$cont;$a++){
			
			if($a!= $cont-1){
				$colunas = $colunas."`".$arraycabecalho[$a]."`,";
				$valores = $valores."'".addslashes($arquivo1[$a])."',";					
				
			}else{
				$colunas = $colunas."`".$arraycabecalho[$a]."`";
				$valores = $valores."'".addslashes($arquivo1[$a])."'";
			}
		}
		
			$insert = "insert into BaseAcompanhamento$natureza(".utf8_encode("$colunas) values ($valores)");
			$inserir = $pdo->prepare($insert);
			$inserir->execute();
	}
	echo "<script>window.location='TelaEnviarArquivo.php?tipo=Inscrição';alert('Dados enviados com sucesso!');</script>" ;
}


function incluirDadosBaseAcompRemessa($arquivo, $natureza, $objeto, $pdo){

	$cont = count($arquivo);
	$arraycabecalho = array();
	
	for ($i2=0;$i2<$cont;$i2++){
		$arraycabecalho[$i2] = $arquivo[$i2];
	}
	
	
	while(($arquivo1=fgetcsv($objeto, 0, ";"))!== false){
		
		$cont = count($arquivo1);
		$colunas = "";
		$valores = "";
		$incrementacoluna = 0;
		
		for($a=0;$a<$cont;$a++){
			
			if($natureza=="Imobiliária"){
				
				if($a == $cont-1){
					
					$valorSeparado =  explode("-", $arquivo1[$a]);
					$valorTurmaPonto = str_replace(".","", $valorSeparado[0]);
					$valorTurmaTratado = str_replace(",",".", $valorTurmaPonto);
					
					if (count($valorSeparado)>2) { 
					    $dataSituacaoBarra = substr($arquivo1[$a], strlen($arquivo1[$a])-10, 10);
					    $dataSituacao = implode( '-', array_reverse( explode( '/', "$dataSituacaoBarra" ))); 
					  
					    if(strpos($arquivo1[$a], "Lan") === false){ //desparcelados
							
							$situacao = $valorSeparado[2];
							
						}else{
							
							if(count($valorSeparado) == 4){ //relançados
								
								$situacao = $valorSeparado[3]." - ".$valorSeparado[2];
								
							}elseif(count($valorSeparado) == 6){ //relançados e desparcelados
								
								$situacao = $valorSeparado[2]." - ".$valorSeparado[5]." - ".$valorSeparado[3];
								
								if(strtotime($dataSituacao) < strtotime(implode( '-', array_reverse( explode( '/', trim($valorSeparado[3])))))){
									$dataSituacao = implode( '-', array_reverse( explode( '/', trim($valorSeparado[3]))));
								}
							}
						}
					  
					  $numeroCDA = str_replace("CDA ","",$valorSeparado[1]);
					  
					}elseif(count($valorSeparado) == 2){
						$dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
						$situacao = "";
						$numeroCDA = str_replace("CDA ","",$valorSeparado[1]);
						
					}else {
					  $dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
					  $situacao = "";
					  $numeroCDA = "";
					}
					
					$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`Situacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`DataSituacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`CDA_".$arraycabecalho[$incrementacoluna]."`";
					$valores = $valores."'".addslashes($valorTurmaTratado)."',";
					$valores = $valores."'".addslashes($situacao)."',";
					$valores = $valores."'".addslashes($dataSituacao)."',";
					$valores = $valores."'".addslashes($numeroCDA)."'";
					$incrementacoluna = $incrementacoluna+1;
					
				}elseif($a>10){
					
					$valorSeparado =  explode("-", $arquivo1[$a]);
					$valorTurmaPonto = str_replace(".","", $valorSeparado[0]);
					$valorTurmaTratado = str_replace(",",".", $valorTurmaPonto);
					
					if (count($valorSeparado)>2) { 
						$dataSituacaoBarra = substr($arquivo1[$a], strlen($arquivo1[$a])-10, 10);
						$dataSituacao = implode( '-', array_reverse( explode( '/', "$dataSituacaoBarra" )));
						
						if(strpos($arquivo1[$a], "Lan") === false){
							
							$situacao = $valorSeparado[2];
							
						}else{
							
							if(count($valorSeparado) == 4){
								
								$situacao = $valorSeparado[3]." - ".$valorSeparado[2];

							}elseif(count($valorSeparado) == 6){
								
								$situacao = $valorSeparado[5]." - ".$valorSeparado[3];
								
								if(strtotime($dataSituacao) < strtotime(implode( '-', array_reverse( explode( '/', trim($valorSeparado[3])))))){
									$dataSituacao = implode( '-', array_reverse( explode( '/', trim($valorSeparado[3]))));
								}
							}
						}
					  
					  $numeroCDA = str_replace("CDA ","",$valorSeparado[1]);
					  
					}elseif(count($valorSeparado) == 2){
						$numeroCDA = str_replace("CDA ","",$valorSeparado[1]);
						$dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
						$situacao = "";
					} else {
					  $dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
					  $situacao = "";
					  $numeroCDA = "";
					}
					
					$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`Situacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`DataSituacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`CDA_".$arraycabecalho[$incrementacoluna]."`,";
					$valores = $valores."'".addslashes($valorTurmaTratado)."',";
					$valores = $valores."'".addslashes($situacao)."',";
					$valores = $valores."'".addslashes($dataSituacao)."',";
					$valores = $valores."'".addslashes($numeroCDA)."',";
					$incrementacoluna = $incrementacoluna+1;
				}else{
					$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
					$valores = $valores."'".addslashes($arquivo1[$a])."',";
					$incrementacoluna = $incrementacoluna+1;
				}
				
			}elseif($natureza=="Mercantil"){
				
				if($a == $cont-1){
					$valorSeparado =  explode("-", $arquivo1[$a]);
					$valorTurmaPonto = str_replace(".","", $valorSeparado[0]);
					$valorTurmaTratado = str_replace(",",".", $valorTurmaPonto);
					
					if (count($valorSeparado)>2) {
					  $dataSituacaoBarra = substr($arquivo1[$a], strlen($arquivo1[$a])-10, 10);
					  $dataSituacao = implode( '-', array_reverse( explode( '/', "$dataSituacaoBarra" )));
					  $situacao = $valorSeparado[2];
					  $numeroCDA = str_replace("CDA ","",$valorSeparado[1]);
					  
					}elseif(count($valorSeparado) == 2){
						$numeroCDA = str_replace("CDA ","",$valorSeparado[1]);
						$dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
						$situacao = "";
					} else {
					  $dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
					  $situacao = "";
					  $numeroCDA = "";
					}
					
					$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`Situacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`DataSituacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`CDA_".$arraycabecalho[$incrementacoluna]."`";
					$valores = $valores."'".addslashes($valorTurmaTratado)."',";
					$valores = $valores."'".addslashes($situacao)."',";
					$valores = $valores."'".addslashes($dataSituacao)."',";
					$valores = $valores."'".addslashes($numeroCDA)."'";
					$incrementacoluna = $incrementacoluna+1;
					
				}elseif($a>10){
					$valorSeparado = explode("-", $arquivo1[$a]);
					$valorTurmaPonto = str_replace(".","", $valorSeparado[0]);
					$valorTurmaTratado = str_replace(",",".", $valorTurmaPonto);
					
					if (count($valorSeparado)>2) {
					  $dataSituacaoBarra = substr($arquivo1[$a], strlen($arquivo1[$a])-10, 10);
					  $dataSituacao = implode( '-', array_reverse( explode( '/', "$dataSituacaoBarra" )));
					  $situacao = $valorSeparado[2];
					  $numeroCDA = str_replace("CDA ","",$valorSeparado[1]);
					  
					}elseif(count($valorSeparado) == 2){
						$numeroCDA = str_replace("CDA ","",$valorSeparado[1]);
						$dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
						$situacao = "";
						
					} else {
					  $dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
					  $situacao = "";
					  $numeroCDA = "";
					}
					
					$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`Situacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`DataSituacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`CDA_".$arraycabecalho[$incrementacoluna]."`,";
					$valores = $valores."'".addslashes($valorTurmaTratado)."',";
					$valores = $valores."'".addslashes($situacao)."',";
					$valores = $valores."'".addslashes($dataSituacao)."',";
					$valores = $valores."'".addslashes($numeroCDA)."',";
					$incrementacoluna = $incrementacoluna+1;
					
				}else{
					$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
					$valores = $valores."'".addslashes($arquivo1[$a])."',";
					$incrementacoluna = $incrementacoluna+1;
				}
			}
				
		}
		
			$insert = "insert into BaseAcompanhamento".$natureza."DAT(".utf8_encode("$colunas) values ($valores)");
			$inserir = $pdo->prepare($insert);
			$inserir->execute();
	}
	echo "<script>window.location='TelaEnviarArquivo.php?tipo=Remessa';alert('Dados enviados com sucesso!');</script>" ;
}


function deletarTabelaBaseAcompInsc($natureza, $pdo){

	$deletarTabela = "drop table BaseAcompanhamento$natureza";
	$deletarTabela = $pdo->prepare($deletarTabela);
	$deletarTabela->execute();
	echo "<script>alert('Tabela excluída!');</script>";
	
}


function deletarTabelaBaseAcompRemessa($natureza, $pdo){

	$deletarTabela = "drop table BaseAcompanhamento".$natureza."DAT";
	$deletarTabela = $pdo->prepare($deletarTabela);
	$deletarTabela->execute();
	echo "<script>alert('Tabela excluída!');</script>";
	
}
	
?>