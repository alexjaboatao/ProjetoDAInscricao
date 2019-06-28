<?php 
require_once "conexao.php";

function criarTabelaBaseAcomp($arquivo, $natureza, $pdo){
	$primeira = "CREATE TABLE BaseAcompanhamento".$natureza."(";
	$cont = count($arquivo)- 1;

	$segunda = "";
		for ($i=0;$i<$cont;$i++){
			
			if($natureza == "Imobiliária"){
				
				$segunda = $segunda."`".$arquivo[$i]."` varchar(255) NOT NULL,";	

			}elseif($natureza == "Mercantil"){
				$segunda = $segunda."`".$arquivo[$i]."` varchar(255) NOT NULL,";	
				}			
		}

		$segunda = $segunda." PRIMARY KEY ($arquivo[0])";
		$consulta = $primeira.utf8_encode($segunda).")";
		$criarTabela = $pdo->prepare($consulta);
		$criarTabela->execute();
	   echo "<script>alert('Tabela criada com sucesso!');</script>" ;
	}
	
function incluirDadosBaseAcomp($arquivo, $natureza, $objeto, $pdo){

	$colunas = "";
	$cont = count($arquivo)-1;
	for ($i2=0;$i2<$cont;$i2++){
	
		if($natureza == "Imobiliária"){
			
			if($i2!= $cont-1){
				$colunas = $colunas."`$arquivo[$i2]`,";				
				
			}else{
				$colunas = $colunas."`$arquivo[$i2]`";
			}

		}elseif($natureza == "Mercantil"){
		
		
			if($i2!= $cont-1){
				$colunas = $colunas."`$arquivo[$i2]`,";				
				
			}else{
				$colunas = $colunas."`$arquivo[$i2]`";
			}				
			
		}
	}
	
	while(($arquivo1=fgetcsv($objeto, 0, ";"))!== false){
	
		$cont1 = count($arquivo1);
		$valores = "";
		for($a=0;$a<$cont1;$a++){
				if($a!= $cont1-1){
					$valores = $valores."'".$arquivo1[$a]."',";					
					
				}else{
					$valores = $valores."'".$arquivo1[$a]."'";
				}
				
			}
			
			$insert = "insert into BaseAcompanhamento$natureza(".utf8_encode("$colunas) values ($valores)");
			$inserir = $pdo->prepare($insert);
			$inserir->execute();
	}								
	echo "<script>window.location='enviarArquivo.php';alert('Inclusão dos dados com sucesso!');</script>" ;
	
		
}


function deletarTabelaBaseAcomp($natureza, $pdo){

	$deletarTabela = "drop table BaseAcompanhamento$natureza";
	$deletarTabela = $pdo->prepare($deletarTabela);
	$deletarTabela->execute();
	echo "<script>alert('Tabela excluída!');</script>";
	
}
	
?>