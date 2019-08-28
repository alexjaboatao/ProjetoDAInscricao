<?php 
require_once "conexao.php";

function buscarExercicio($pdo, $natureza){

	$sql = "show COLUMNS FROM baseacompanhamento$natureza";
	$buscar = $pdo->prepare($sql);
	$buscar->execute();
	return $buscar->fetchAll(PDO::FETCH_NUM);
}

function anosInscrever($ano, $natureza, $pdo){
	if ($natureza == "Imobiliária"){
	$sql = "SELECT * FROM baseacompanhamento$natureza WHERE 
		(`$ano` != '' AND `$ano` NOT LIKE '%-%') AND 
		(`CpfCnpjProprietário` != '' AND 
		`CpfCnpjProprietário` NOT LIKE '999.999.999-99' 
		AND `CpfCnpjProprietário` NOT LIKE '000.000.000-00' 
		AND `CpfCnpjProprietário` NOT LIKE '00.000.000/0000-00' 
		AND `CpfCnpjProprietário` NOT LIKE '99.999.999/9999-99' 
		AND (length(`CpfCnpjProprietário`)>=14 AND length(`CpfCnpjProprietário`)<=18) AND 
		`CpfCnpjProprietário` NOT LIKE '10.377.679/0001-96')";
	$inscricao = $pdo->query($sql);
	$inscricao->execute();
	return $inscricao->fetchAll(PDO::FETCH_NUM);
	} elseif ($natureza == "Mercantil"){
		$sql = "SELECT * FROM baseacompanhamento$natureza WHERE 
		(`$ano` != '' AND `$ano` NOT LIKE '%-%') AND 
		(`CpfCnpj` != '' AND 
		`CpfCnpj` NOT LIKE '999.999.999-99' 
		AND `CpfCnpj` NOT LIKE '000.000.000-00' 
		AND `CpfCnpj` NOT LIKE '00.000.000/0000-00' 
		AND `CpfCnpj` NOT LIKE '99.999.999/9999-99' 
		AND (length(`CpfCnpj`)>=14 AND length(`CpfCnpj`)<=18) AND 
		`CpfCnpj` NOT LIKE '10.377.679/0001-96')";
	$inscricao = $pdo->query($sql);
	$inscricao->execute();
	return $inscricao->fetchAll(PDO::FETCH_NUM);
	}
}
function anosDesparcelados($ano, $natureza, $pdo){
	if ($natureza == "Imobiliária"){
	$sql = "SELECT * FROM baseacompanhamento$natureza WHERE 
		(`$ano` LIKE '%Parcelamento%') AND 
		(`CpfCnpjProprietário` != '' AND 
		`CpfCnpjProprietário` NOT LIKE '999.999.999-99' 
		AND `CpfCnpjProprietário` NOT LIKE '000.000.000-00' 
		AND `CpfCnpjProprietário` NOT LIKE '00.000.000/0000-00' 
		AND `CpfCnpjProprietário` NOT LIKE '99.999.999/9999-99' 
		AND (length(`CpfCnpjProprietário`)>=14 AND length(`CpfCnpjProprietário`)<=18) AND 
		`CpfCnpjProprietário` NOT LIKE '10.377.679/0001-96')";
	$inscricao = $pdo->query($sql);
	$inscricao->execute();
	return $inscricao->fetchAll(PDO::FETCH_NUM);
	} elseif ($natureza == "Mercantil"){
		$sql = "SELECT * FROM baseacompanhamento$natureza WHERE 
		(`$ano` LIKE '%Parcelamento%') AND 
		(`CpfCnpj` != '' AND 
		`CpfCnpj` NOT LIKE '999.999.999-99' 
		AND `CpfCnpj` NOT LIKE '000.000.000-00' 
		AND `CpfCnpj` NOT LIKE '00.000.000/0000-00' 
		AND `CpfCnpj` NOT LIKE '99.999.999/9999-99' 
		AND (length(`CpfCnpj`)>=14 AND length(`CpfCnpj`)<=18) AND 
		`CpfCnpj` NOT LIKE '10.377.679/0001-96')";
	$inscricao = $pdo->query($sql);
	$inscricao->execute();
	return $inscricao->fetchAll(PDO::FETCH_NUM);
		}
	}
	
