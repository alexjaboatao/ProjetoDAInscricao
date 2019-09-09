<?php

function selectCadastroCompleto($natureza, $arrayexercicios){
	
	$sqlSomatorio = "(CASE WHEN ((";
	
	$numerocolunas = count($arrayexercicios);
				
	for($i=0; $i<$numerocolunas-8; $i=$i+4){
		
		//primeira condição do SELECT (anos anteriores)
		if($i<count($arrayexercicios)-12){
			$sqlSomatorio = $sqlSomatorio."CASE WHEN (TIMESTAMPDIFF(YEAR , ean.`".$arrayexercicios[$i+2]."`, CURRENT_DATE()) < 5 
			AND ean.`".$arrayexercicios[$i]."` <> 0 AND ean.`".$arrayexercicios[$i+1]."` NOT LIKE '%Exigib%' AND ean.`".$arrayexercicios[$i+3]."` LIKE '') 
			THEN ean.`".$arrayexercicios[$i]."` ELSE 0 END + ";
			
			
		}else{
			
			$sqlSomatorio = $sqlSomatorio."CASE WHEN (TIMESTAMPDIFF(YEAR , ean.`".$arrayexercicios[$i+2]."`, CURRENT_DATE()) < 5 
			AND ean.`".$arrayexercicios[$i]."` <> 0 AND ean.`".$arrayexercicios[$i+1]."` NOT LIKE '%Exigib%' AND ean.`".$arrayexercicios[$i+3]."` LIKE '') 
			THEN ean.`".$arrayexercicios[$i]."` ELSE 0 END) > 75.15) THEN ";
			
		}
	}
	
	$sqlSomatorioComPenultimoExercicio = " + CASE WHEN 
		(TIMESTAMPDIFF(YEAR , ean.`".$arrayexercicios[$numerocolunas-6]."`, CURRENT_DATE()) < 5 AND ean.`".$arrayexercicios[$numerocolunas-8]."` <> 0 AND ean.`".$arrayexercicios[$numerocolunas-7].
		"` NOT LIKE '%Exigib%' AND ean.`".$arrayexercicios[$i+3]."` LIKE '') THEN ean.`".$arrayexercicios[$numerocolunas-8]."` ELSE 0 END) > 75.15) THEN ";
	
	$sqlSomatorioComUltimoExercicio = " + CASE WHEN 
		(TIMESTAMPDIFF(YEAR , ean.`".$arrayexercicios[$numerocolunas-2]."`, CURRENT_DATE()) < 5 AND ean.`".$arrayexercicios[$numerocolunas-4]."` <> 0 AND ean.`".$arrayexercicios[$numerocolunas-3].
		"` NOT LIKE '%Exigib%' AND ean.`".$arrayexercicios[$i+3]."` LIKE '') THEN ean.`".$arrayexercicios[$numerocolunas-4]."` ELSE 0 END) > 75.15) THEN ";
	
	$sql1ifSoma = $sqlSomatorio." ( ".substr($sqlSomatorio, 13, -14)." ELSE ";
	$sql2ifSoma = substr($sqlSomatorio,0,-16).$sqlSomatorioComPenultimoExercicio."(".substr($sqlSomatorio,13,-16).substr($sqlSomatorioComPenultimoExercicio, 0, -16).") ELSE ";
	$sql3ifSoma = substr($sqlSomatorio,0,-16).substr($sqlSomatorioComPenultimoExercicio,0,-16).$sqlSomatorioComUltimoExercicio."(".substr($sqlSomatorio,13,-16).substr($sqlSomatorioComPenultimoExercicio, 0, -16).substr($sqlSomatorioComUltimoExercicio, 0, -16).") ELSE 0 END) END) END) AS SOMA_EAN ";
	
	
	if ($natureza == "Imobiliária"){
		
		$sqlInicio = "SELECT *, (LENGTH(ean.`NomeProprietário`)-LENGTH(replace(ean.`NomeProprietário`,' ',''))+1) AS QTD_NOMES,";
		
		$sqlfim = " FROM
			`baseacompanhamento$natureza` AS ean
			WHERE
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
	
		$sqlInicio = "SELECT *, (LENGTH(ean.`RazãoSocial`)-LENGTH(replace(ean.`RazãoSocial`,' ',''))+1) AS QTD_NOMES,";
		
		$sqlfim = " FROM
			`baseacompanhamento$natureza` AS ean
			WHERE
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
	
	return $sql = $sqlInicio." ".$sql1ifSoma." ".$sql2ifSoma." ".$sql3ifSoma.$sqlfim;
	
}

function criarViewCadastroCompleto($select, $natureza, $pdo){
	
	if($natureza == "Mercantil"){
		$criarview = "CREATE OR REPLACE VIEW view_cadastroCompleto_MercEAN AS ".$select;
	}elseif($natureza == "Imobiliária"){
		$criarview = "CREATE OR REPLACE VIEW view_cadastroCompleto_ImobEAN AS ".$select;
	}
	
	$view = $pdo->query($criarview);
	$view->execute();
}

function selectViewCadastroCompletoSemInterrupcao($exercicio, $natureza, $pdo){
	
	if($natureza == "Mercantil"){
		$criarview = "SELECT viewCC.`InscriçãoMercantil` from view_cadastroCompleto_MercEAN viewCC WHERE viewCC.`".$exercicio."` > 0 AND viewCC.QTD_NOMES >= 2 AND viewCC.Situacao_".$exercicio." LIKE ''";
	}elseif($natureza == "Imobiliária"){
		$criarview = "SELECT viewCC.`Sequencial` from view_cadastroCompleto_ImobEAN viewCC WHERE viewCC.`".$exercicio."` > 0 AND viewCC.QTD_NOMES >= 2 AND viewCC.Situacao_".$exercicio." LIKE ''";
	}
	
}


function selectViewCadastroCompletoDesparcelado($exercicio, $natureza, $pdo){
	
	if($natureza == "Mercantil"){
		$criarview = "SELECT viewCC.`InscriçãoMercantil` from view_cadastroCompleto_MercEAN viewCC WHERE viewCC.`".$exercicio."` > 0 AND viewCC.QTD_NOMES >= 2 AND viewCC.Situacao_".$exercicio." LIKE '%Parcelamento%' AND viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%'";
	}elseif($natureza == "Imobiliária"){
		$criarview = "SELECT viewCC.`Sequencial` from view_cadastroCompleto_ImobEAN viewCC WHERE viewCC.`".$exercicio."` > 0 AND viewCC.QTD_NOMES >= 2 AND viewCC.Situacao_".$exercicio." LIKE '%Parcelamento%' AND viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%'";
	}
	
}


function selectViewCadastroCompletoRelancado($exercicio, $natureza, $pdo){
	
	if($natureza == "Mercantil"){
		$criarview = "SELECT viewCC.`InscriçãoMercantil` from view_cadastroCompleto_MercEAN viewCC WHERE viewCC.`".$exercicio."` > 0 AND viewCC.QTD_NOMES >= 2 AND viewCC.Situacao_".$exercicio." LIKE '%Lançado%' AND viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%'";
	}elseif($natureza == "Imobiliária"){
		$criarview = "SELECT viewCC.`Sequencial` from view_cadastroCompleto_ImobEAN viewCC WHERE viewCC.`".$exercicio."` > 0 AND viewCC.QTD_NOMES >= 2 AND viewCC.Situacao_".$exercicio." LIKE '%Lançado%' AND viewCC.Situacao_".$exercicio." NOT LIKE '%CDA%'";
	}
	
}



?>