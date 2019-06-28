<?php

function conectar(){
try{
	$opcoes = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
);
	$pdo = new PDO('mysql:host=localhost;dbname=projetoda',"root","", $opcoes);
	
	}catch(PDOException $e){
		echo $e->getMessage();
		}
		return $pdo;
}

function desconectar($pdo){
	$pdo = NULL;
}


?>