<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Sistema de Análise da Dívida ativa</title>
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
	<script src="bootstrap-4.3.1-dist/js/bootstrap.js"></script>
	
	<script lang="javascript" src="js/jquery-3.4.1.min.js"></script>

</head>
<body>

	<?php 
		require_once "menu.php";
		require_once "conexao.php";
		require_once "SelecionarDadosInscricao.php";

		$pdo = conectar();
		$natureza = $_POST["natureza"];

	 ?>
<div class="container">
 		    <h5 align="center"><strong>Débitos Para Inscrição em Dívida Ativa <strong style="color: #C00"><?php echo $natureza; ?></strong></strong></h5><hr>
  	<div class="card">
    	<div class="card-header" align="center">
            <h5><strong>Inscrição - Cadastro Completo</strong></h4></strong></h5>
        </div>
         <div class="card-body" align="center">
            <div class="float-left" style="margin-left:2%">
               <div class="card" style="width: 21rem; margin-top:20px;">
                 <h6 class="card-header">Débitos<br> Sem Interrupção Prescricional</h6>
                  <div class="card-body" align="left" style="font-size:11px;">
                  			 <table >
								<tr width="80" style="font-size:12px" align="left" >
                                  <td>
									<strong>QTD de Sequenciais/CMC: <?php ?></strong>
                                  </td>
                                </tr>
                                <tr width="80" style="font-size:12px">
                                  <td>
									<strong>Valor Total da Inscrição: R$ <?php  ?></strong>
                                  </td>
                                </tr>
                            </table>
                  <hr>
                  			<table class="table table-striped" align="center">
                              <thead>
                                <tr>
                                  <th scope="col">Exercício</th>
                                  <th scope="col">Qtd Seq/CMC</th>
                                  <th scope="col">Inscrever Seq/CMC</th>
                                </tr>
                              </thead>
                              <tbody align="center">
                                <tr>
                                  <td>Mark</td>
                                  <td>Otto</td>
                                  <td>
                                  	    <form method="post" action="#">
											<input type="hidden" name="natureza" value="<?php ?>">
											<input type="hidden" name="matrizExercicios" value="<?php ?>">
											<input type="hidden" name="tipoacao" value="anosRemessa">
											<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Inscrever</button>
                                        </form>
                                   </td>
                                </tr>
                                <tr>
                                  <td>Jacob</td>
                                  <td>Thornton</td>
                                  <td><a href="#">@fat</a></td>
                                </tr>
                                <tr>
                                  <td>Larry</td>
                                  <td>the Bird</td>
                                  <td><a href="#">@twitter</a></td>
                                </tr>
                              </tbody>
                            </table>
                
                  </div>
               </div>
           </div>
           
           <div class="float-left" style="margin-left:1%;">
               <div class="card" style="width: 21rem; margin-top:20px;">
                  <h6 class="card-header">Débitos<br> Desparcelados</h6>
                  <div class="card-body" align="left" style="font-size:11px;">
                   			 <table>
								<tr width="80" style="font-size:12px">
                                  <td>
									<strong>QTD de Sequenciais/CMC: <?php ?></strong>
                                  </td>
                                </tr>
                                <tr width="80" style="font-size:12px">
                                  <td>
									<strong>Valor Total da Inscrição: R$ <?php  ?></strong>
                                  </td>
                                </tr>
                            </table>
                  <hr>
                  			<table class="table table-striped" align="center">
                              <thead>
                                <tr>
                                  <th scope="col">Exercício</th>
                                  <th scope="col">Qtd Seq/CMC</th>
                                  <th scope="col">Inscrever Seq/CMC</th>
                                </tr>
                              </thead>
                              <tbody align="center">
                                <tr>
                                  <td>Mark</td>
                                  <td>Otto</td>
                                  <td>
                                  	    <form method="post" action="#">
											<input type="hidden" name="natureza" value="<?php ?>">
											<input type="hidden" name="matrizExercicios" value="<?php ?>">
											<input type="hidden" name="tipoacao" value="anosRemessa">
											<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Inscrever</button>
                                        </form>
                                   </td>
                                </tr>
                                <tr>
                                  <td>Jacob</td>
                                  <td>Thornton</td>
                                  <td><a href="#">@fat</a></td>
                                </tr>
                                <tr>
                                  <td>Larry</td>
                                  <td>the Bird</td>
                                  <td><a href="#">@twitter</a></td>
                                </tr>
                              </tbody>
                            </table>
                  </div>
               </div>
           </div>
           
           <div class="float-left" style="margin-left:1%;">
               <div class="card" style="width: 21rem; margin-top:20px; font-size:12px ">
                  <h6 class="card-header">Débitos <br>Relançados</h6>
                  <div class="card-body" align="left" style="font-size:11px;">
                  			 <table>
								<tr width="80" style="font-size:12px">
                                  <td>
									<strong>QTD de Sequenciais/CMC: <?php ?></strong>
                                  </td>
                                </tr>
                                <tr width="80" style="font-size:12px">
                                  <td>
									<strong>Valor Total da Inscrição: R$ <?php  ?></strong>
                                  </td>
                                </tr>
                            </table>
                             <hr>
                  			<table class="table table-striped" align="center">
                              <thead>
                                <tr>
                                  <th scope="col">Exercício</th>
                                  <th scope="col">Qtd Seq/CMC</th>
                                  <th scope="col">Inscrever Seq/CMC</th>
                                </tr>
                              </thead>
                              <tbody align="center">
                                <tr>
                                  <td>Mark</td>
                                  <td>Otto</td>
                                  <td>
                                  	    <form method="post" action="#">
											<input type="hidden" name="natureza" value="<?php ?>">
											<input type="hidden" name="matrizExercicios" value="<?php ?>">
											<input type="hidden" name="tipoacao" value="anosRemessa">
											<button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size:12px">Inscrever</button>
                                        </form>
                                   </td>
                                </tr>
                                <tr>
                                  <td>Jacob</td>
                                  <td>Thornton</td>
                                  <td><a href="#">@fat</a></td>
                                </tr>
                                <tr>
                                  <td>Larry</td>
                                  <td>the Bird</td>
                                  <td><a href="#">@twitter</a></td>
                                </tr>
                              </tbody>
                            </table>
                  </div>
               </div>
           </div>
           
         </div>
    </div>
</div>
</html>