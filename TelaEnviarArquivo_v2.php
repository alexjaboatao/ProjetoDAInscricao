<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Sistema de Análise da Dívida ativa</title>
</head>
<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
<script src="bootstrap-4.3.1-dist/js/bootstrap.js"></script>
<body>
<?php 
	require_once "menu.php"; 
	require_once "conexao.php";
	require_once "selecionarDadosInscricao.php";
	$tipo = $_GET["tipo"];
	
	$pdo = conectar();
	
?>
    <div class="container" align="center">
        
        <div class="card">
                  <div class="card-header"><strong>Análise dos débitos Imobiliário e Mercantil para <?php echo $tipo; ?> em Dívida Ativa</strong></div>     
                  		<div class="card-body">
                        	<div class="float-left" style="margin-left:30px;">
                                 <div class="card" style="width: 21rem;  height:13rem; ">
                                      <div class="card-header"><strong>Upload dos Arquivos</strong></div>     
                                            <div class="card-body">
                                                <form method="post" name="upload" action="tratamento_v3.php" enctype="multipart/form-data" >
                                                    <div class="form-group"> 
                                                        <div class="custom-file">
                                                            <input type="file" name="arquivo" class="custom-file-input" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04">
                                                            <label class="custom-file-label" for="inputGroupFile04">Enviar Arquivo</label>
                                                        </div>
                                                        <input type="hidden" value="<?php echo $tipo; ?>" name="tipo">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="submit" value="Enviar" class="btn btn-primary btn-lg btn-block">
                                                    </div>
                                                </form> 
                                            </div>
                                     </div>
                                 </div>
                        
                            <div class="float-left" style="margin-left:30px;">
                                 <div class="card" style="width: 40rem; height:13rem;">
                                      <div class="card-header"><strong>Base de Acompanhamento</strong></div>     
                                            <div class="card-body">
                                                <?php 
											    if($tipo == "Inscrição"){
												?>
													<form method="post" action="TelaResultadoInscricaoDA_v2.php">
														<input type="hidden" name="natureza" value="Imobiliária">
														<button type="submit" class="btn btn-primary btn-lg btn-block">Imobiliário - Inscrição</button>
													</form>
													<br>
													
													<form method="post" action="TelaResultadoInscricaoDA_v2.php">
														<input type="hidden" name="natureza" value="Mercantil">
														<button type="submit" class="btn btn-secondary btn-lg btn-block">Mercantil - Inscrição</button>
													</form>
													<br>
                                                 <?php 
												}
											   
											    if ($tipo == "Remessa"){
												     $buscarTabelaImobiliaria = buscarExercicios($pdo, "Imobiliáriadat");
											  		 foreach ($buscarTabelaImobiliaria as $tabelaImobiliaria): $tabelaImobiliaria[0]; endforeach;
													 if ($tabelaImobiliaria !== ""){
												   
											     ?>
                                                 <form method="post" action="TelaResultadoRemessaDA.php">
                                                 	<input type="hidden" name="natureza" value="Imobiliáriadat">
													<input type="hidden" name="matrizExercicios" value="<?php for($i=11; $i<count($buscarTabelaImobiliaria); $i++){echo $buscarTabelaImobiliaria[$i][0].",";}?>">
                                     				<button type="submit" class="btn btn-primary btn-lg btn-block">Imobiliário - Remessa</button>
                                                 </form>
                                                 <br>
                                                 <?php 
												 	} 
													 $buscarTabelaMercantil = buscarExercicios($pdo, "Mercantildat");
											         foreach ($buscarTabelaMercantil as $tabelaMercantil): endforeach;
											  
												 	if ($tabelaMercantil !== ""){
												 ?>
                                                 <form method="post" action="TelaResultadoRemessaDA.php">
                                                 	<input type="hidden" name="natureza" value="Mercantildat">
													<input type="hidden" name="matrizExercicios" value="<?php for($i=11; $i<count($buscarTabelaMercantil); $i++){echo $buscarTabelaMercantil[$i][0].",";}?>">
													<input type="hidden" name="tipoacao" value="anosRemessa">
                                     				<button type="submit" class="btn btn-secondary btn-lg btn-block">Mercantil - Remessa</button>
                                                 </form>
                                                 <?php 
												 	} 
												}
												 ?>
                                 			</div>	
                            	</div>
              
                  </div>
          </div>       
    	</div>
   </div>
</body>
</html>