function retornarProblemasCadastroCPFCNPJ($ano, $natureza, $pdo){
	if ($natureza == "Imobiliária"){
	$sql = "SELECT InscriçãoImobiliária, Sequencial, CpfCnpjProprietário, NomeProprietário, Natureza, EndereçoImóvel, Regional, `$ano` FROM baseacompanhamento$natureza WHERE (
			`CpfCnpjProprietário` LIKE '' OR `CpfCnpjProprietário` LIKE '999.999.999-99' OR 
			`CpfCnpjProprietário` LIKE '000.000.000-00' OR 
			`CpfCnpjProprietário` LIKE '00.000.000/0000-00' OR 
			`CpfCnpjProprietário` LIKE '99.999.999/9999-99' OR 
			length(`CpfCnpjProprietário`)<14 OR 
			length(`CpfCnpjProprietário`)>18) 
			AND ((`$ano` != '' AND `$ano` LIKE '%Parcelamento%') OR (`$ano` != '' AND `$ano` NOT LIKE '%-%'))";
	
	} elseif ($natureza == "Mercantil"){
		$sql = "SELECT InscriçãoMercantil, CpfCnpj, RazãoSocial, Endereço, Situação, TipoPessoa, `$ano` FROM baseacompanhamento$natureza WHERE (
			`CpfCnpj` LIKE '' OR `CpfCnpj` LIKE '999.999.999-99' OR 
			`CpfCnpj` LIKE '000.000.000-00' OR 
			`CpfCnpj` LIKE '00.000.000/0000-00' OR 
			`CpfCnpj` LIKE '99.999.999/9999-99' OR 
			length(`CpfCnpj`)<14 OR 
			length(`CpfCnpj`)>18) 
			AND ((`$ano` != '' AND `$ano` LIKE '%Parcelamento%') OR (`$ano` != '' AND `$ano` NOT LIKE '%-%'))";
	
		}
		$inscricao = $pdo->query($sql);
		$inscricao->execute();
		return $inscricao->fetchAll(PDO::FETCH_NUM);
	}
	
function retornarDebitosLancadosCNPJPrefeitura($ano, $natureza, $pdo){
	if ($natureza == "Imobiliária"){
	$sql = "SELECT Sequencial FROM baseacompanhamento$natureza WHERE (
			`CpfCnpjProprietário` LIKE '10.377.679/0001-96' OR `CpfCnpjProprietário` LIKE '10377679000196') 
			AND ((`$ano` != '' AND `$ano` LIKE '%Parcelamento%') OR (`$ano` != '' AND `$ano` NOT LIKE '%-%'))";
	
	} elseif ($natureza == "Mercantil"){
		$sql = "SELECT InscriçãoMercantil FROM baseacompanhamento$natureza WHERE (
			`CpfCnpj` LIKE '10.377.679/0001-96' OR `CpfCnpj` LIKE '10377679000196') 
			AND ((`$ano` != '' AND `$ano` LIKE '%Parcelamento%') OR (`$ano` != '' AND `$ano` NOT LIKE '%-%'))";
	
		}
	$inscricao = $pdo->query($sql);
	$inscricao->execute();
	return $inscricao->fetchAll(PDO::FETCH_NUM);
}

function retornarLancamentosRetroativos($ano, $natureza, $pdo){
	if ($natureza == "Imobiliária"){
	$sql = "SELECT * FROM `baseacompanhamento$natureza` WHERE 
		`CpfCnpjProprietário` NOT LIKE '' AND 
		`CpfCnpjProprietário` NOT LIKE '999.999.999-99' AND 
		`CpfCnpjProprietário` NOT LIKE '000.000.000-00' AND 
		`CpfCnpjProprietário` NOT LIKE '00.000.000/0000-00' AND 
		`CpfCnpjProprietário` NOT LIKE '99.999.999/9999-99' AND 
		(length(`CpfCnpjProprietário`)>=14 AND length(`CpfCnpjProprietário`)<=18) AND 
		(`$ano` NOT LIKE '%Parcelamento%' AND `$ano` LIKE '%Lançado%')";
	
	} elseif ($natureza == "Mercantil"){
		$sql = "SELECT * FROM `baseacompanhamento$natureza` WHERE 
		`CpfCnpj` NOT LIKE '' AND 
		`CpfCnpj` NOT LIKE '999.999.999-99' AND 
		`CpfCnpj` NOT LIKE '000.000.000-00' AND 
		`CpfCnpj` NOT LIKE '00.000.000/0000-00' AND 
		`CpfCnpj` NOT LIKE '99.999.999/9999-99' AND 
		(length(`CpfCnpj`)>=14 AND length(`CpfCnpj`)<=18) AND 
		(`$ano` NOT LIKE '%Parcelamento%' AND `$ano` LIKE '%Lançado%')";
	
		}
	$inscricao = $pdo->query($sql);
	$inscricao->execute();
	return $inscricao->fetchAll(PDO::FETCH_NUM);
}

