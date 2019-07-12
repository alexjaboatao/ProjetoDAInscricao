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

	$cont = count($arquivo)-1;
	$arraycabecalho = array();
	
	for ($i2=0;$i2<$cont;$i2++){
		$arraycabecalho[$i2] = $arquivo[$i2];
	}
	
	while(($arquivo1=fgetcsv($objeto, 0, ";"))!== false){
		
		$cont = count($arquivo1)-1;
		$colunas = "";
		$valores = "";
		
		for($a=0;$a<$cont;$a++){
			
			if($a!= $cont-1){
				$colunas = $colunas."`".$arraycabecalho[$a]."`,";
				$valores = $valores."'".addslashes($arquivo1[$a])."',";					
				
			}else{
				$colunas = $colunas."`".$arraycabecalho[$a]."`";
				$valores = $valores."'".addslashes($arquivo1[$a])."'";
			}
		}
		
			$insert = "insert into BaseAcompanhamento$natureza(".utf8_encode("$colunas) values ($valores)");
			$inserir = $pdo->prepare($insert);
			$inserir->execute();
	}
}


function deletarTabelaBaseAcomp($natureza, $pdo){

	$deletarTabela = "drop table BaseAcompanhamento$natureza";
	$deletarTabela = $pdo->prepare($deletarTabela);
	$deletarTabela->execute();
	echo "<script>alert('Tabela excluída!');</script>";
	
}
	
?>