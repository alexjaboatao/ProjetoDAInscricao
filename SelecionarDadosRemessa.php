<?php

function buscarColunasExercicosEDados($pdo, $natureza){

	$sql = "show COLUMNS FROM baseacompanhamento$natureza";
	$buscar = $pdo->prepare($sql);
	$buscar->execute();

	$todascolunas = $buscar->fetchAll(PDO::FETCH_NUM);
	$qtdColunas = count($todascolunas);
	$arrayExercicosEDados = array();
	
	for($i=11; $i<$qtdColunas; $i++){

		array_push($arrayExercicosEDados,$todascolunas[$i][0]);
	}
	
	return $arrayExercicosEDados;
	
}

function selectGerarViewRemessa($natureza, $arrayexercicios, $pdo){

	$sql1if = "";
	$sql2if = "";
	$sql3if = "";
	$sql4if = "";
	
	$sqlSomatorio = "(CASE WHEN ((";
	$sqlAnosConcat = "CONCAT(";
	$sqlCDAConcat = "CONCAT(";
	
	$sqlAnosConcatPrescrito = "CONCAT(";
	$sqlSomatorioPrescrito = "(";
	$sqlCDAPrescrito = "CONCAT(";
	
	$sqlAnosConcatExigSuspensa = "CONCAT(";
	$sqlSomatorioExigSuspensa = "(";
	$sqlCDAExigSuspensa = "CONCAT(";
	
	$numerocolunas = count($arrayexercicios);
				
	for($i=0; $i<$numerocolunas-8; $i=$i+4){
		
		//primeira condição do SELECT (anos anteriores)
		if($i<count($arrayexercicios)-12){
			$sqlSomatorio = $sqlSomatorio."CASE WHEN (TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) < 5 
			AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
			THEN dat.".$arrayexercicios[$i]." ELSE 0 END + ";
			
			$sqlAnosConcat = $sqlAnosConcat."CASE WHEN (
			TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
			THEN '".$arrayexercicios[$i]."/' ELSE '' END, ";
			
			$sqlCDAConcat = $sqlCDAConcat."CASE WHEN (
			TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
			THEN CONCAT(dat.".$arrayexercicios[$i+3].",';') ELSE '' END, ";
			
			//////////////////////////////////////////
			
			$sqlSomatorioExigSuspensa = $sqlSomatorioExigSuspensa."CASE WHEN (dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." LIKE '%Exigib%') 
			THEN dat.".$arrayexercicios[$i]." ELSE 0 END + ";
			
			$sqlAnosConcatExigSuspensa = $sqlAnosConcatExigSuspensa."CASE WHEN (dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." LIKE '%Exigib%') 
			THEN '".$arrayexercicios[$i]."/' ELSE '' END, ";
			
			$sqlCDAExigSuspensa = $sqlCDAExigSuspensa."CASE WHEN (dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." LIKE '%Exigib%') 
			THEN CONCAT(dat.".$arrayexercicios[$i+3].",';') ELSE '' END, ";
			
			///////////////////////////////////////
			
			$sqlSomatorioPrescrito = $sqlSomatorioPrescrito."CASE WHEN (TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) >= 5 
			AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
			THEN dat.".$arrayexercicios[$i]." ELSE 0 END + ";
			
			$sqlAnosConcatPrescrito = $sqlAnosConcatPrescrito."CASE WHEN (
			TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) >= 5 AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
			THEN '".$arrayexercicios[$i]."/' ELSE '' END, ";
			
			$sqlCDAPrescrito = $sqlCDAPrescrito."CASE WHEN (
			TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) >= 5 AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
			THEN CONCAT(dat.".$arrayexercicios[$i+3].",';') ELSE '' END, ";
			
		}else{
			
			$sqlSomatorio = $sqlSomatorio."CASE WHEN (TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) < 5 
			AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
			THEN dat.".$arrayexercicios[$i]." ELSE 0 END) > 1943.58) THEN ";
			
			$sqlAnosConcat = $sqlAnosConcat."CASE WHEN 
			(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
			THEN '".$arrayexercicios[$i]."/' ELSE '' END) ELSE ";
			
			$sqlCDAConcat = $sqlCDAConcat."CASE WHEN 
			(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
			THEN CONCAT(dat.".$arrayexercicios[$i+3].",';') ELSE '' END) ELSE ";
			
			//////////////////////////////////
			
			$sqlSomatorioExigSuspensa = $sqlSomatorioExigSuspensa."CASE WHEN (dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." LIKE '%Exigib%') 
			THEN dat.".$arrayexercicios[$i]." ELSE 0 END + ";
			
			$sqlAnosConcatExigSuspensa = $sqlAnosConcatExigSuspensa."CASE WHEN (dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." LIKE '%Exigib%') 
			THEN '".$arrayexercicios[$i]."/' ELSE '' END, ";
			
			$sqlCDAExigSuspensa = $sqlCDAExigSuspensa."CASE WHEN (dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." LIKE '%Exigib%') 
			THEN CONCAT(dat.".$arrayexercicios[$i+3].",';') ELSE '' END, ";
			
			/////////////////////////////////
			
			$sqlSomatorioPrescrito = $sqlSomatorioPrescrito."CASE WHEN (TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) >= 5 
			AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
			THEN dat.".$arrayexercicios[$i]." ELSE 0 END) AS SOMA_PRESCRITO, ";
			
			$sqlAnosConcatPrescrito = $sqlAnosConcatPrescrito."CASE WHEN (
			TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) >= 5 AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
			THEN '".$arrayexercicios[$i]."/' ELSE '' END) AS ANOS_PRESCRITO, ";
			
			$sqlCDAPrescrito = $sqlCDAPrescrito."CASE WHEN (
			TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) >= 5 AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
			THEN CONCAT(dat.".$arrayexercicios[$i+3].",';') ELSE '' END) AS CDA_PRESCRITO, ";
			
		}
	}
	
	$sql1if = $sql1if.$sqlSomatorio.$sqlAnosConcat;
	
	//segunda condição do SELECT (anos anteriores + penúltimo ano)
	$sqlSomatorioComPenultimoExercicio = " + CASE WHEN 
		(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$numerocolunas-6].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$numerocolunas-8]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-7].
		" NOT LIKE '%Exigib%') THEN dat.".$arrayexercicios[$numerocolunas-8]." ELSE 0 END) > 1943.59) THEN ";
	
	$sqlAnosConcatPenultimoExercicio = ", CASE WHEN 
		(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$numerocolunas-6].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$numerocolunas-8]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-7]."
		NOT LIKE '%Exigib%') THEN '".$arrayexercicios[$numerocolunas-8]."/' ELSE '' END) ELSE ";
	
	$sqlCDAConcatPenultimoExercicio = ", CASE WHEN 
				(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$numerocolunas-6].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$numerocolunas-8]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-7]."
				NOT LIKE '%Exigib%') THEN CONCAT(dat.".$arrayexercicios[$numerocolunas-5].",';') ELSE '' END) ELSE ";
						
	
	$sql2if = substr($sqlSomatorio,0,strlen($sqlSomatorio)-18).$sqlSomatorioComPenultimoExercicio.substr($sqlAnosConcat,0,strlen($sqlAnosConcat)-7).$sqlAnosConcatPenultimoExercicio;
	
	//segunda condição do SELECT (anos anteriores + penúltimo ano + último ano)
	$sqlSomatorioComUltimoExercicio = " + CASE WHEN 
		(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$numerocolunas-2].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$numerocolunas-4]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-3].
		" NOT LIKE '%Exigib%') THEN dat.".$arrayexercicios[$numerocolunas-4]." ELSE 0 END) > 1943.59) THEN ";
	
	$sqlAnosConcatUltimoExercicio = " CASE WHEN 
		(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$numerocolunas-2].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$numerocolunas-4]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-3]."
		NOT LIKE '%Exigib%') THEN '".$arrayexercicios[$numerocolunas-4]."/' ELSE '' END) ELSE ";
	
	$sqlCDAConcatUltimoExercicio = " CASE WHEN 
		(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$numerocolunas-2].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$numerocolunas-4]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-3]."
		NOT LIKE '%Exigib%') THEN CONCAT(dat.".$arrayexercicios[$numerocolunas-1].",';') ELSE '' END) ELSE ";
	
	
	$sql3if = substr($sqlSomatorio,0,strlen($sqlSomatorio)-18).substr($sqlSomatorioComPenultimoExercicio,0,strlen($sqlSomatorioComPenultimoExercicio)-18).$sqlSomatorioComUltimoExercicio.substr($sqlAnosConcat,0,strlen($sqlAnosConcat)-7).substr($sqlAnosConcatPenultimoExercicio,0,strlen($sqlAnosConcatPenultimoExercicio)-7).",".$sqlAnosConcatUltimoExercicio."'VALOR INFIMO' END) END) END) AS ANOS_NAOPRESCRITO, ";
	
	$sql1ifSoma = $sqlSomatorio." ( ".substr($sqlSomatorio, 13, -17)." ELSE ";
	$sql2ifSoma = substr($sqlSomatorio,0,strlen($sqlSomatorio)-18).$sqlSomatorioComPenultimoExercicio."(".substr($sqlSomatorio,13,strlen($sqlSomatorio)-31).substr($sqlSomatorioComPenultimoExercicio, 0, -18).") ELSE ";
	$sql3ifSoma = substr($sqlSomatorio,0,strlen($sqlSomatorio)-18).substr($sqlSomatorioComPenultimoExercicio,0,strlen($sqlSomatorioComPenultimoExercicio)-18).$sqlSomatorioComUltimoExercicio."(".substr($sqlSomatorio,13,strlen($sqlSomatorio)-31).substr($sqlSomatorioComPenultimoExercicio, 0, -18).substr($sqlSomatorioComUltimoExercicio, 0, -18).") ELSE 0 END) END) END) AS SOMA_NAOPRESCRITO, ";
	
	$sql1ifCDA = $sqlSomatorio.$sqlCDAConcat;
	$sql2ifCDA = substr($sqlSomatorio,0,strlen($sqlSomatorio)-18).$sqlSomatorioComPenultimoExercicio.substr($sqlCDAConcat,0,strlen($sqlCDAConcat)-7).$sqlCDAConcatPenultimoExercicio;
	$sql3ifCDA = substr($sqlSomatorio,0,strlen($sqlSomatorio)-18).substr($sqlSomatorioComPenultimoExercicio,0,strlen($sqlSomatorioComPenultimoExercicio)-18).$sqlSomatorioComUltimoExercicio.substr($sqlCDAConcat,0,strlen($sqlCDAConcat)-7).substr($sqlCDAConcatPenultimoExercicio,0,strlen($sqlCDAConcatPenultimoExercicio)-7).",".$sqlCDAConcatUltimoExercicio."'' END) END) END) AS CDA_NAOPRESCRITO, ";
	
	
	
	$sqlAnosConcatExigSuspensa = $sqlAnosConcatExigSuspensa."CASE WHEN (dat.".$arrayexercicios[$numerocolunas-8]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-7]." LIKE '%Exigib%') 
			THEN '".$arrayexercicios[$numerocolunas-8]."/' ELSE '' END, "."CASE WHEN (dat.".$arrayexercicios[$numerocolunas-4]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-3]." LIKE '%Exigib%') THEN '".$arrayexercicios[$numerocolunas-4]."/' ELSE '' END) AS ANOS_EXIGSUSP, ";
	
	$sqlSomatorioExigSuspensa = $sqlSomatorioExigSuspensa."CASE WHEN (dat.".$arrayexercicios[$numerocolunas-8]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-7]." LIKE '%Exigib%') THEN dat.".$arrayexercicios[$numerocolunas-8]." ELSE 0 END + CASE WHEN (dat.".$arrayexercicios[$numerocolunas-4]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-3]." LIKE '%Exigib%') THEN dat.".$arrayexercicios[$numerocolunas-4]." ELSE 0 END) AS SOMA_EXIGSUSP, ";
		
	$sqlCDAExigSuspensa = $sqlCDAExigSuspensa."CASE WHEN (dat.".$arrayexercicios[$numerocolunas-8]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-7]." LIKE '%Exigib%') THEN CONCAT(dat.".$arrayexercicios[$numerocolunas-5].",';') ELSE '' END, "."CASE WHEN (dat.".$arrayexercicios[$numerocolunas-4]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-3]." LIKE '%Exigib%') THEN CONCAT(dat.".$arrayexercicios[$numerocolunas-1].",';') ELSE '' END) AS CDA_EXIGSUSP ";
			
	

	if ($natureza == "Imobiliáriadat"){
		
		$sqlInicio = "SELECT *, (LENGTH(dat.`NomeProprietário`)-LENGTH(replace(dat.`NomeProprietário`,' ',''))+1) AS QTD_NOMES,";
		
		$sqlfim = " FROM
			`baseacompanhamento$natureza` AS dat;";
		
	
	} elseif ($natureza == "Mercantildat"){
	
		$sqlInicio = "SELECT *, (LENGTH(dat.`RazãoSocial`)-LENGTH(replace(dat.`RazãoSocial`,' ',''))+1) AS QTD_NOMES,";
		
		$sqlfim = " FROM
			`baseacompanhamento$natureza` AS dat;";
	
	}
	
	
	$sql = $sqlInicio." ".$sql1if." ".$sql2if." ".$sql3if." ".$sql1ifSoma." ".$sql2ifSoma." ".$sql3ifSoma." ".$sql1ifCDA." ".$sql2ifCDA." ".$sql3ifCDA." ".$sqlAnosConcatPrescrito." ".$sqlSomatorioPrescrito." ".$sqlCDAPrescrito." ".$sqlAnosConcatExigSuspensa." ".$sqlSomatorioExigSuspensa." ".$sqlCDAExigSuspensa." ".$sqlfim;
	
	return $sql;
}