function criarViewAnosRemessa($select, $natureza, $pdo){
	if($natureza == "Mercantildat"){
		$criarview = "CREATE OR REPLACE VIEW view_remessaanos_MercDAT AS ".$select;
	}elseif($natureza == "Imobiliáriadat"){
		$criarview = "CREATE OR REPLACE VIEW view_remessaanos_ImobDAT AS ".$select;
	}
	
	$view = $pdo->query($criarview);
	$view->execute();
}


function selectCountAnosRemessa($natureza, $pdo){
	
	if($natureza == "Mercantildat"){
		$sql = "SELECT COUNT(*) FROM view_remessaanos_MercDAT WHERE ANOSREMESSA NOT LIKE 'VALOR INFIMO'";
	}elseif($natureza == "Imobiliáriadat"){
		$sql = "SELECT COUNT(*) FROM view_remessaanos_ImobDAT WHERE ANOSREMESSA NOT LIKE 'VALOR INFIMO'";
	}
	
	$select = $pdo->query($sql);
	$select->execute();
	return $select->fetchAll(PDO::FETCH_NUM);
	
}

function selectSumAnosRemessa($natureza, $pdo){
	
	if($natureza == "Mercantildat"){
		$sql = "SELECT ROUND(SUM(SOMAREMESSA),2) AS TOTAL FROM view_remessaanos_mercDAT WHERE ANOSREMESSA NOT LIKE 'VALOR INFIMO'";
	}elseif($natureza == "Imobiliáriadat"){
		$sql = "SELECT ROUND(SUM(SOMAREMESSA),2) AS TOTAL FROM view_remessaanos_imobDAT WHERE ANOSREMESSA NOT LIKE 'VALOR INFIMO'";
	}
	
	$select = $pdo->query($sql);
	$select->execute();
	return $select->fetchAll(PDO::FETCH_NUM);
	
}

function selectTudoViewDAT($natureza, $pdo){
	
	if($natureza == "Mercantildat"){
		$sql = "SELECT * FROM view_remessaanos_MercDAT WHERE ANOSREMESSA NOT LIKE 'VALOR INFIMO'";
	}elseif($natureza = "Imobiliáriadat"){
		$sql = "SELECT * FROM view_remessaanos_ImobDAT WHERE ANOSREMESSA NOT LIKE 'VALOR INFIMO'";
	}
	
	$select = $pdo->query($sql);
	$select->execute();
	return $select->fetchAll(PDO::FETCH_NUM);
}


