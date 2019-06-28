<?php 
require_once "conexao.php";
function buscarExercicio($pdo, $natureza){
	$sql = "show COLUMNS FROM baseacompanhamento$natureza";
	$buscar = $pdo->prepare($sql);
	$buscar->execute();
	return $buscar->fetchAll(PDO::FETCH_NUM);
	}
function anosInscrever($array, $natureza, $pdo){
	if ($natureza == "Imobiliária"){
	$sql = "SELECT Sequencial, `$array`, CpfCnpjProprietário FROM baseacompanhamento$natureza WHERE `$array` != '' AND 
	`$array` NOT LIKE '%-%' AND `CpfCnpjProprietário` != '' AND `CpfCnpjProprietário` NOT LIKE '%99.999.999%' AND `CpfCnpjProprietário` NOT LIKE '%00.000.000%'";
	$inscricao = $pdo->query($sql);
	$inscricao->execute();
	return $inscricao->fetchAll(PDO::FETCH_NUM);
	} elseif ($natureza == "Mercantil"){
		$sql = "SELECT InscriçãoMercantil, `$array`, CpfCnpj FROM baseacompanhamento$natureza WHERE `$array` != '' AND `$array` NOT LIKE '%-%' AND `CpfCnpj` != '' AND `CpfCnpj` NOT LIKE '%99.999.999%' AND `CpfCnpj` NOT LIKE '%00.000.000%' AND `CpfCnpj` NOT LIKE '%999.999.999%' AND `CpfCnpj` NOT LIKE '%000.000.000%'";
	$inscricao = $pdo->query($sql);
	$inscricao->execute();
	return $inscricao->fetchAll(PDO::FETCH_NUM);
		}
	}
function anosDesparcelados($array, $natureza, $pdo){
	if ($natureza == "Imobiliária"){
	$sql = "SELECT Sequencial, `$array`, CpfCnpjProprietário FROM baseacompanhamento$natureza WHERE `$array` != '' AND `$array` LIKE '%Parcelamento%' AND `CpfCnpjProprietário` != '' AND `CpfCnpjProprietário` NOT LIKE '%99.999.999%' AND `CpfCnpjProprietário` NOT LIKE '%00.000.000%'";
	$inscricao = $pdo->query($sql);
	$inscricao->execute();
	return $inscricao->fetchAll(PDO::FETCH_NUM);
	} elseif ($natureza == "Mercantil"){
		$sql = "SELECT InscriçãoMercantil, `$array`, CpfCnpj FROM baseacompanhamento$natureza WHERE `$array` != '' AND `$array` LIKE '%Parcelamento%' AND `CpfCnpj` != '' AND `CpfCnpj` NOT LIKE '%99.999.999%' AND `CpfCnpj` NOT LIKE '%00.000.000%'";
	$inscricao = $pdo->query($sql);
	$inscricao->execute();
	return $inscricao->fetchAll(PDO::FETCH_NUM);
		}
	}
	
?>