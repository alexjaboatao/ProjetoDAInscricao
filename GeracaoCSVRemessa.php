<?php 

require_once "conexao.php";
require_once "crud.php";
require_once "selecionarDadosRemessa.php";

$natureza = $_POST['natureza'];
$pdo = conectar();
$tipoacao = $_POST['tipoacao'];

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

if($tipoacao == "tratadosRemessa"){
	gerarCSVtratadosRemessa($natureza, $pdo);
	
}elseif($tipoacao == "RemessaAnaliseRemessaBrancoUm"){
	gerarCSVAnaliseRemessaBrancoUm($natureza, $pdo);
	
}elseif($tipoacao == "RemessaAnaliseRemessaInvalidoUm"){
	gerarCSVRemessaAnaliseRemessaInvalidoUm($natureza, $pdo);
	
}elseif($tipoacao == "RemessaExigSuspensa"){
	gerarCSVRemessaExigSuspensa($natureza, $pdo);
	
}


function gerarCSVtratadosRemessa($natureza, $pdo){
		
		ini_set('memory_limit', '-1');
		$saida = fopen('php://output', 'w');
		
		if($natureza == "Mercantildat"){
			fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", "SOMA_NAOPRESCRITO", "ANOS_NAOPRESCRITO", "CDA_NAOPRESCRITO"), ";"); 
			
		}elseif ($natureza == "Imobiliáriadat"){
			fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", "SOMA_NAOPRESCRITO", "ANOS_NAOPRESCRITO", "CDA_NAOPRESCRITO"), ";"); 
		}
		
		$linhas = selectViewTratadosRemessa($natureza, $pdo);
		
		if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}

function gerarCSVAnaliseRemessaBrancoUm($natureza, $pdo){
	
		ini_set('memory_limit', '-1');
		$saida = fopen('php://output', 'w');
		
		if($natureza == "Mercantildat"){
			fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", "SOMA_NAOPRESCRITO", "ANOS_NAOPRESCRITO", "CDA_NAOPRESCRITO"), ";"); 
			
		}elseif ($natureza == "Imobiliáriadat"){
			fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", "SOMA_NAOPRESCRITO", "ANOS_NAOPRESCRITO", "CDA_NAOPRESCRITO"), ";"); 
		}
		
		$linhas = selectViewAnaliseRemessaCPFBrancoApenasNome($natureza, $pdo);
		
		if(!empty($linhas)){ 
			foreach ($linhas as $linha){
			
				fputcsv($saida, $linha, ';');
			
			}
		}
}

function gerarCSVRemessaAnaliseRemessaInvalidoUm($natureza, $pdo){
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantildat"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", "SOMA_NAOPRESCRITO", "ANOS_NAOPRESCRITO", "CDA_NAOPRESCRITO"), ";"); 
		
	}elseif ($natureza == "Imobiliáriadat"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", "SOMA_NAOPRESCRITO", "ANOS_NAOPRESCRITO", "CDA_NAOPRESCRITO"), ";"); 
	}
	
	$linhas = selectViewAnaliseRemessaCPFInvalidoApenasNome($natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}

function gerarCSVRemessaExigSuspensa($natureza, $pdo){
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	$cabecalho = selectCabecalhoViewRemessaExigSuspensa($natureza, $pdo);
	$arraycabecalho = array();
	for($b=0; $b<count($cabecalho); $b++){
		array_push($arraycabecalho, $cabecalho[$b][0]);
	}
	
	if($natureza == "Mercantildat"){
		fputcsv($saida, $arraycabecalho, ";"); 
		
	}elseif ($natureza == "Imobiliáriadat"){
		fputcsv($saida, $arraycabecalho, ";"); 
	}
	
	$linhas = selectTudoViewRemessaExigSuspensa($natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


?>