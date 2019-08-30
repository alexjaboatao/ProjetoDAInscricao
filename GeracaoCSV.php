<?php 

require_once "conexao.php";
require_once "crud.php";
require_once "selecionarDados.php";

$natureza = $_POST['natureza'];
$pdo = conectar();
$tipoacao = $_POST['tipoacao'];

$exercicios = $_POST['matrizExercicios'];
$exercicios = substr($exercicios, 0,strlen($exercicios)-1);
$arrayExercicios = explode(",",$exercicios);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

if($tipoacao == "anosRemessa"){
	gerarCSVanosRemessa($natureza, $pdo);
	
}elseif($tipoacao == "RemessaPrescritos"){
	gerarCSVRemessaPrescrita($natureza, $pdo);
	
}elseif($tipoacao == "RemessaProblemasCadastro"){
	gerarCSVRemessaProblemasCadastro($natureza, $pdo);
	
}elseif($tipoacao == "RemessaExigSuspensa"){
	gerarCSVRemessaExigSuspensa($natureza, $pdo);
	
}


function gerarCSVanosRemessa($natureza, $pdo){
		
		ini_set('memory_limit', '-1');
		$saida = fopen('php://output', 'w');
		
		if($natureza == "Mercantildat"){
			fputcsv($saida, array("Inscrição Mercantil","Exercícios"), ";"); 
			
		}elseif ($natureza == "Imobiliáriadat"){
			fputcsv($saida, array("Sequencial","Exercícios"), ";"); 
		}
		
		$linhas = selectTudoViewDAT($natureza, $pdo);
		
		if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}

function gerarCSVRemessaPrescrita($natureza, $pdo){
	
		ini_set('memory_limit', '-1');
		$saida = fopen('php://output', 'w');
		
		$cabecalho = selectCabecalhoViewRemessaPrescrita($natureza, $pdo);
		$arraycabecalho = array();
		for($b=0; $b<count($cabecalho); $b++){
			array_push($arraycabecalho, $cabecalho[$b][0]);
		}
		
		if($natureza == "Mercantildat"){
			fputcsv($saida, $arraycabecalho, ";"); 
			
		}elseif ($natureza == "Imobiliáriadat"){
			fputcsv($saida, $arraycabecalho, ";"); 
		}
		
		$linhas = selectTudoViewRemessaPrescrita($natureza, $pdo);
		
		if(!empty($linhas)){ 
			foreach ($linhas as $linha){
			
				fputcsv($saida, $linha, ';');
			
			}
		}
}

function gerarCSVRemessaProblemasCadastro($natureza, $pdo){
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	$cabecalho = selectCabecalhoViewRemessaProblemasCadastro($natureza, $pdo);
	$arraycabecalho = array();
	for($b=0; $b<count($cabecalho); $b++){
		array_push($arraycabecalho, $cabecalho[$b][0]);
	}
	
	if($natureza == "Mercantildat"){
		fputcsv($saida, $arraycabecalho, ";"); 
		
	}elseif ($natureza == "Imobiliáriadat"){
		fputcsv($saida, $arraycabecalho, ";"); 
	}
	
	$linhas = selectTudoViewRemessaProblemasCadastro($natureza, $pdo);
	
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