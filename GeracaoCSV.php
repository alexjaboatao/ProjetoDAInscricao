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
	gerarCSVanosRemessa($natureza, $arrayExercicios, $pdo);
}


function gerarCSVanosRemessa($natureza, $arrayExercicios, $pdo){
	
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




?>