function retornaAnosRemessa($natureza, $arrayexercicios, $pdo){
	
	if ($natureza == "Imobiliáriadat"){
		
		$sql = "SELECT dat.Sequencial, ";
		$sql1if = "";
		$sql2if = "";
		$sql3if = "";
		$sql4if = "";
		$sqlSomatorio = "(CASE WHEN ((";
		$sqlAnosConcat = "CONCAT(";
		
		$numerocolunas = count($arrayexercicios);
					
		for($i=0; $i<$numerocolunas-6; $i=$i+3){
			
			//primeira condição do SELECT (anos anteriores)
			if($i<count($arrayexercicios)-9){
				$sqlSomatorio = $sqlSomatorio."CASE WHEN (TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) < 5 
				AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
				THEN dat.".$arrayexercicios[$i]." ELSE 0 END + ";
				
				$sqlAnosConcat = $sqlAnosConcat."CASE WHEN (
				TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
				THEN '".$arrayexercicios[$i]."/' ELSE '' END, ";
				
				
			}else{
				
				$sqlSomatorio = $sqlSomatorio."CASE WHEN (TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) < 5 
				AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
				THEN dat.".$arrayexercicios[$i]." ELSE 0 END) > 1943.58) THEN ";
				
				$sqlAnosConcat = $sqlAnosConcat."CASE WHEN 
				(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
				THEN '".$arrayexercicios[$i]."/' ELSE '' END) ELSE ";
				
				
			}
			
		}
		
		$sql1if = $sql1if.$sqlSomatorio.$sqlAnosConcat;
		
		//segunda condição do SELECT (anos anteriores + penúltimo ano)
		$sqlSomatorioComPenultimoExercicio = " + CASE WHEN 
			(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$numerocolunas-4].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$numerocolunas-6]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-5].
			" NOT LIKE '%Exigib%') THEN dat.".$arrayexercicios[$numerocolunas-6]." ELSE 0 END) > 1943.59) THEN ";
		
		$sqlAnosConcatPenultimoExercicio = ", CASE WHEN 
			(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$numerocolunas-4].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$numerocolunas-6]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-5]."
			NOT LIKE '%Exigib%') THEN '".$arrayexercicios[$numerocolunas-6]."/' ELSE '' END) ELSE ";
			
		
		$sql2if = substr($sqlSomatorio,0,strlen($sqlSomatorio)-18).$sqlSomatorioComPenultimoExercicio.substr($sqlAnosConcat,0,strlen($sqlAnosConcat)-7).$sqlAnosConcatPenultimoExercicio;
		
		//segunda condição do SELECT (anos anteriores + penúltimo ano + último ano)
		$sqlSomatorioComUltimoExercicio = " + CASE WHEN 
			(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$numerocolunas-1].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$numerocolunas-3]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-2].
			" NOT LIKE '%Exigib%') THEN dat.".$arrayexercicios[$numerocolunas-3]." ELSE 0 END) > 1943.59) THEN ";
		
		$sqlAnosConcatUltimoExercicio = " CASE WHEN 
			(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$numerocolunas-1].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$numerocolunas-3]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-2]."
			NOT LIKE '%Exigib%') THEN '".$arrayexercicios[$numerocolunas-3]."/' ELSE '' END) ELSE ";
		
		$sql3if = substr($sqlSomatorio,0,strlen($sqlSomatorio)-18).substr($sqlSomatorioComPenultimoExercicio,0,strlen($sqlSomatorioComPenultimoExercicio)-18).$sqlSomatorioComUltimoExercicio.substr($sqlAnosConcat,0,strlen($sqlAnosConcat)-7).substr($sqlAnosConcatPenultimoExercicio,0,strlen($sqlAnosConcatPenultimoExercicio)-7).",".$sqlAnosConcatUltimoExercicio."'VALOR INFIMO' END) END) END) AS ANOSREMESSA ,";
		
		$sql1ifSoma = $sqlSomatorio." ( ".substr($sqlSomatorio, 13, -17)." ELSE ";
		$sql2ifSoma = substr($sqlSomatorio,0,strlen($sqlSomatorio)-18).$sqlSomatorioComPenultimoExercicio."(".substr($sqlSomatorio,13,strlen($sqlSomatorio)-31).substr($sqlSomatorioComPenultimoExercicio, 0, -18).") ELSE ";
		$sql3ifSoma = substr($sqlSomatorio,0,strlen($sqlSomatorio)-18).substr($sqlSomatorioComPenultimoExercicio,0,strlen($sqlSomatorioComPenultimoExercicio)-18).$sqlSomatorioComUltimoExercicio."(".substr($sqlSomatorio,13,strlen($sqlSomatorio)-31).substr($sqlSomatorioComPenultimoExercicio, 0, -18).substr($sqlSomatorioComUltimoExercicio, 0, -18).") ELSE 0 END) END) END) AS SOMAREMESSA ";
		
		
		$sql = $sql." ".$sql1if." ".$sql2if." ".$sql3if." ".$sql1ifSoma." ".$sql2ifSoma." ".$sql3ifSoma." FROM
			`baseacompanhamento$natureza` AS dat
			WHERE
			(
			`CpfCnpjProprietário` != '' 
			AND `CpfCnpjProprietário` NOT LIKE '999.999.999-99' 
			AND `CpfCnpjProprietário` NOT LIKE '000.000.000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '00.000.000/0000-00' 
			AND `CpfCnpjProprietário` NOT LIKE '99.999.999/9999-99' 
			AND (length(`CpfCnpjProprietário`)>=14 AND length(`CpfCnpjProprietário`)<=18) 
			AND `CpfCnpjProprietário` NOT LIKE '10.377.679/0001-96'
			) 
			AND 
			(
			UPPER(`EndereçoImóvel`) NOT LIKE '% S/N %' AND 
			UPPER(`EndereçoImóvel`) NOT LIKE '% SN %' AND 
			UPPER(`EndereçoImóvel`) NOT LIKE '%CEP: 54000-000%' AND
			UPPER(`EndereçoImóvel`) NOT LIKE '%CEP: 54000000%' AND
			UPPER(`EndereçoImóvel`) NOT LIKE '%CEP: 50000000%' AND
			UPPER(`EndereçoImóvel`) NOT LIKE '%CEP: 50000-000%' AND
			UPPER(`EndereçoImóvel`) NOT LIKE '%CEP: 00000-000%' AND
			UPPER(`EndereçoImóvel`) NOT LIKE '%CEP: 00000000%' AND
			substr(EndereçoImóvel,locate(', ', EndereçoImóvel)+2,1) REGEXP'^[0-9]' AND
			substr(EndereçoImóvel,locate('Cep: ', EndereçoImóvel)+5,1) NOT LIKE '' AND
			((length(substr(EndereçoImóvel,locate('Cep: ', EndereçoImóvel)+5,9))>=8) and (length(substr(EndereçoImóvel,locate('Cep: ', EndereçoImóvel)+5,9))<=9)) AND
			UPPER(`EndereçoImóvel`) NOT LIKE '%SEM DENOMINA%' AND
			substr(EndereçoImóvel,1,1) NOT LIKE ','
			);";
		
	
	} elseif ($natureza == "Mercantildat"){
	
		$sql = "SELECT dat.`InscriçãoMercantil` AS InscricaoMercantil, ";
		$sql1if = "";
		$sql2if = "";
		$sql3if = "";
		$sql4if = "";
		$sqlSomatorio = "(CASE WHEN ((";
		$sqlAnosConcat = "CONCAT(";
		
		$numerocolunas = count($arrayexercicios);
					
		for($i=0; $i<$numerocolunas-6; $i=$i+3){
			
			//primeira condição do SELECT (anos anteriores)
			if($i<count($arrayexercicios)-9){
				$sqlSomatorio = $sqlSomatorio."CASE WHEN (TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) < 5 
				AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
				THEN dat.".$arrayexercicios[$i]." ELSE 0 END + ";
				
				$sqlAnosConcat = $sqlAnosConcat."CASE WHEN (
				TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
				THEN '".$arrayexercicios[$i]."/' ELSE '' END, ";
				
				
			}else{
				
				$sqlSomatorio = $sqlSomatorio."CASE WHEN (TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) < 5 
				AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
				THEN dat.".$arrayexercicios[$i]." ELSE 0 END) > 1943.58) THEN ";
				
				$sqlAnosConcat = $sqlAnosConcat."CASE WHEN 
				(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
				THEN '".$arrayexercicios[$i]."/' ELSE '' END) ELSE ";
				
				
			}
			
		}
		
		$sql1if = $sql1if.$sqlSomatorio.$sqlAnosConcat;
		
		//segunda condição do SELECT (anos anteriores + penúltimo ano)
		$sqlSomatorioComPenultimoExercicio = " + CASE WHEN 
			(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$numerocolunas-4].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$numerocolunas-6]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-5].
			" NOT LIKE '%Exigib%') THEN dat.".$arrayexercicios[$numerocolunas-6]." ELSE 0 END) > 1943.59) THEN ";
		
		$sqlAnosConcatPenultimoExercicio = ", CASE WHEN 
			(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$numerocolunas-4].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$numerocolunas-6]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-5]."
			NOT LIKE '%Exigib%') THEN '".$arrayexercicios[$numerocolunas-6]."/' ELSE '' END) ELSE ";
			
		
		$sql2if = substr($sqlSomatorio,0,strlen($sqlSomatorio)-18).$sqlSomatorioComPenultimoExercicio.substr($sqlAnosConcat,0,strlen($sqlAnosConcat)-7).$sqlAnosConcatPenultimoExercicio;
		
		//segunda condição do SELECT (anos anteriores + penúltimo ano + último ano)
		$sqlSomatorioComUltimoExercicio = " + CASE WHEN 
			(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$numerocolunas-1].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$numerocolunas-3]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-2].
			" NOT LIKE '%Exigib%') THEN dat.".$arrayexercicios[$numerocolunas-3]." ELSE 0 END) > 1943.59) THEN ";
		
		$sqlAnosConcatUltimoExercicio = " CASE WHEN 
			(TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$numerocolunas-1].", CURRENT_DATE()) < 5 AND dat.".$arrayexercicios[$numerocolunas-3]." <> 0 AND dat.".$arrayexercicios[$numerocolunas-2]."
			NOT LIKE '%Exigib%') THEN '".$arrayexercicios[$numerocolunas-3]."/' ELSE '' END) ELSE ";
		
		$sql3if = substr($sqlSomatorio,0,strlen($sqlSomatorio)-18).substr($sqlSomatorioComPenultimoExercicio,0,strlen($sqlSomatorioComPenultimoExercicio)-18).$sqlSomatorioComUltimoExercicio.substr($sqlAnosConcat,0,strlen($sqlAnosConcat)-7).substr($sqlAnosConcatPenultimoExercicio,0,strlen($sqlAnosConcatPenultimoExercicio)-7).",".$sqlAnosConcatUltimoExercicio."'VALOR INFIMO' END) END) END) AS ANOSREMESSA, ";
		
		$sql1ifSoma = $sqlSomatorio." ( ".substr($sqlSomatorio, 13, -17)." ELSE ";
		$sql2ifSoma = substr($sqlSomatorio,0,strlen($sqlSomatorio)-18).$sqlSomatorioComPenultimoExercicio."(".substr($sqlSomatorio,13,strlen($sqlSomatorio)-31).substr($sqlSomatorioComPenultimoExercicio, 0, -18).") ELSE ";
		$sql3ifSoma = substr($sqlSomatorio,0,strlen($sqlSomatorio)-18).substr($sqlSomatorioComPenultimoExercicio,0,strlen($sqlSomatorioComPenultimoExercicio)-18).$sqlSomatorioComUltimoExercicio."(".substr($sqlSomatorio,13,strlen($sqlSomatorio)-31).substr($sqlSomatorioComPenultimoExercicio, 0, -18).substr($sqlSomatorioComUltimoExercicio, 0, -18).") ELSE 0 END) END) END) AS SOMAREMESSA ";
		
		
		$sql = $sql." ".$sql1if." ".$sql2if." ".$sql3if." ".$sql1ifSoma." ".$sql2ifSoma." ".$sql3ifSoma." FROM
			`baseacompanhamento$natureza` AS dat
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
			) 
			AND 
			(
			UPPER(`Endereço`) NOT LIKE '% S/N %' AND 
			UPPER(`Endereço`) NOT LIKE '% SN %' AND 
			UPPER(`Endereço`) NOT LIKE '%CEP: 54000-000%' AND
			UPPER(`Endereço`) NOT LIKE '%CEP: 54000000%' AND
			UPPER(`Endereço`) NOT LIKE '%CEP: 50000000%' AND
			UPPER(`Endereço`) NOT LIKE '%CEP: 50000-000%' AND
			UPPER(`Endereço`) NOT LIKE '%CEP: 00000-000%' AND
			UPPER(`Endereço`) NOT LIKE '%CEP: 00000000%' AND
			substr(`Endereço`,locate(', ', `Endereço`)+2,1) REGEXP'^[0-9]' AND
			substr(`Endereço`,locate('Cep: ', `Endereço`)+5,1) NOT LIKE '' AND
			((length(substr(`Endereço`,locate('Cep: ', `Endereço`)+5,9))>=8) and (length(substr(`Endereço`,locate('Cep: ', `Endereço`)+5,9))<=9)) AND
			UPPER(`Endereço`) NOT LIKE '%SEM DENOMINA%' AND
			substr(`Endereço`,1,1) NOT LIKE ','
			);";
	
	}
	
	return $sql;
}

