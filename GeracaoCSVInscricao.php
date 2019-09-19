<?php 

require_once "conexao.php";
require_once "crud.php";
require_once "selecionarDadosInscricao.php";

$natureza = $_POST['natureza'];
$pdo = conectar();
$tipoacao = $_POST['tipoacao'];
$exercicio = $_POST['exercicio'];


if($tipoacao == "CCDebitosSemInterrupcao"){
	gerarCSV_CCDebitosSemInterrupcao($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "CCDebitosDesparcelados"){
	gerarCSV_CCDebitosDesparcelados($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "CCDebitosRelancados"){
	gerarCSV_CCDebitosRelancados($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "AIbrancoUmNome"){
	gerarCSV_AIbrancoUmNome($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "AIinvalidoUmNome"){
	gerarCSV_AIinvalidoUmNome($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "AIvalidoUmNome"){
	gerarCSV_AIvalidoUmNome($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "AIbrancoNomeSobre"){
	gerarCSV_AIbrancoNomeSobre($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "AIinvalidoNomeSobre"){
	gerarCSV_AIinvalidoNomeSobre($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "AICDAsBaixadas"){
	gerarCSV_AICDAsBaixadas($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "PrefNaoPrescritoAcima"){
	gerarCSV_PrefNaoPrescrito($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "PrefNaoPrescritoAbaixo"){
	gerarCSV_PrefNaoPrescritoAbaixo($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "PrefPrescrito"){
	gerarCSV_PrefPrescrito($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "PrefExigSuspensa"){
	gerarCSV_PrefExigSuspensa($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "NIbrancoUmNome"){
	gerarCSV_NIbrancoUmNome($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "NIinvalidoUmNome"){
	gerarCSV_NIinvalidoUmNome($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "NIvalidoUmNome"){
	gerarCSV_NIvalidoUmNome($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "NIvalidoNomeSobre"){
	gerarCSV_NIvalidoNomeSobre($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "NIbrancoNomeSobre"){
	gerarCSV_NIbrancoNomeSobre($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "NIinvalidoNomeSobre"){
	gerarCSV_NIinvalidoNomeSobre($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "NIAtvEncerradaPrescritos"){
	gerarCSV_NIAtvEncerradaPrescritos($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "NIAtvEncerradaNaoPrescritos"){
	gerarCSV_NIAtvEncerradaNaoPrescritos($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "NIPrescritosComCDA"){
	gerarCSV_NIPrescritosComCDA($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "NIPrescritosSemCDA"){
	gerarCSV_NIPrescritosSemCDA($exercicio, $natureza, $pdo);
	
}elseif($tipoacao == "NIExigSuspensa"){
	gerarCSV_NIExigSuspensa($exercicio, $natureza, $pdo);
	
}




function gerarCSV_CCDebitosSemInterrupcao($exercicio, $natureza, $pdo){
	
	$nomeArquivo = $natureza.$exercicio."SemInterrupcao.csv";
	
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewCadastroCompletoSemInterrupcao($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
	
			fputcsv($saida, $linha, ';');
	
		}
	}
}

function gerarCSV_CCDebitosDesparcelados($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."Desparcelados.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewCadastroCompletoDesparcelado($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}

function gerarCSV_CCDebitosRelancados($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."Relancados.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewCadastroCompletoRelancado($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}

function gerarCSV_AIbrancoUmNome($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."ProblemaCadastro1.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseInscricaoCPFBrancoApenasNome($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}

function gerarCSV_AIinvalidoUmNome($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."ProblemaCadastro2.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseInscricaoCPFInvalidoApenasNome($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSV_AIvalidoUmNome($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."ProblemaCadastro3.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseInscricaoCPFValidoApenasNome($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}

function gerarCSV_AIbrancoNomeSobre($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."ProblemaCadastro4.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseInscricaoCPFBrancoNomeSobrenome($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}

function gerarCSV_AIinvalidoNomeSobre($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."ProblemaCadastro5.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseInscricaoCPFInvalidoNomeSobrenome($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSV_AICDAsBaixadas($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."AI_CDAsBaixadas.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseInscricaoCDAsBaixadas($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSV_PrefNaoPrescritoAcima($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."PrefNaoPrescritoAcima.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewCNPJPrefeituraNaoPrescritosAcimaInfimo($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSV_PrefNaoPrescritoAbaixo($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."PrefNaoPrescritoAbaixo.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewCNPJPrefeituraNaoPrescritosValorInfimo($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSV_PrefPrescrito($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."PrefPrescrito.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewCNPJPrefeituraPrescritos($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSV_PrefExigSuspensa($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."PrefExigSuspensa.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewCNPJPrefeituraExigSuspensa($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}

function gerarCSV_NIbrancoUmNome($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."NIbrancoUmNomeVI.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseNaoInscricaoCPFBrancoApenasNomeValorInfimo($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}

function gerarCSV_NIinvalidoUmNome($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."NIinvalidoUmNomeVI.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseNaoInscricaoCPFInvalidoApenasNomeValorInfimo($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}

function gerarCSV_NIvalidoUmNome($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."NIvalidoUmNomeVI.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseNaoInscricaoCPFValidoApenasNomeValorInfimo($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSV_NIvalidoNomeSobre($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."NIvalidoNomeSobreVI.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseNaoInscricaoCPFValidoNomeSobrenomeValorInfimo($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}

function gerarCSV_NIbrancoNomeSobre($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."NIbrancoNomeSobreVI.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseNaoInscricaoCPFBrancoNomeSobrenomeValorInfimo($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSV_NIinvalidoNomeSobre($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."NIinvalidoNomeSobreVI.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseNaoInscricaoCPFInvalidoNomeSobrenomeValorInfimo($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSV_NIAtvEncerradaPrescritos($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."NIAtvEncerradaPrescritos.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseNaoInscricaoAtividadeEncerradaPrescrito($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSV_NIAtvEncerradaNaoPrescritos($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."NIAtvEncerradaNaoPrescritos.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseNaoInscricaoAtividadeEncerradaNaoPrescrito($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSV_NIPrescritosComCDA($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."NIPrescritosComCDA.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseNaoInscricaoDemaisCNPJPrescritosComCDA($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSV_NIPrescritosSemCDA($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."NIPrescritosSemCDA.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseNaoInscricaoDemaisCNPJPrescritosSemCDA($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


function gerarCSV_NIExigSuspensa($exercicio, $natureza, $pdo){
		
	$nomeArquivo = $natureza.$exercicio."NIExigSuspensa.csv";

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$nomeArquivo);
	
	ini_set('memory_limit', '-1');
	$saida = fopen('php://output', 'w');
	
	if($natureza == "Mercantil"){
		fputcsv($saida, array("InscriçãoMercantil", "CpfCnpj", "RazãoSocial", "Endereço", "Situação", "TipoPessoa", $exercicio), ";"); 
					
	}elseif ($natureza == "Imobiliária"){
		fputcsv($saida, array("InscriçãoImobiliária", "Sequencial", "CpfCnpjProprietário", "NomeProprietário", "Natureza", "EndereçoImóvel", "Regional", $exercicio), ";"); 
		
	}
	
	$linhas = selectViewAnaliseNaoInscricaoExigSuspensa($exercicio, $natureza, $pdo);
	
	if(!empty($linhas)){ 
		foreach ($linhas as $linha){
		
			fputcsv($saida, $linha, ';');
		
		}
	}
}


?>