function criarViewRemessa($select, $natureza, $pdo){
	
	if($natureza == "Mercantildat"){
		$criarview = "CREATE OR REPLACE VIEW view_Remessa_MercDAT AS ".$select;
	}elseif($natureza == "Imobiliáriadat"){
		$criarview = "CREATE OR REPLACE VIEW view_Remessa_ImobDAT AS ".$select;
	}
	
	$view = $pdo->query($criarview);
	$view->execute();
}


function selectViewTratadosRemessa($natureza, $pdo){
	
	if ($natureza == "Imobiliáriadat"){
		
		$sqlView = "SELECT InscriçãoImobiliária, Sequencial, CpfCnpjProprietário, NomeProprietário, Natureza, EndereçoImóvel, Regional, SOMA_NAOPRESCRITO, ANOS_NAOPRESCRITO, CDA_NAOPRESCRITO FROM
			view_Remessa_ImobDAT AS viewCC 
			WHERE
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE 'VALOR INFIMO' AND 
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2018/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/2018/' AND
			viewCC.QTD_NOMES >= 2 AND  
			(
			`CpfCnpjProprietário` != '' 
			AND `CpfCnpjProprietário` NOT LIKE '999.999.999-99' 
			AND `CpfCnpjProprietário` NOT LIKE '000.000.000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '00.000.000/0000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '99.999.999/9999-99' 
			AND (length(`CpfCnpjProprietário`)>=14 AND length(`CpfCnpjProprietário`)<=18) 
			AND `CpfCnpjProprietário` NOT LIKE '10.377.679/0001-96'
			);";
		
	
	} elseif ($natureza == "Mercantildat"){
	
		$sqlView = "SELECT InscriçãoMercantil, CpfCnpj, RazãoSocial, Endereço, Situação, TipoPessoa, SOMA_NAOPRESCRITO, ANOS_NAOPRESCRITO, CDA_NAOPRESCRITO FROM
			view_Remessa_MercDAT AS viewCC 
			WHERE
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE 'VALOR INFIMO' AND 
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2018/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/2018/' AND
			viewCC.QTD_NOMES >= 2 AND  
			(
			CpfCnpj != '' 
			AND CpfCnpj NOT LIKE '999.999.999-99' 
			AND CpfCnpj NOT LIKE '000.000.000-00' 
			AND CpfCnpj NOT LIKE '00.000.000/0000-00' 
			AND CpfCnpj NOT LIKE '99.999.999/9999-99' 
			AND (length(CpfCnpj)>=14 AND length(`CpfCnpj`)<=18) 
			AND CpfCnpj NOT LIKE '10.377.679/0001-96'
			AND CpfCnpj NOT LIKE '10.377.679/0001-96'
			);";
			
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}


function somaCountViewTratadosRemessa($natureza, $pdo){
	
	if ($natureza == "Imobiliáriadat"){
		
		$sqlView = "SELECT SUM(SOMA_NAOPRESCRITO), count(SOMA_NAOPRESCRITO) FROM
			view_Remessa_ImobDAT AS viewCC 
			WHERE
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE 'VALOR INFIMO' AND 
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2018/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/2018/' AND
			viewCC.QTD_NOMES >= 2 AND  
			(
			`CpfCnpjProprietário` != '' 
			AND `CpfCnpjProprietário` NOT LIKE '999.999.999-99' 
			AND `CpfCnpjProprietário` NOT LIKE '000.000.000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '00.000.000/0000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '99.999.999/9999-99' 
			AND (length(`CpfCnpjProprietário`)>=14 AND length(`CpfCnpjProprietário`)<=18) 
			AND `CpfCnpjProprietário` NOT LIKE '10.377.679/0001-96'
			);";
		
	
	} elseif ($natureza == "Mercantildat"){
	
		$sqlView = "SELECT SUM(SOMA_NAOPRESCRITO), count(SOMA_NAOPRESCRITO) FROM
			view_Remessa_MercDAT AS viewCC 
			WHERE
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE 'VALOR INFIMO' AND 
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2018/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/2018/' AND
			viewCC.QTD_NOMES >= 2 AND  
			(
			CpfCnpj != '' 
			AND CpfCnpj NOT LIKE '999.999.999-99' 
			AND CpfCnpj NOT LIKE '000.000.000-00' 
			AND CpfCnpj NOT LIKE '00.000.000/0000-00' 
			AND CpfCnpj NOT LIKE '99.999.999/9999-99' 
			AND (length(CpfCnpj)>=14 AND length(`CpfCnpj`)<=18) 
			AND CpfCnpj NOT LIKE '10.377.679/0001-96'
			AND CpfCnpj NOT LIKE '10.377.679/0001-96'
			);";
			
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
}


function selectViewAnaliseRemessaCPFBrancoApenasNome($natureza, $pdo){
	
	if ($natureza == "Imobiliáriadat"){
		
		$sqlView = "SELECT InscriçãoImobiliária, Sequencial, CpfCnpjProprietário, NomeProprietário, Natureza, EndereçoImóvel, Regional, SOMA_NAOPRESCRITO, ANOS_NAOPRESCRITO, CDA_NAOPRESCRITO FROM
			view_Remessa_ImobDAT AS viewCC 
			WHERE
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE 'VALOR INFIMO' AND 
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2018/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/2018/' AND
			viewCC.QTD_NOMES < 2 AND  
			`CpfCnpjProprietário` LIKE '';";
		
	
	} elseif ($natureza == "Mercantildat"){
	
		$sqlView = "SELECT InscriçãoMercantil, CpfCnpj, RazãoSocial, Endereço, Situação, TipoPessoa, SOMA_NAOPRESCRITO, ANOS_NAOPRESCRITO, CDA_NAOPRESCRITO FROM
			view_Remessa_MercDAT AS viewCC 
			WHERE
			view_Remessa_MercDAT AS viewCC 
			WHERE
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE 'VALOR INFIMO' AND 
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2018/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/2018/' AND
			viewCC.QTD_NOMES < 2 AND  
			CpfCnpj LIKE '';";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}


function somaCountViewAnaliseRemessaCPFBrancoApenasNome($natureza, $pdo){
	
	if ($natureza == "Imobiliáriadat"){
		
		$sqlView = "SELECT SUM(SOMA_NAOPRESCRITO), count(SOMA_NAOPRESCRITO) FROM
			view_Remessa_ImobDAT AS viewCC 
			WHERE
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE 'VALOR INFIMO' AND 
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2018/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/2018/' AND
			viewCC.QTD_NOMES < 2 AND  
			`CpfCnpjProprietário` LIKE '';";
		
	
	} elseif ($natureza == "Mercantildat"){
	
		$sqlView = "SELECT SUM(SOMA_NAOPRESCRITO), count(SOMA_NAOPRESCRITO) FROM
			view_Remessa_MercDAT AS viewCC 
			WHERE
			view_Remessa_MercDAT AS viewCC 
			WHERE
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE 'VALOR INFIMO' AND 
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2018/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/2018/' AND
			viewCC.QTD_NOMES < 2 AND  
			CpfCnpj LIKE '';";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}


function selectViewAnaliseRemessaCPFInvalidoApenasNome($natureza, $pdo){
	
	if ($natureza == "Imobiliáriadat"){
		
		$sqlView = "SELECT InscriçãoImobiliária, Sequencial, CpfCnpjProprietário, NomeProprietário, Natureza, EndereçoImóvel, Regional, SOMA_NAOPRESCRITO, ANOS_NAOPRESCRITO, CDA_NAOPRESCRITO FROM
			view_Remessa_ImobDAT AS viewCC 
			WHERE
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE 'VALOR INFIMO' AND 
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2018/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/2018/' AND
			viewCC.QTD_NOMES < 2 AND  
			( 
			`CpfCnpjProprietário` LIKE '999.999.999-99' OR 
			`CpfCnpjProprietário` LIKE '000.000.000-00' OR 
			`CpfCnpjProprietário` LIKE '00.000.000/0000-00' OR 
			`CpfCnpjProprietário` LIKE '99.999.999/9999-99' OR 
			length(`CpfCnpjProprietário`)<14 OR 
			length(`CpfCnpjProprietário`)>18 
			)
			AND length(`CpfCnpjProprietário`) <> 0
			;";
		
	
	} elseif ($natureza == "Mercantildat"){
	
		$sqlView = "SELECT InscriçãoMercantil, CpfCnpj, RazãoSocial, Endereço, Situação, TipoPessoa, SOMA_NAOPRESCRITO, ANOS_NAOPRESCRITO, CDA_NAOPRESCRITO FROM
			view_Remessa_MercDAT AS viewCC 
			WHERE
			view_Remessa_MercDAT AS viewCC 
			WHERE
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE 'VALOR INFIMO' AND 
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2018/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/2018/' AND
			viewCC.QTD_NOMES < 2 AND  
			(
			`CpfCnpj` LIKE '999.999.999-99' OR 
			`CpfCnpj` LIKE '000.000.000-00' OR 
			`CpfCnpj` LIKE '00.000.000/0000-00' OR 
			`CpfCnpj` LIKE '99.999.999/9999-99' OR 
			length(`CpfCnpj`)<14 OR 
			length(`CpfCnpj`)>18
			)
			AND length(`CpfCnpj`) <> 0
			;";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}


function somaCountViewAnaliseRemessaCPFInvalidoApenasNome($natureza, $pdo){
	
	if ($natureza == "Imobiliáriadat"){
		
		$sqlView = "SELECT SUM(SOMA_NAOPRESCRITO), count(SOMA_NAOPRESCRITO) FROM
			view_Remessa_ImobDAT AS viewCC 
			WHERE
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE 'VALOR INFIMO' AND 
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2018/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/2018/' AND
			viewCC.QTD_NOMES < 2 AND  
			(
			`CpfCnpjProprietário` LIKE '999.999.999-99' OR 
			`CpfCnpjProprietário` LIKE '000.000.000-00' OR 
			`CpfCnpjProprietário` LIKE '00.000.000/0000-00' OR 
			`CpfCnpjProprietário` LIKE '99.999.999/9999-99' OR 
			length(`CpfCnpjProprietário`)<14 OR 
			length(`CpfCnpjProprietário`)>18 
			)
			AND length(`CpfCnpjProprietário`) <> 0
			;";
		
	
	} elseif ($natureza == "Mercantildat"){
	
		$sqlView = "SELECT SUM(SOMA_NAOPRESCRITO), count(SOMA_NAOPRESCRITO) FROM
			view_Remessa_MercDAT AS viewCC 
			WHERE
			view_Remessa_MercDAT AS viewCC 
			WHERE
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE 'VALOR INFIMO' AND 
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2018/' AND
			viewCC.`ANOS_NAOPRESCRITO` NOT LIKE '2017/2018/' AND
			viewCC.QTD_NOMES < 2 AND  
			(
			`CpfCnpj` LIKE '999.999.999-99' OR 
			`CpfCnpj` LIKE '000.000.000-00' OR 
			`CpfCnpj` LIKE '00.000.000/0000-00' OR 
			`CpfCnpj` LIKE '99.999.999/9999-99' OR 
			length(`CpfCnpj`)<14 OR 
			length(`CpfCnpj`)>18
			)
			AND length(`CpfCnpj`) <> 0
			;";
	
	}
	
	$sql = $pdo->query($sqlView);
	$sql->execute();
	return $sql->fetchAll(PDO::FETCH_NUM);
	
}


?>