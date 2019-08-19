<?php 

require_once "conexao.php";
require_once "crud.php";
require_once "selecionarDados.php";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

$saida = fopen('php://output', 'w');

fputcsv($saida, array('InscriçãoMercantil', 'CpfCnpj', 'RazãoSocial', 'Endereço', 'Situação', 'TipoPessoa', 'ano'));

$pdo = conectar();

$linhas = retornarProblemasCadastroCPFCNPJ("2018", "Mercantil", $pdo);

if(!empty($linhas)){ 
	foreach ($linhas as $linha){
	
		fputcsv($saida, $linha, '|');
	
	}
}

?>