function retornaPrescritosRemessa($natureza, $arrayexercicios, $pdo){
	
	$colunasImobiliaria = "dat.InscriçãoImobiliária, dat.Sequencial, dat.CpfCnpjProprietário, dat.NomeProprietário, dat.Natureza, dat.EndereçoImóvel, dat.Regional, ";
	$colunasMercantil = "dat.InscriçãoMercantil, dat.CpfCnpj, dat.RazãoSocial, dat.Endereço, dat.Situação, dat.TipoPessoa, ";
	$numerocolunas = count($arrayexercicios);
	$sqlPrescricaoAno = "";
	$sqlSomaPrescritos = "";
	
	if($natureza == "Imobiliáriadat"){
		
		$sql = "SELECT ".$colunasImobiliaria;
		
	}elseif($natureza == "Mercantildat"){
		
		$sql = "SELECT ".$colunasMercantil;
		
	}
			
	for($i=0; $i<$numerocolunas; $i=$i+3){
			
		$sqlPrescricaoAno = $sqlPrescricaoAno."CASE WHEN (TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) >= 5 
		AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
		THEN dat.".$arrayexercicios[$i]." ELSE 0 END AS PRESCRICAO_".$arrayexercicios[$i]." , ";
		
		$sqlSomaPrescritos = $sqlSomaPrescritos."CASE WHEN (TIMESTAMPDIFF(YEAR , dat.".$arrayexercicios[$i+2].", CURRENT_DATE()) >= 5 
		AND dat.".$arrayexercicios[$i]." <> 0 AND dat.".$arrayexercicios[$i+1]." NOT LIKE '%Exigib%') 
		THEN dat.".$arrayexercicios[$i]." ELSE 0 END + ";
		
	}
		
	$sql = $sql.$sqlPrescricaoAno." ( ".substr($sqlSomaPrescritos,0,-2)." ) AS SOMA FROM `baseacompanhamento".$natureza."` AS dat;";
	
	return $sql;
}	

