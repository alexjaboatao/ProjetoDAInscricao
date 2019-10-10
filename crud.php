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


function criarTabelaAutoConf($arquivo, $natureza, $pdo){
	
	$sql = utf8_encode("CREATE OR REPLACE TABLE base".$natureza." (
			`$arquivo[0]` VARCHAR(255),
			`$arquivo[1]` DATE,
			`$arquivo[2]` VARCHAR(255),
			`$arquivo[3]` DATE,
			`$arquivo[4]` VARCHAR(255),
			`$arquivo[5]` VARCHAR(255),
			`$arquivo[6]` VARCHAR(255),
			`$arquivo[7]` VARCHAR(255),
			`$arquivo[8]` DATE,
			`$arquivo[9]` VARCHAR(255),
			`$arquivo[10]` DATE,
			`$arquivo[11]` VARCHAR(255),
			`$arquivo[12]` DOUBLE,
			`$arquivo[13]` VARCHAR(255),
			`$arquivo[14]` VARCHAR(255),
			`$arquivo[15]` VARCHAR(255),
			`$arquivo[16]` VARCHAR(255),
			`$arquivo[17]` INT,
			`$arquivo[18]` DOUBLE,
			`$arquivo[19]` DOUBLE,
			`$arquivo[20]` DOUBLE,
			`$arquivo[21]` DOUBLE,
			`$arquivo[22]` VARCHAR(255),
			`$arquivo[23]` VARCHAR(255),
			`$arquivo[24]` VARCHAR(255),
			`$arquivo[25]` VARCHAR(255),
			`$arquivo[26]` VARCHAR(255),
			`$arquivo[27]` VARCHAR(255),
			`$arquivo[28]` VARCHAR(255),
			`$arquivo[29]` VARCHAR(255),
			qtdAnosInscricao INT,
			anoUltimoParcTratado INT,
			analisePrescricao VARCHAR(255) 
			)");
			
			$criarTabela = $pdo->prepare($sql);
			$criarTabela->execute();
			
}

function incluirDadosAutoConfRemessa ($arquivo, $natureza, $objeto, $pdo){
	
	$cont = count($arquivo);
	$colunas = "";
	for($i=0; $i< $cont; $i++){
		$arquivoTratado = "`".$arquivo[$i]."`,";
		  $colunas = $colunas.$arquivoTratado;

	}

	while(($arquivo1=fgetcsv($objeto, 0, ";"))!== false){
		
		$dataCertidao = implode( '-', array_reverse( explode( '/', $arquivo1[1])));
		$dataJudicial = implode( '-', array_reverse( explode( '/', $arquivo1[3])));
		$dataSituacao = implode( '-', array_reverse( explode( '/', $arquivo1[8])));
		$dataBaixa = implode( '-', array_reverse( explode( '/', $arquivo1[10])));
		$valorBaixa = str_replace(",",".", str_replace(".","", $arquivo1[12]));
		$valorTotalAtual = str_replace(",",".", str_replace(".","", $arquivo1[18]));
		$valorPricipal = str_replace(",",".", str_replace(".","", $arquivo1[19]));
		$valorMulta = str_replace(",",".", str_replace(".","", $arquivo1[20]));
		$valorJuros = str_replace(",",".", str_replace(".","", $arquivo1[21]));
		$dataNegativacao = implode( '-', array_reverse( explode( '/', $arquivo1[29] )));
		
		// Saber qual foi o ano do último parcelamento
		
		echo $anoUltimoParc = substr(trim($arquivo1[27]), -3, -1)."<br>";
		
		if ($arquivo1[27] == ""){
			$anoUltimoParcTratado = 0;
		} elseif($anoUltimoParc > 50 && $arquivo1[27] != ""){
			$anoUltimoParcTratado = "19".$anoUltimoParc;
		}else{
			$anoUltimoParcTratado = "20".$anoUltimoParc;
		}
		
		// Quantidade de anos que foi criado a CDA?
		
		$data = $arquivo1[1];								
		$datatratada1 = explode("/",$data);
		$data1 = ($datatratada1[2]."-".$datatratada1[1]."-".$datatratada1[0]);
		$data2 = date("Y-m-d");
		$dif = strtotime($data2) - strtotime($data1);
		$qtdAnosInscricao = floor(($dif / 86400)/365);

		// Analisar a Prescrição e quais os Auto/ Not/ Conf podem ser remetidos à Procuradoria/////////////////////////////			
		
		if (($qtdAnosInscricao >= 5 && $anoUltimoParcTratado == 0 && $arquivo1[6] == "Secretaria" && $arquivo1[7] == "Em Aberto") or 
			($qtdAnosInscricao >= 5 && $anoUltimoParcTratado < 2015 && $arquivo1[6] == "Secretaria" && $arquivo1[7] == "Em Aberto")){
			$analisar = "Prescrito";
		} elseif ($arquivo1[6] == "Secretaria" && $arquivo1[7] != "Em Aberto") {
			$analisar = "Quitada, Parcelada ou Exigibilidade suspensa";
		} elseif ($arquivo1[6] == "Procuradoria"){
			$analisar = "Procuradoria";
		} elseif ($arquivo1[6] == "Judicial"){
			$analisar = "Judicial";
		} else {
			$analisar = "Analisar remessa";
		}
		
		
		$valores = "";
		$row = count($arquivo1);
		for($a=0; $a<$row;$a++){
			$valores = $valores."'".$arquivo1[$a]."',";
		}
		
		$insert = utf8_encode("insert into base".$natureza." ($colunas"."`qtdAnosInscricao`,"."`anoUltimoParcTratado`,"."`analisePrescricao`) values ('$arquivo1[0]','$dataCertidao','$arquivo1[2]','$arquivo1[3]','$arquivo1[4]','$arquivo1[5]','$arquivo1[6]','$arquivo1[7]','$dataJudicial','$arquivo1[9]','$dataBaixa','$arquivo1[11]','$valorBaixa','$arquivo1[13]','$arquivo1[14]','".addslashes($arquivo1[15])."','$arquivo1[16]','$arquivo1[17]','$valorTotalAtual','$valorPricipal','$valorMulta','$valorJuros','$arquivo1[22]','$arquivo1[23]','$arquivo1[24]','$arquivo1[25]','$arquivo1[26]','$arquivo1[27]','$arquivo1[28]','$dataNegativacao','$qtdAnosInscricao','$anoUltimoParcTratado','$analisar')");
				
		$inserir = $pdo->prepare($insert);
		$inserir->execute();
		
		}
	}

/*function criarTabelaAutoConf($arquivo, $natureza, $pdo){
	
	$primeira = "CREATE TABLE CertDiv".$natureza."(";
	$cont = count($arquivo)- 1;
	$segunda = "";
	
	for ($i=0;$i<$cont;$i++){
		
		if($i == 0){
			if($arquivo[$i] == "ValorTotalAtual" or $arquivo[$i] == "ValorPrincipal" or $arquivo[$i] == "Multa" or $arquivo[$i] == "Juros" or $arquivo[$i] == "ValorBaixa"){
				
				
			}elseif($arquivo[$i] == "Data Certidão" or $arquivo[$i] == "Data Situação" or $arquivo[$i] == "Data Baixa"){
				
				
			}elseif($arquivo[$i] == "Histórico Parcelamento"){
				
				
			}else{
				
				
			}
			
		}else{
			
		}
		
	}
}*/
	
?>