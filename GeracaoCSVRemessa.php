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
	
}elseif($tipoacao == "RemessaAnaliseRemessaValidoUm"){
	gerarCSVAnaliseRemessaValidoUm($natureza, $pdo);
	
}elseif($tipoacao == "RemessaAnaliseRemessaBrancoDois"){
	gerarCSVAnaliseRemessaBrancoDois($natureza, $pdo);
	
}elseif($tipoacao == "RemessaAnaliseRemessaInvalidoDois"){
	gerarCSVAnaliseRemessaInvalidoDois($natureza, $pdo);
	
}elseif($tipoacao == "NaoRemeterUltimosDoisAnos"){
	gerarCSVNaoRemeterUltimosDoisAnos($natureza, $pdo);
	
}elseif($tipoacao == "NaoRemeterValorInfimo"){
	gerarCSVNaoRemeterValorInfimo($natureza, $pdo);
	
}elseif($tipoacao == "NaoRemeterAtvEncerrada"){
	gerarCSVNaoRemeterAtvEncerrada($natureza, $pdo);
	
}elseif($tipoacao == "NaoRemeterPrescritos"){
	gerarCSVNaoRemeterPrescritos($natureza, $pdo);
	
}elseif($tipoacao == "NaoRemeterExigSuspensa"){
	gerarCSVNaoRemeterExigSuspensa($natureza, $pdo);
	
}elseif($tipoacao == "CnpjPrefNaoPrescrito"){
	gerarCSVCnpjPrefNaoPrescrito($natureza, $pdo);
	
}elseif($tipoacao == "CnpjPrefPrescrito"){
	gerarCSVCnpjPrefPrescrito($natureza, $pdo);
	
}elseif($tipoacao == "CnpjPrefExigSuspensa"){
	gerarCSVCnpjPrefExigSuspensa($natureza, $pdo);
	
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

function gerarCSVAnaliseRemessaValidoUm($natureza, $pdo){
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantildat"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", "SOMA_NAOPRESCRITO", "ANOS_NAOPRESCRITO", "CDA_NAOPRESCRITO"), ";"); 
		
	}elseif ($natureza == "Imobiliáriadat"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", "SOMA_NAOPRESCRITO", "ANOS_NAOPRESCRITO", "CDA_NAOPRESCRITO"), ";"); 
	}
	
	$linhas = selectViewAnaliseRemessaCPFValidoApenasNome($natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSVAnaliseRemessaBrancoDois($natureza, $pdo){
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantildat"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", "SOMA_NAOPRESCRITO", "ANOS_NAOPRESCRITO", "CDA_NAOPRESCRITO"), ";"); 
		
	}elseif ($natureza == "Imobiliáriadat"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", "SOMA_NAOPRESCRITO", "ANOS_NAOPRESCRITO", "CDA_NAOPRESCRITO"), ";"); 
	}
	
	$linhas = selectViewAnaliseRemessaCPFBrancoNomeSobrenome($natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSVAnaliseRemessaInvalidoDois($natureza, $pdo){
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantildat"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", "SOMA_NAOPRESCRITO", "ANOS_NAOPRESCRITO", "CDA_NAOPRESCRITO"), ";"); 
		
	}elseif ($natureza == "Imobiliáriadat"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", "SOMA_NAOPRESCRITO", "ANOS_NAOPRESCRITO", "CDA_NAOPRESCRITO"), ";"); 
	}
	
	$linhas = selectViewAnaliseRemessaCPFInvalidoNomeSobrenome($natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSVNaoRemeterValorInfimo($natureza, $pdo){
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantildat"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", "SOMA_INFIMO", "ANOS_INFIMO"), ";"); 
		
	}elseif ($natureza == "Imobiliáriadat"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", "SOMA_INFIMO", "ANOS_INFIMO"), ";"); 
	}
	
	$linhas = selectViewNaoRemeterValorInfimo($natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSVNaoRemeterAtvEncerrada($natureza, $pdo){
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantildat"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", "ValorTotal"), ";"); 
		
	}elseif ($natureza == "Imobiliáriadat"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", "ValorTotal"), ";"); 
	}
	
	$linhas = selectViewNaoRemeterAtivEncerrada($natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSVNaoRemeterPrescritos($natureza, $pdo){
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantildat"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", "SOMA_PRESCRITO", "ANOS_PRESCRITO", "CDA_PRESCRITO"), ";"); 
		
	}elseif ($natureza == "Imobiliáriadat"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", "SOMA_PRESCRITO", "ANOS_PRESCRITO", "CDA_PRESCRITO"), ";"); 
	}
	
	$linhas = selectViewNaoRemeterPrescritos($natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSVNaoRemeterExigSuspensa($natureza, $pdo){
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantildat"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", "SOMA_EXIGSUSP", "ANOS_EXIGSUSP", "CDA_EXIGSUSP"), ";"); 
		
	}elseif ($natureza == "Imobiliáriadat"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", "SOMA_EXIGSUSP", "ANOS_EXIGSUSP", "CDA_EXIGSUSP"), ";"); 
	}
	
	$linhas = selectViewNaoRemeterExigSuspensa($natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSVCnpjPrefNaoPrescrito($natureza, $pdo){
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantildat"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", "SOMA_NAOPRESCRITO", "ANOS_NAOPRESCRITO", "CDA_NAOPRESCRITO"), ";"); 
		
	}elseif ($natureza == "Imobiliáriadat"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", "SOMA_NAOPRESCRITO", "ANOS_NAOPRESCRITO", "CDA_NAOPRESCRITO"), ";"); 
	}
	
	$linhas = selectViewCNPJPrefNaoPrescrito($natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSVCnpjPrefPrescrito($natureza, $pdo){
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantildat"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", "SOMA_PRESCRITO", "ANOS_PRESCRITO", "CDA_PRESCRITO"), ";"); 
		
	}elseif ($natureza == "Imobiliáriadat"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", "SOMA_PRESCRITO", "ANOS_PRESCRITO", "CDA_PRESCRITO"), ";"); 
	}
	
	$linhas = selectViewCNPJPrefPrescrito($natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSVCnpjPrefExigSuspensa($natureza, $pdo){
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantildat"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", "SOMA_EXIGSUSP", "ANOS_EXIGSUSP", "CDA_EXIGSUSP"), ";"); 
		
	}elseif ($natureza == "Imobiliáriadat"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", "SOMA_EXIGSUSP", "ANOS_EXIGSUSP", "CDA_EXIGSUSP"), ";"); 
	}
	
	$linhas = selectViewCNPJPrefExigSusp($natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


?>