function criarViewRemessaPrecrita($select, $natureza, $pdo){
	if($natureza == "Mercantildat"){
		$criarview = "CREATE OR REPLACE VIEW view_remessaprescrita_MercDAT AS ".$select;
	}elseif($natureza == "Imobiliáriadat"){
		$criarview = "CREATE OR REPLACE VIEW view_remessaprescrita_ImobDAT AS ".$select;
	}
	
	$view = $pdo->query($criarview);
	$view->execute();
}


function selectCountRemessaPrecrita($natureza, $pdo){
	
	if($natureza == "Mercantildat"){
		$sql = "SELECT COUNT(*) FROM view_remessaprescrita_MercDAT WHERE SOMA <> 0";
	}elseif($natureza == "Imobiliáriadat"){
		$sql = "SELECT COUNT(*) FROM view_remessaprescrita_ImobDAT WHERE SOMA <> 0";
	}
	
	$select = $pdo->query($sql);
	$select->execute();
	return $select->fetchAll(PDO::FETCH_NUM);
	
}

function selectSumRemessaPrecrita($natureza, $pdo){
	
	if($natureza == "Mercantildat"){
		$sql = "SELECT ROUND(SUM(SOMA),2) AS TOTAL FROM view_remessaprescrita_MercDAT WHERE SOMA <> 0";
	}elseif($natureza == "Imobiliáriadat"){
		$sql = "SELECT ROUND(SUM(SOMA),2) AS TOTAL FROM view_remessaprescrita_ImobDAT WHERE SOMA <> 0";
	}
	
	$select = $pdo->query($sql);
	$select->execute();
	return $select->fetchAll(PDO::FETCH_NUM);
}

