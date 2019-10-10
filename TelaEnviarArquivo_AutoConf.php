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
                  <div class="card-header"><strong style="font-size: 19px;"><?php echo mb_strtoupper($tipo, mb_internal_encoding()); ?></strong></div>     
                  		<div class="card-body">
                        	<div class="float-left" style="margin-left:30px;">
                                 <div class="card" style="width: 21rem;  height:12rem; ">
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
                                                        <input type="submit" value="Enviar" class="btn btn-primary btn-block">
                                                    </div>
                                                </form> 
                                            </div>
                                     </div>
                                 </div>
                        
                            <div class="float-left" style="margin-left:30px;">
                                <div class="card" style="width: 40rem; height:16rem;">
									<div class="card-header"><strong>Análise dos Débitos - Base de Acompanhamento</strong></div>     
									<div class="card-body">
										<?php 
										if($tipo == "Inscrição"){
										?>
											<form method="post" action="TelaResultadoInscricaoDA_v2.php">
												<input type="hidden" name="natureza" value="Imobiliária">
												<button type="submit" class="btn btn-outline-primary btn-block">Imobiliário</button>
											</form>
											<br>
											
											<form method="post" action="TelaResultadoInscricaoDA_v2.php">
												<input type="hidden" name="natureza" value="Mercantil">
												<button type="submit" class="btn btn-outline-primary btn-block">Mercantil</button>
											</form>
											<br>
											
											<form method="post" action="#">
												<input type="hidden" name="natureza" value="AutoConf">
												<button type="submit" class="btn btn-outline-primary btn-block">Autos e Confissões</button>
											</form>
											<br>
										<?php 
										}
										   
										if ($tipo == "Remessa"){
											
										?>
											<form method="post" action="TelaResultadoRemessaDA_v2.php">
												<input type="hidden" name="natureza" value="Imobiliáriadat">
												<button type="submit" class="btn btn-outline-primary btn-block">Imobiliário</button>
											</form>
											<br>
											<form method="post" action="TelaResultadoRemessaDA_v2.php">
												<input type="hidden" name="natureza" value="Mercantildat">
												<button type="submit" class="btn btn-outline-primary btn-block">Mercantil</button>
											</form>
											<br>
											<form method="post" action="#">
												<input type="hidden" name="natureza" value="AutoConf">
												<button type="submit" class="btn btn-outline-primary btn-block">Autos e Confissões</button>
											</form>
											<br>
										<?php 
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