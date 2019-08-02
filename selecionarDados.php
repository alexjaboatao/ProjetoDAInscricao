<?php 
require_once "conexao.php";

//bla bla teste

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
	
?>