function selectCabecalhoViewRemessaPrescrita($natureza, $pdo){
	
	if($natureza == "Mercantildat"){
		$sql = "show COLUMNS FROM view_remessaprescrita_mercDAT";
		
	}elseif($natureza == "Imobiliáriadat"){
		$sql = "show COLUMNS FROM view_remessaprescrita_imobDAT";
	}
	
	$buscar = $pdo->prepare($sql);
	$buscar->execute();
	return $buscar->fetchAll(PDO::FETCH_NUM);
}


function selectTudoViewRemessaPrescrita($natureza, $pdo){
	
	if($natureza == "Mercantildat"){
		$sql = "SELECT * FROM view_remessaprescrita_mercDAT WHERE SOMA <> 0";
	}elseif($natureza == "Imobiliáriadat"){
		$sql = "SELECT * FROM view_remessaprescrita_imobDAT WHERE SOMA <> 0";
	}
	
	$select = $pdo->query($sql);
	$select->execute();
	return $select->fetchAll(PDO::FETCH_NUM);
}


function retornaProblemasCadastroRemessa($natureza){
	
	if($natureza == "Imobiliáriadat"){
		
		$sql = "SELECT 
				dat.`InscriçãoImobiliária`, dat.Sequencial, dat.`CpfCnpjProprietário`, dat.`NomeProprietário`, dat.Natureza, dat.`EndereçoImóvel`, 
				dat.Regional, dat.`EndereçoCorrespondência`, dat.`E-mailProprietário`, dat.`TelefoneProprietário`
				FROM
				`baseacompanhamentoimobiliáriadat` AS dat
				WHERE

				`CpfCnpjProprietário` LIKE '999.999.999-99' 
				OR `CpfCnpjProprietário` LIKE '000.000.000-00' 
				OR `CpfCnpjProprietário` LIKE '00.000.000/0000-00' 
				OR `CpfCnpjProprietário` LIKE '99.999.999/9999-99' 
				OR `CpfCnpjProprietário` LIKE ''
				OR `CpfCnpjProprietário` LIKE '10.377.679/0001-96'
				OR length(`CpfCnpjProprietário`)<14 
				OR length(`CpfCnpjProprietário`)>18
				OR 
				UPPER(`EndereçoImóvel`) LIKE '% S/N %' OR 
				UPPER(`EndereçoImóvel`) LIKE '% SN %' OR 
				UPPER(`EndereçoImóvel`) LIKE '%CEP: 54000-000%' OR
				UPPER(`EndereçoImóvel`) LIKE '%CEP: 54000000%' OR
				UPPER(`EndereçoImóvel`) LIKE '%CEP: 50000000%' OR
				UPPER(`EndereçoImóvel`) LIKE '%CEP: 50000-000%' OR
				UPPER(`EndereçoImóvel`) LIKE '%CEP: 00000-000%' OR
				UPPER(`EndereçoImóvel`) LIKE '%CEP: 00000000%' OR
				substr(EndereçoImóvel,locate(', ', EndereçoImóvel)+2,1) NOT REGEXP'^[0-9]' OR
				substr(EndereçoImóvel,locate('Cep: ', EndereçoImóvel)+5,1) LIKE '' OR
				(length(substr(EndereçoImóvel,locate('Cep: ', EndereçoImóvel)+5,9))<8) OR 
				(length(substr(EndereçoImóvel,locate('Cep: ', EndereçoImóvel)+5,15))>9) OR
				UPPER(`EndereçoImóvel`) LIKE '%SEM DENOMINA%' OR
				substr(EndereçoImóvel,1,1) LIKE ','";
		
	}elseif($natureza == "Mercantildat"){
		
		$sql = "SELECT 
				dat.`InscriçãoMercantil`,
				dat.CpfCnpj,
				dat.`RazãoSocial`,
				dat.`Endereço`,
				dat.`Situação`,
				dat.TipoPessoa,
				dat.`E-mail`,
				dat.Telefone
				FROM
				baseacompanhamentomercantildat AS dat
				WHERE

				CpfCnpj LIKE '999.999.999-99' 
				OR CpfCnpj LIKE '000.000.000-00' 
				OR CpfCnpj LIKE '00.000.000/0000-00' 
				OR CpfCnpj LIKE '99.999.999/9999-99' 
				OR CpfCnpj LIKE ''
				OR CpfCnpj LIKE '10.377.679/0001-96'
				OR length(CpfCnpj)<14 
				OR length(CpfCnpj)>18
				OR 
				UPPER(`Endereço`) LIKE '% S/N %' OR 
				UPPER(`Endereço`) LIKE '% SN %' OR 
				UPPER(`Endereço`) LIKE '%CEP: 54000-000%' OR
				UPPER(`Endereço`) LIKE '%CEP: 54000000%' OR
				UPPER(`Endereço`) LIKE '%CEP: 50000000%' OR
				UPPER(`Endereço`) LIKE '%CEP: 50000-000%' OR
				UPPER(`Endereço`) LIKE '%CEP: 00000-000%' OR
				UPPER(`Endereço`) LIKE '%CEP: 00000000%' OR
				substr(Endereço,locate(', ', Endereço)+2,1) NOT REGEXP'^[0-9]' OR
				substr(Endereço,locate('Cep: ', Endereço)+5,1) LIKE '' OR
				(length(substr(Endereço,locate('Cep: ', Endereço)+5,9))<8) OR 
				(length(substr(Endereço,locate('Cep: ', Endereço)+5,15))>9) OR
				UPPER(`Endereço`) LIKE '%SEM DENOMINA%' OR
				substr(Endereço,1,1) LIKE ','";
		
	}
	
	return $sql;
}	

