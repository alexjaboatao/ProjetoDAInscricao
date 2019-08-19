<?php 
require_once "conexao.php";

verificaPrescrição("2016-12-15");


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
		
		if($natureza == "Imobiliária"){
			
			if($i>10){
				
				$segunda = $segunda."`".$arquivo[$i]."` double NOT NULL,";
				$segunda = $segunda."`Situacao_".$arquivo[$i]."` varchar(255) NOT NULL,";
				$segunda = $segunda."`DataSituacao_".$arquivo[$i]."` datetime NOT NULL,";
				
			}else{
				
				$segunda = $segunda."`".$arquivo[$i]."` varchar(255) NOT NULL,";
			}
				

		}elseif($natureza == "Mercantil"){
			
			if($i>6){
				
				$segunda = $segunda."`".$arquivo[$i]."` double NOT NULL,";
				$segunda = $segunda."`Situacao_".$arquivo[$i]."` varchar(255) NOT NULL,";
				$segunda = $segunda."`DataSituacao_".$arquivo[$i]."` datetime NOT NULL,";
				
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
					
					if (count($valorSeparado)>1) {
					  $dataSituacaoBarra = substr($arquivo1[$a], strlen($arquivo1[$a])-10, 10);
					  $dataSituacao = implode( '-', array_reverse( explode( '/', "$dataSituacaoBarra" ))); 

					  $situacao = $valorSeparado[1];
					  
					} else {
					  $dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
					  $situacao = "";
					}
					
					$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`Situacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`DataSituacao_".$arraycabecalho[$incrementacoluna]."`";
					$valores = $valores."'".addslashes($valorTurmaTratado)."',";
					$valores = $valores."'".addslashes($situacao)."',";
					$valores = $valores."'".addslashes($dataSituacao)."'";
					$incrementacoluna = $incrementacoluna+1;
					
				}elseif($a>10){
					
					$valorSeparado =  explode("-", $arquivo1[$a]);
					$valorTurmaPonto = str_replace(".","", $valorSeparado[0]);
					$valorTurmaTratado = str_replace(",",".", $valorTurmaPonto);
					
					if (count($valorSeparado)>1) {
					  $dataSituacaoBarra = substr($arquivo1[$a], strlen($arquivo1[$a])-10, 10);
					  $dataSituacao = implode( '-', array_reverse( explode( '/', "$dataSituacaoBarra" )));
					  
					  $situacao = $valorSeparado[1];
					  
					} else {
					  $dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
					  $situacao = "";
					}
					
					$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`Situacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`DataSituacao_".$arraycabecalho[$incrementacoluna]."`,";
					$valores = $valores."'".addslashes($valorTurmaTratado)."',";
					$valores = $valores."'".addslashes($situacao)."',";
					$valores = $valores."'".addslashes($dataSituacao)."',";
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
					
					if (count($valorSeparado)>1) {
					  $dataSituacaoBarra = substr($arquivo1[$a], strlen($arquivo1[$a])-10, 10);
					  $dataSituacao = implode( '-', array_reverse( explode( '/', "$dataSituacaoBarra" )));
					  
					  $situacao = $valorSeparado[1];
					  
					} else {
					  $dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
					  $situacao = "";
					}
					
					$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`Situacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`DataSituacao_".$arraycabecalho[$incrementacoluna]."`";
					$valores = $valores."'".addslashes($valorTurmaTratado)."',";
					$valores = $valores."'".addslashes($situacao)."',";
					$valores = $valores."'".addslashes($dataSituacao)."'";
					$incrementacoluna = $incrementacoluna+1;
					
				}elseif($a>6){
					
					$valorSeparado =  explode("-", $arquivo1[$a]);
					$valorTurmaPonto = str_replace(".","", $valorSeparado[0]);
					$valorTurmaTratado = str_replace(",",".", $valorTurmaPonto);
					
					if (count($valorSeparado)>1) {
					  $dataSituacaoBarra = substr($arquivo1[$a], strlen($arquivo1[$a])-10, 10);
					  $dataSituacao = implode( '-', array_reverse( explode( '/', "$dataSituacaoBarra" )));
					  
					  $situacao = $valorSeparado[1];
					  
					} else {
					  $dataSituacao = $arraycabecalho[$incrementacoluna]."-02-10";
					  $situacao = "";
					}
					
					$colunas = $colunas."`".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`Situacao_".$arraycabecalho[$incrementacoluna]."`,";
					$colunas = $colunas."`DataSituacao_".$arraycabecalho[$incrementacoluna]."`,";
					$valores = $valores."'".addslashes($valorTurmaTratado)."',";
					$valores = $valores."'".addslashes($situacao)."',";
					$valores = $valores."'".addslashes($dataSituacao)."',";
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

function verificaPrescrição($data){
	
	///echo $dataInicio = date_create($data);
	echo $dateFim = date('d-m-Y');
	//echo $diff=date_diff($dataInicio,$dataInicio);
	//echo $diff->format("%a");
	
	/*if($diff >= 5){
		return true;
	}else{
		return false;
	}*/
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