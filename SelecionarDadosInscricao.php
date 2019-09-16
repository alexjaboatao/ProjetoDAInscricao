<?php

function buscarExercicios($pdo, $natureza){


	$sql = "show COLUMNS FROM baseacompanhamento$natureza";
	$buscar = $pdo->prepare($sql);
	$buscar->execute();

	$todascolunas = $buscar->fetchAll(PDO::FETCH_NUM);
	
	$qtdColunas = count($todascolunas);
	$arrayCabecalho = array();
	
	for($i=11; $i<$qtdColunas; $i=$i+4){

		array_push($arrayCabecalho,$todascolunas[$i][0]);
	}
	
	return $arrayCabecalho;
}

function selectGerarViewInscricao($natureza, $arrayexercicios){
	
	$sqlSomatorio = "(";
	
	$numerocolunas = count($arrayexercicios);
				
	for($i=0; $i<$numerocolunas; $i=$i+4){
		
		if($i<count($arrayexercicios)-4){
			$sqlSomatorio = $sqlSomatorio."CASE WHEN (TIMESTAMPDIFF(YEAR , ean.`".$arrayexercicios[$i+2]."`, CURRENT_DATE()) >= 5 
			AND ean.`".$arrayexercicios[$i]."` <> 0 AND ean.`".$arrayexercicios[$i+1]."` NOT LIKE '%Exigib%') 
			THEN ean.`".$arrayexercicios[$i]."` ELSE 0 END + ";
			
			
		}else{
			
			$sqlSomatorio = $sqlSomatorio."CASE WHEN (TIMESTAMPDIFF(YEAR , ean.`".$arrayexercicios[$i+2]."`, CURRENT_DATE()) >= 5 
			AND ean.`".$arrayexercicios[$i]."` <> 0 AND ean.`".$arrayexercicios[$i+1]."` NOT LIKE '%Exigib%') 
			THEN ean.`".$arrayexercicios[$i]."` ELSE 0 END) ";
			
		}
	}
	
	$sql1ifSoma = $sqlSomatorio." AS SOMA_PRESCRITA_EAN, ";
	$sql2ifSoma = str_replace('>= 5','< 5', $sqlSomatorio)." AS SOMA_NAOPRESCRITA_EAN ";
	
	if ($natureza == "Imobiliária"){
		
		$sqlInicio = "SELECT *, (LENGTH(ean.`NomeProprietário`)-LENGTH(replace(ean.`NomeProprietário`,' ',''))+1) AS QTD_NOMES,";
		
		$sqlfim = " FROM
			`baseacompanhamento$natureza` AS ean;";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlInicio = "SELECT *, (LENGTH(ean.`RazãoSocial`)-LENGTH(replace(ean.`RazãoSocial`,' ',''))+1) AS QTD_NOMES,";
		
		$sqlfim = " FROM
			`baseacompanhamento$natureza` AS ean;";
	
	}
	
	return $sql = $sqlInicio." ".$sql1ifSoma." ".$sql2ifSoma." ".$sqlfim;
	
}

function criarViewInscricao($select, $natureza, $pdo){
	
	if($natureza == "Mercantil"){
		$criarview = "CREATE OR REPLACE VIEW view_cadastroCompleto_MercEAN AS ".$select;
	}elseif($natureza == "Imobiliária"){
		$criarview = "CREATE OR REPLACE VIEW view_cadastroCompleto_ImobEAN AS ".$select;
	}
	
	$view = $pdo->query($criarview);
	$view->execute();
}