function criarViewProblemasCadastroRemessa($select, $natureza, $pdo){
	if($natureza == "Mercantildat"){
		$criarview = "CREATE OR REPLACE VIEW view_ProblemasCadastroRemessa_MercDAT AS ".$select;
	}elseif($natureza == "Imobiliáriadat"){
		$criarview = "CREATE OR REPLACE VIEW view_ProblemasCadastroRemessa_ImobDAT AS ".$select;
	}
	
	$view = $pdo->query($criarview);
	$view->execute();
}


function selectCountProblemasCadastroRemessa($natureza, $pdo){
	
	if($natureza == "Mercantildat"){
		$sql = "SELECT COUNT(*) FROM view_ProblemasCadastroRemessa_MercDAT";
	}elseif($natureza == "Imobiliáriadat"){
		$sql = "SELECT COUNT(*) FROM view_ProblemasCadastroRemessa_ImobDAT";
	}
	
	$select = $pdo->query($sql);
	$select->execute();
	return $select->fetchAll(PDO::FETCH_NUM);
	
}

function selectSumProblemasCadastroRemessa($natureza, $pdo){
	
	if($natureza == "Mercantildat"){
		$sql = "SELECT ROUND(SUM(SOMA),2) AS TOTAL FROM view_ProblemasCadastroRemessa_MercDAT";
	}elseif($natureza == "Imobiliáriadat"){
		$sql = "SELECT ROUND(SUM(SOMA),2) AS TOTAL FROM view_ProblemasCadastroRemessa_ImobDAT";
	}
	
	$select = $pdo->query($sql);
	$select->execute();
	return $select->fetchAll(PDO::FETCH_NUM);
}





	
?>