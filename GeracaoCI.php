<?php 

echo gerarCILancadosRetroativo;


function gerarCIProblemasCadstro($natureza){
	$conteudo = "Primeira linha do arquivo\n";	
	// Criando o novo arquivo
	echo file_put_contents('arquivo.txt', $conteudo); // Resultado: 26
}

function gerarCILancadosPrefeitura($natureza){
	$conteudo = "Primeira linha do arquivo\n";	
	// Criando o novo arquivo
	echo file_put_contents('arquivo.txt', $conteudo); // Resultado: 26
}

function gerarCILancadosRetroativo(){
	$conteudo = "Primeira linha do arquivo\n";	
	// Criando o novo arquivo
	echo file_put_contents('arquivo.txt', $conteudo); // Resultado: 26
}
	
?>