function selectViewCadastroCompletoSemInterrupcao($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT viewCC.`Sequencial` FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND 
			viewCC.Situacao_".$exercicio." LIKE '' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15 AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			(
			`CpfCnpjProprietário` != '' 
			AND `CpfCnpjProprietário` NOT LIKE '999.999.999-99' 
			AND `CpfCnpjProprietário` NOT LIKE '000.000.000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '00.000.000/0000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '99.999.999/9999-99' 
			AND (length(`CpfCnpjProprietário`)>=14 AND length(`CpfCnpjProprietário`)<=18) 
			AND `CpfCnpjProprietário` NOT LIKE '10.377.679/0001-96'
			);";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT viewCC.`InscriçãoMercantil` FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND 
			viewCC.Situacao_".$exercicio." LIKE '' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15  AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			`Situação` NOT LIKE 'ATV ENCERRADA'
			AND 
			(
			CpfCnpj != '' 
			AND CpfCnpj NOT LIKE '999.999.999-99' 
			AND CpfCnpj NOT LIKE '000.000.000-00' 
			AND CpfCnpj NOT LIKE '00.000.000/0000-00' 
			AND CpfCnpj NOT LIKE '99.999.999/9999-99' 
			AND (length(CpfCnpj)>=14 AND length(CpfCnpj)<=18) 
			AND CpfCnpj NOT LIKE '10.377.679/0001-96'
			);";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}


function selectViewCadastroCompletoDesparcelado($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT viewCC.`Sequencial` FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND 
			viewCC.Situacao_".$exercicio." LIKE '%Parcelamento%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND   
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15 AND 
			(
			`CpfCnpjProprietário` != '' 
			AND `CpfCnpjProprietário` NOT LIKE '999.999.999-99' 
			AND `CpfCnpjProprietário` NOT LIKE '000.000.000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '00.000.000/0000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '99.999.999/9999-99' 
			AND (length(`CpfCnpjProprietário`)>=14 AND length(`CpfCnpjProprietário`)<=18) 
			AND `CpfCnpjProprietário` NOT LIKE '10.377.679/0001-96'
			);";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT viewCC.`InscriçãoMercantil` FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND 
			viewCC.Situacao_".$exercicio." LIKE '%Parcelamento%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15 AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			`Situação` NOT LIKE 'ATV ENCERRADA'
			AND 
			(
			CpfCnpj != '' 
			AND CpfCnpj NOT LIKE '999.999.999-99' 
			AND CpfCnpj NOT LIKE '000.000.000-00' 
			AND CpfCnpj NOT LIKE '00.000.000/0000-00' 
			AND CpfCnpj NOT LIKE '99.999.999/9999-99' 
			AND (length(CpfCnpj)>=14 AND length(CpfCnpj)<=18) 
			AND CpfCnpj NOT LIKE '10.377.679/0001-96'
			);";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}


function selectViewCadastroCompletoRelancado($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT viewCC.`Sequencial` FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND 
			viewCC.Situacao_".$exercicio." LIKE '%Lançado%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15 AND   
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			(
			`CpfCnpjProprietário` != '' 
			AND `CpfCnpjProprietário` NOT LIKE '999.999.999-99' 
			AND `CpfCnpjProprietário` NOT LIKE '000.000.000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '00.000.000/0000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '99.999.999/9999-99' 
			AND (length(`CpfCnpjProprietário`)>=14 AND length(`CpfCnpjProprietário`)<=18) 
			AND `CpfCnpjProprietário` NOT LIKE '10.377.679/0001-96'
			);";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT viewCC.`InscriçãoMercantil` FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND 
			viewCC.Situacao_".$exercicio." LIKE '%Lançado%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15  AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND
			`Situação` NOT LIKE 'ATV ENCERRADA' AND 
			(
			CpfCnpj != '' 
			AND CpfCnpj NOT LIKE '999.999.999-99' 
			AND CpfCnpj NOT LIKE '000.000.000-00' 
			AND CpfCnpj NOT LIKE '00.000.000/0000-00' 
			AND CpfCnpj NOT LIKE '99.999.999/9999-99' 
			AND (length(CpfCnpj)>=14 AND length(CpfCnpj)<=18) 
			AND CpfCnpj NOT LIKE '10.377.679/0001-96'
			);";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}


function selectViewAnaliseInscricaoCPFBrancoNomeSobrenome($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15 AND 
			`CpfCnpjProprietário` LIKE '' AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5;";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15 AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			`Situação` NOT LIKE 'ATV ENCERRADA' AND 
			CpfCnpj LIKE '';";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}


function selectViewAnaliseInscricaoCPFInvalidoNomeSobrenome($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND   
			`CpfCnpjProprietário` NOT LIKE '' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15 AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			(
			`CpfCnpjProprietário` LIKE '999.999.999-99' OR 
			`CpfCnpjProprietário` LIKE '000.000.000-00' OR 
			`CpfCnpjProprietário` LIKE '00.000.000/0000-00' OR 
			`CpfCnpjProprietário` LIKE '99.999.999/9999-99' OR 
			length(`CpfCnpjProprietário`)<14 OR 
			length(`CpfCnpjProprietário`)>18);";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			`Situação` NOT LIKE 'ATV ENCERRADA' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15  AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			`CpfCnpj` NOT LIKE '' AND
			(
			`CpfCnpj` LIKE '999.999.999-99' OR 
			`CpfCnpj` LIKE '000.000.000-00' OR 
			`CpfCnpj` LIKE '00.000.000/0000-00' OR 
			`CpfCnpj` LIKE '99.999.999/9999-99' OR 
			length(`CpfCnpj`)<14 OR 
			length(`CpfCnpj`)>18);";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}


function selectViewAnaliseInscricaoCPFBrancoApenasNome($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES < 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			`CpfCnpjProprietário` LIKE '' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15 AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5;";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES < 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			`Situação` NOT LIKE 'ATV ENCERRADA' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15 
			AND CpfCnpj LIKE '' AND TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND;";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}


function selectViewAnaliseInscricaoCPFInvalidoApenasNome($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES < 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15  AND 
			`CpfCnpjProprietário` NOT LIKE '' AND 
			(
			`CpfCnpjProprietário` LIKE '999.999.999-99' OR 
			`CpfCnpjProprietário` LIKE '000.000.000-00' OR 
			`CpfCnpjProprietário` LIKE '00.000.000/0000-00' OR 
			`CpfCnpjProprietário` LIKE '99.999.999/9999-99' OR 
			length(`CpfCnpjProprietário`)<14 OR 
			length(`CpfCnpjProprietário`)>18);";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES < 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15 AND 
			`Situação` NOT LIKE 'ATV ENCERRADA' AND 
			`CpfCnpj` NOT LIKE '' AND 
			(
			`CpfCnpj` LIKE '999.999.999-99' OR 
			`CpfCnpj` LIKE '000.000.000-00' OR 
			`CpfCnpj` LIKE '00.000.000/0000-00' OR 
			`CpfCnpj` LIKE '99.999.999/9999-99' OR 
			length(`CpfCnpj`)<14 OR 
			length(`CpfCnpj`)>18);";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}


function selectViewAnaliseInscricaoCPFValidoApenasNome($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES < 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND  
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15  AND 
			(
			`CpfCnpjProprietário` != '' 
			AND `CpfCnpjProprietário` NOT LIKE '999.999.999-99' 
			AND `CpfCnpjProprietário` NOT LIKE '000.000.000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '00.000.000/0000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '99.999.999/9999-99' 
			AND (length(`CpfCnpjProprietário`)>=14 AND length(`CpfCnpjProprietário`)<=18) 
			AND `CpfCnpjProprietário` NOT LIKE '10.377.679/0001-96'
			);";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES < 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 
			AND viewCC.SOMA_NAOPRESCRITA_EAN > 75.15 
			AND `Situação` NOT LIKE 'ATV ENCERRADA'
			AND 
			(
			CpfCnpj != '' 
			AND CpfCnpj NOT LIKE '999.999.999-99' 
			AND CpfCnpj NOT LIKE '000.000.000-00' 
			AND CpfCnpj NOT LIKE '00.000.000/0000-00' 
			AND CpfCnpj NOT LIKE '99.999.999/9999-99' 
			AND (length(CpfCnpj)>=14 AND length(CpfCnpj)<=18) 
			AND CpfCnpj NOT LIKE '10.377.679/0001-96'
			);";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}


function selectViewAnaliseInscricaoCDAsBaixadas($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.Situacao_".$exercicio." LIKE '%CDA%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND  
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15
			AND `CpfCnpjProprietário` LIKE '10.377.679/0001-96';";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.Situacao_".$exercicio." LIKE '%CDA%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15 AND 
			`Situação` NOT LIKE 'ATV ENCERRADA' AND 
			CpfCnpj LIKE '10.377.679/0001-96';";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}


function selectViewCNPJPrefeituraNaoPrescritosAcimaInfimo($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15 AND  
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			`CpfCnpjProprietário` LIKE '10.377.679/0001-96';";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND
			viewCC.SOMA_NAOPRESCRITA_EAN > 75.15 AND
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			`Situação` NOT LIKE 'ATV ENCERRADA'
			AND CpfCnpj LIKE '10.377.679/0001-96';";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}


function selectViewCNPJPrefeituraNaoPrescritosValorInfimo($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND
			viewCC.SOMA_NAOPRESCRITA_EAN <= 75.15 AND  
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			`CpfCnpjProprietário` LIKE '10.377.679/0001-96';";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND
			viewCC.SOMA_NAOPRESCRITA_EAN <= 75.15 AND
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			`Situação` NOT LIKE 'ATV ENCERRADA'
			AND CpfCnpj LIKE '10.377.679/0001-96';";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}


function selectViewCNPJPrefeituraPrescritos($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND  
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) >= 5 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			`CpfCnpjProprietário` LIKE '10.377.679/0001-96';";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) >= 5 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			`Situação` NOT LIKE 'ATV ENCERRADA'
			AND CpfCnpj LIKE '10.377.679/0001-96';";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}


function selectViewCNPJPrefeituraExigSuspensa($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND  
			viewCC.Situacao_".$exercicio." LIKE '%Exigib%' AND 
			`CpfCnpjProprietário` LIKE '10.377.679/0001-96';";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.Situacao_".$exercicio." LIKE '%Exigib%' AND 
			`Situação` NOT LIKE 'ATV ENCERRADA'
			AND CpfCnpj LIKE '10.377.679/0001-96';";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}


function selectViewAnaliseNaoInscricaoCPFBrancoNomeSobrenomeValorInfimo($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND  
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN <= 75.15 AND 
			`CpfCnpjProprietário` LIKE '' AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5;";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN <= 75.15 AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			`Situação` NOT LIKE 'ATV ENCERRADA'
			AND CpfCnpj LIKE '';";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}


function selectViewAnaliseNaoInscricaoCPFInvalidoNomeSobrenomeValorInfimo($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND  
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND   
			`CpfCnpjProprietário` NOT LIKE '' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN <= 75.15 AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			(
			`CpfCnpjProprietário` LIKE '999.999.999-99' OR 
			`CpfCnpjProprietário` LIKE '000.000.000-00' OR 
			`CpfCnpjProprietário` LIKE '00.000.000/0000-00' OR 
			`CpfCnpjProprietário` LIKE '99.999.999/9999-99' OR 
			length(`CpfCnpjProprietário`)<14 OR 
			length(`CpfCnpjProprietário`)>18);";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			`Situação` NOT LIKE 'ATV ENCERRADA' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN <= 75.15  AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			`CpfCnpj` NOT LIKE '' AND
			(
			`CpfCnpj` LIKE '999.999.999-99' OR 
			`CpfCnpj` LIKE '000.000.000-00' OR 
			`CpfCnpj` LIKE '00.000.000/0000-00' OR 
			`CpfCnpj` LIKE '99.999.999/9999-99' OR 
			length(`CpfCnpj`)<14 OR 
			length(`CpfCnpj`)>18);";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}

function selectViewAnaliseNaoInscricaoCPFBrancoApenasNomeValorInfimo($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES < 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			`CpfCnpjProprietário` LIKE '' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN <= 75.15 AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5;";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES < 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			`Situação` NOT LIKE 'ATV ENCERRADA' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN <= 75.15 
			AND CpfCnpj LIKE '' AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND;";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}


function selectViewAnaliseNaoInscricaoCPFInvalidoApenasNomeValorInfimo($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES < 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			viewCC.SOMA_NAOPRESCRITA_EAN <= 75.15  AND 
			`CpfCnpjProprietário` NOT LIKE '' AND 
			(
			`CpfCnpjProprietário` LIKE '999.999.999-99' OR 
			`CpfCnpjProprietário` LIKE '000.000.000-00' OR 
			`CpfCnpjProprietário` LIKE '00.000.000/0000-00' OR 
			`CpfCnpjProprietário` LIKE '99.999.999/9999-99' OR 
			length(`CpfCnpjProprietário`)<14 OR 
			length(`CpfCnpjProprietário`)>18);";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES < 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			viewCC.SOMA_NAOPRESCRITA_EAN <= 75.15 AND 
			`Situação` NOT LIKE 'ATV ENCERRADA' AND 
			`CpfCnpj` NOT LIKE '' AND 
			(
			`CpfCnpj` LIKE '999.999.999-99' OR 
			`CpfCnpj` LIKE '000.000.000-00' OR 
			`CpfCnpj` LIKE '00.000.000/0000-00' OR 
			`CpfCnpj` LIKE '99.999.999/9999-99' OR 
			length(`CpfCnpj`)<14 OR 
			length(`CpfCnpj`)>18);";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}

function selectViewAnaliseNaoInscricaoCPFValidoApenasNomeValorInfimo($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES < 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND  
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			viewCC.SOMA_NAOPRESCRITA_EAN <= 75.15  AND 
			(
			`CpfCnpjProprietário` != '' 
			AND `CpfCnpjProprietário` NOT LIKE '999.999.999-99' 
			AND `CpfCnpjProprietário` NOT LIKE '000.000.000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '00.000.000/0000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '99.999.999/9999-99' 
			AND (length(`CpfCnpjProprietário`)>=14 AND length(`CpfCnpjProprietário`)<=18) 
			AND `CpfCnpjProprietário` NOT LIKE '10.377.679/0001-96'
			);";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES < 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 
			AND viewCC.SOMA_NAOPRESCRITA_EAN <= 75.15 
			AND `Situação` NOT LIKE 'ATV ENCERRADA'
			AND 
			(
			CpfCnpj != '' 
			AND CpfCnpj NOT LIKE '999.999.999-99' 
			AND CpfCnpj NOT LIKE '000.000.000-00' 
			AND CpfCnpj NOT LIKE '00.000.000/0000-00' 
			AND CpfCnpj NOT LIKE '99.999.999/9999-99' 
			AND (length(CpfCnpj)>=14 AND length(CpfCnpj)<=18) 
			AND CpfCnpj NOT LIKE '10.377.679/0001-96'
			);";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}


function selectViewAnaliseNaoInscricaoCPFValidoNomeSobrenomeValorInfimo($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 
			AND viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' 
			AND viewCC.SOMA_NAOPRESCRITA_EAN <= 75.15 AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 
			AND 
			(
			`CpfCnpjProprietário` != '' 
			AND `CpfCnpjProprietário` NOT LIKE '999.999.999-99' 
			AND `CpfCnpjProprietário` NOT LIKE '000.000.000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '00.000.000/0000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '99.999.999/9999-99' 
			AND (length(`CpfCnpjProprietário`)>=14 AND length(`CpfCnpjProprietário`)<=18) 
			AND `CpfCnpjProprietário` NOT LIKE '10.377.679/0001-96'
			);";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND 
			viewCC.QTD_NOMES >= 2 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			`Situação` NOT LIKE 'ATV ENCERRADA' AND 
			viewCC.SOMA_NAOPRESCRITA_EAN <= 75.15  AND 
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			(
			CpfCnpj != '' 
			AND CpfCnpj NOT LIKE '999.999.999-99' 
			AND CpfCnpj NOT LIKE '000.000.000-00' 
			AND CpfCnpj NOT LIKE '00.000.000/0000-00' 
			AND CpfCnpj NOT LIKE '99.999.999/9999-99' 
			AND (length(CpfCnpj)>=14 AND length(CpfCnpj)<=18) 
			AND CpfCnpj NOT LIKE '10.377.679/0001-96'
			);";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}


function selectViewAnaliseNaoInscricaoAtividadeEncerradaPrescrito($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			`Sequencial` LIKE '';";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) >= 5 AND 
			`Situação` LIKE 'ATV ENCERRADA';";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}


function selectViewAnaliseNaoInscricaoAtividadeEncerradaNaoPrescrito($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			`Sequencial` LIKE '';";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) < 5 AND 
			`Situação` LIKE 'ATV ENCERRADA';";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}



function selectViewAnaliseNaoInscricaoDemaisCNPJPrescritosSemCDA($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND  
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) >= 5 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND 
			`CpfCnpjProprietário` NOT LIKE '10.377.679/0001-96';";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) >= 5 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%' AND 
			`Situação` NOT LIKE 'ATV ENCERRADA'
			AND CpfCnpj NOT LIKE '10.377.679/0001-96';";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}


function selectViewAnaliseNaoInscricaoDemaisCNPJPrescritosComCDA($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND  
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) >= 5 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			viewCC.Situacao_".$exercicio." LIKE '%CDA%' AND 
			`CpfCnpjProprietário` NOT LIKE '10.377.679/0001-96';";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND
			TIMESTAMPDIFF(YEAR , viewCC.`DataSituacao_".$exercicio."`, CURRENT_DATE()) >= 5 AND 
			viewCC.Situacao_".$exercicio." NOT LIKE '%Exigib%' AND 
			viewCC.Situacao_".$exercicio." LIKE '%CDA%' AND 
			`Situação` NOT LIKE 'ATV ENCERRADA'
			AND CpfCnpj NOT LIKE '10.377.679/0001-96';";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}


function selectViewAnaliseNaoInscricaoExigSuspensa($exercicio, $natureza, $pdo){
	
	if ($natureza == "Imobiliária"){
		
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_ImobEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND  
			viewCC.Situacao_".$exercicio." LIKE '%Exigib%' AND 
			`CpfCnpjProprietário` NOT LIKE '10.377.679/0001-96';";
		
	
	} elseif ($natureza == "Mercantil"){
	
		$sqlView = "SELECT * FROM
			view_cadastroCompleto_MercEAN AS viewCC 
			WHERE
			viewCC.`".$exercicio."` > 0 AND
			viewCC.Situacao_".$exercicio." LIKE '%Exigib%' AND 
			AND CpfCnpj NOT LIKE '10.377.679/0001-96';";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}

?>