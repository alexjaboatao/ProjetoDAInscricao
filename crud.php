<?php 
require_once "conexao.php";

function criarTabelaBaseAcompInsc($arquivo, $natureza, $pdo){

	$primeira = "CREATE TABLE BaseAcompanhamento".$natureza."(";
	$cont = count($arquivo)- 1;
	$segunda = "";
	
	for ($i=0;$i<$cont;$i++){
		
		if($i>10){
			
			$segunda = $segunda."`".$arquivo[$i]."` decimal (10,2) NOT NULL,";
			$segunda = $segunda."`Situacao_".$arquivo[$i]."` varchar(255) NOT NULL,";
			$segunda = $segunda."`DataSituacao_".$arquivo[$i]."` datetime NOT NULL,";
			$segunda = $segunda."`CDA_".$arquivo[$i]."` varchar(255) NOT NULL,";
			
		}else{
			
			if($i == 10){
				$segunda = $segunda."`".$arquivo[$i]."` decimal (10,2) NOT NULL,";
			}else{
				$segunda = $segunda."`".$arquivo[$i]."` varchar(255) NOT NULL,";
				
			}
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
	
	for ($i=0;$i<$cont;$i++){
		
		if($i>10){
			
			$segunda = $segunda."`".$arquivo[$i]."` decimal (10,2) NOT NULL,";
			$segunda = $segunda."`Situacao_".$arquivo[$i]."` varchar(255) NOT NULL,";
			$segunda = $segunda."`DataSituacao_".$arquivo[$i]."` datetime NOT NULL,";
			$segunda = $segunda."`CDA_".$arquivo[$i]."` varchar(255) NOT NULL,";
			
		}else{
			
			if($i == 10){
				$segunda = $segunda."`".$arquivo[$i]."` decimal (10,2) NOT NULL,";
			}else{
				$segunda = $segunda."`".$arquivo[$i]."` varchar(255) NOT NULL,";
			}
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
		$incrementacoluna = 0;
		
		for($a=0;$a<$cont;$a++){
			
			$situacao = "";
			
			if($a<=10){ //colunas cabeçalho
				
				$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
				$valores = $valores."'".addslashes($arquivo1[$a])."',";
				$incrementacoluna = $incrementacoluna+1;
				
			}else{ //colunas exercícios
				
				if($arquivo1[$a] == ""){
					
					$valorTurmaTratado  = 0;
					$dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
					$situacao = "";
					$numeroCDA = "";
					
				}else{
					
					$valorSeparado =  explode("-", $arquivo1[$a]);
					$valorTurmaPonto = str_replace(".","", $valorSeparado[0]);
					$valorTurmaTratado = str_replace(",",".", $valorTurmaPonto);
					
					//echo $arquivo1[$a]."||".count($valorSeparado)."<br>";
					
					if(trim($valorSeparado[count($valorSeparado)-1]) == "Com Exigibilidade Suspensa"){	
						$situacao = "Com Exigibilidade Suspensa - ";
						unset($valorSeparado[count($valorSeparado)-1]);
					}
					
					if(count($valorSeparado) == 1){ //APENAS VALOR
						$dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
						$situacao = $situacao."";
						$numeroCDA = "";
					}elseif(count($valorSeparado) == 3){
						
						//echo substr($valorSeparado[2],1,3)."<br>";
						
						if(substr($valorSeparado[1],1,4) == "Parc"){ //APENAS PARCELADOS
							
							$dataSituacao = implode( '-', array_reverse( explode( '/', trim($valorSeparado[2]))));
							$situacao = $situacao.$valorSeparado[1];
							$numeroCDA = "";
							
						}elseif(substr($valorSeparado[2],1,3) == "Lan"){ //APENAS LANÇADOS
							
							$dataSituacao = implode( '-', array_reverse( explode( '/', substr($valorSeparado[2], -10, 10))));
							$situacao = $situacao.$valorSeparado[2]." - ".$valorSeparado[1];
							$numeroCDA = "";
							
						}elseif(substr($valorSeparado[1],1,3) == "CDA"){ //APENAS BAIXADOS
							
							$dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
							$situacao = $situacao."CDA BAIXADA";
							$numeroCDA = str_replace("CDA ","", $valorSeparado[1]);
						}
						
					}elseif(count($valorSeparado) == 5){
						
						if(substr($valorSeparado[1],1,3) == "CDA"){ //CDA BAIXADA E RELANÇADA
							
							$dataSituacao = implode( '-', array_reverse( explode( '/', substr($valorSeparado[4], -10, 10))));
							$situacao = $situacao.$valorSeparado[1]." - ".$valorSeparado[2]." - ".$valorSeparado[3]." - ".$valorSeparado[4];
							$numeroCDA = str_replace("CDA ","", $valorSeparado[1]);
							
						}elseif(substr($valorSeparado[1],1,4) == "Parc"){ //PARCELADO E RELANÇADO
							
							if(strtotime(implode( '-', array_reverse( explode( '/', trim($valorSeparado[2]))))) > strtotime(implode( '-', array_reverse( explode( '/', substr($valorSeparado[4], -10, 10)))))){
								$dataSituacao = implode( '-', array_reverse( explode( '/', trim($valorSeparado[2]))));
								$situacao = $situacao.$valorSeparado[1];
							}else{
								$dataSituacao = implode( '-', array_reverse( explode( '/', substr($valorSeparado[4], -10, 10))));
								$situacao = $situacao."Processo ".$valorSeparado[3]." - ".$valorSeparado[4];
							}
							
							$numeroCDA = "";
							
						}
					}elseif(count($valorSeparado) == 7){ //CDA BAIXADA, PARCELADO E RELANÇADO
						
						if(strtotime(implode( '-', array_reverse( explode( '/', trim($valorSeparado[4]))))) > strtotime(implode( '-', array_reverse( explode( '/', substr($valorSeparado[6], -10, 10)))))){
							$dataSituacao = implode( '-', array_reverse( explode( '/', trim($valorSeparado[4]))));
							$situacao = $situacao.$valorSeparado[1]." - ".$valorSeparado[2]." - ".$valorSeparado[3];
						
						}else{
							$dataSituacao = implode( '-', array_reverse( explode( '/', substr($valorSeparado[6], -10, 10))));
							$situacao = $situacao.$valorSeparado[1]." - ".$valorSeparado[2]." - Processo".$valorSeparado[5]." - ".$valorSeparado[6];
						}
						
						$numeroCDA = str_replace("CDA ","", $valorSeparado[1]);
					}
				}
				
				
				if($a != $cont-1){ //colunas exercícios (SQL)
					
					$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`Situacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`DataSituacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`CDA_".$arraycabecalho[$incrementacoluna]."`,";
					$valores = $valores."'".addslashes($valorTurmaTratado)."',";
					$valores = $valores."'".addslashes($situacao)."',";
					$valores = $valores."'".addslashes($dataSituacao)."',";
					$valores = $valores."'".addslashes($numeroCDA)."',";
					$incrementacoluna = $incrementacoluna+1;
					
				}elseif($a == $cont-1){ //colunas exercícios (SQL)
					
					$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`Situacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`DataSituacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`CDA_".$arraycabecalho[$incrementacoluna]."`";
					$valores = $valores."'".addslashes($valorTurmaTratado)."',";
					$valores = $valores."'".addslashes($situacao)."',";
					$valores = $valores."'".addslashes($dataSituacao)."',";
					$valores = $valores."'".addslashes($numeroCDA)."'";
					$incrementacoluna = $incrementacoluna+1;
					
					
				}	
			}	
		}
		
			$insert = "insert into BaseAcompanhamento$natureza(".utf8_encode("$colunas) values ($valores)");
			$inserir = $pdo->prepare($insert);
			$inserir->execute();
	}
	
	echo "<script>window.location='TelaEnviarArquivo_v2.php?tipo=Inscrição';alert('Dados enviados com sucesso!');</script>" ;
	
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
			
			$situacao = "";
			
			if($a<=10){ //colunas cabeçalho
				
				$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
				$valores = $valores."'".addslashes($arquivo1[$a])."',";
				$incrementacoluna = $incrementacoluna+1;
				
			}else{ //colunas exercícios
				
				if($arquivo1[$a] == ""){
					
					$valorTurmaTratado  = 0;
					$dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
					$situacao = "";
					$numeroCDA = "";
					
				}else{
					
					$valorSeparado =  explode("-", $arquivo1[$a]);
					$valorTurmaPonto = str_replace(".","", $valorSeparado[0]);
					$valorTurmaTratado = str_replace(",",".", $valorTurmaPonto);
					
					//echo $arquivo1[$a]."||".count($valorSeparado)."<br>";
					
					if(trim($valorSeparado[count($valorSeparado)-1]) == "Com Exigibilidade Suspensa"){	
						$situacao = "Com Exigibilidade Suspensa - ";
						unset($valorSeparado[count($valorSeparado)-1]);
					}
					
					if(count($valorSeparado) == 2){ //APENAS VALOR
						$dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
						$situacao = $situacao."";
						$numeroCDA = str_replace("CDA ","", $valorSeparado[1]);
					}elseif(count($valorSeparado) == 4){
						
						//echo substr($valorSeparado[2],1,3)."<br>";
						
						if(substr($valorSeparado[2],1,4) == "Parc"){ //APENAS PARCELADOS
							
							$dataSituacao = implode( '-', array_reverse( explode( '/', trim($valorSeparado[3]))));
							$situacao = $situacao.$valorSeparado[2];
							$numeroCDA = str_replace("CDA ","", $valorSeparado[1]);
							
						}elseif(substr($valorSeparado[3],1,3) == "Lan"){ //APENAS LANÇADOS
							
							$dataSituacao = implode( '-', array_reverse( explode( '/', substr($valorSeparado[3], -10, 10))));
							$situacao = $situacao.$valorSeparado[3]." - Processo ".$valorSeparado[2];
							$numeroCDA = str_replace("CDA ","", $valorSeparado[1]);
							
						}
						
					}elseif(count($valorSeparado) == 6){
						
						if(substr($valorSeparado[2],1,4) == "Parc"){ //PARCELADO E RELANÇADO
							
							if(strtotime(implode( '-', array_reverse( explode( '/', trim($valorSeparado[3]))))) > strtotime(implode( '-', array_reverse( explode( '/', substr($valorSeparado[5], -10, 10)))))){
								$dataSituacao = implode( '-', array_reverse( explode( '/', trim($valorSeparado[3]))));
							}else{
								$dataSituacao = implode( '-', array_reverse( explode( '/', substr($valorSeparado[5], -10, 10))));
							}
							$situacao = $situacao.$valorSeparado[2]." - ".$valorSeparado[3]." - Processo ".$valorSeparado[4]." - ".$valorSeparado[5];
							$numeroCDA = str_replace("CDA ","", $valorSeparado[1]);
							
						}
						
					}
				}
				
				if($a != $cont-1){ //colunas exercícios (SQL)
					
					$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`Situacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`DataSituacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`CDA_".$arraycabecalho[$incrementacoluna]."`,";
					$valores = $valores."'".addslashes($valorTurmaTratado)."',";
					$valores = $valores."'".addslashes($situacao)."',";
					$valores = $valores."'".addslashes($dataSituacao)."',";
					$valores = $valores."'".addslashes($numeroCDA)."',";
					$incrementacoluna = $incrementacoluna+1;
					
				}elseif($a == $cont-1){ //colunas exercícios (SQL)
					
					$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`Situacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`DataSituacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`CDA_".$arraycabecalho[$incrementacoluna]."`";
					$valores = $valores."'".addslashes($valorTurmaTratado)."',";
					$valores = $valores."'".addslashes($situacao)."',";
					$valores = $valores."'".addslashes($dataSituacao)."',";
					$valores = $valores."'".addslashes($numeroCDA)."'";
					$incrementacoluna = $incrementacoluna+1;
					
					
				}	
			}	
		}
		
			$insert = "insert into BaseAcompanhamento".$natureza."DAT(".utf8_encode("$colunas) values ($valores)");
			$inserir = $pdo->prepare($insert);
			$inserir->execute();
	}
	echo "<script>window.location='TelaEnviarArquivo_v2.php?tipo=Remessa';alert('Dados enviados com sucesso!');</script>" ;
	
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