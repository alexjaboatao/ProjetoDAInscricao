<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Sistema de Análise da Dívida ativa</title>
</head>
<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
<script src="bootstrap-4.3.1-dist/js/bootstrap.js"></script>
<body>
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!Quero férias!!!!!!!!!!!!
<?php 
require_once "menu.php";
require_once "conexao.php";
require_once "selecionarDados.php";
	$pdo = conectar();
	$natureza = $_POST["natureza"];
	$bucarExercicio = buscarExercicio($pdo,$natureza);
	$cont = count($bucarExercicio);
	$qtdColuna = $cont ;
	$anos5 = $qtdColuna - 5;
	$array = array(
	$ex1 = substr(implode($bucarExercicio[$anos5]), 0, 4),
	$ex2 = substr(implode($bucarExercicio[$anos5 + 1]), 0, 4),
	$ex3 = substr(implode($bucarExercicio[$anos5 + 2]), 0, 4),
	$ex4 = substr(implode($bucarExercicio[$anos5 + 3]), 0, 4),
	$ex5 = substr(implode($bucarExercicio[$anos5 + 4]), 0, 4));
	
 ?>
 <div class="container">
  	<div class="card">
    	<div class="card-header" align="center">
            <h5><strong>Débitos para Inscrição em Dívida ativa <h4 style="color: #C00"><strong><?php echo $natureza; ?></strong></h4></strong></h5>
        </div>
        <div class="card-body float-left" align="center">
      		<div class="float-left">
                <div class="card" style="width: 21rem; margin-top:20px; margin-left:40%;">
                  <div class="card-header" align="center">
                    <strong>Débitos sem interrupção Prescricional</strong>
                  </div>
                            <table align="center">
                                <tr>
                                  <td width="50" align="left">
                                    <strong>
                                  	<?php 
                                            for ($i=0; $i< 5; $i++){
                                                echo $array[$i].":<br>";
                                            }
                                        ?>
                                     </strong>
                                  </td>
                                  <td width="50" align="center" >
                                          <?php 
                                                for ($i=0; $i< 5; $i++){
                                                   $qtdDebitosInscrcao = count(anosInscrever($array[$i], $natureza, $pdo));
												   echo '<a href="relacao.php?DA=S'.$array[$i].$natureza.' ">'.$qtdDebitosInscrcao.'<br></a>';
												   //testando github
												   //novo teste de marina
                                                }
                                            ?>
                                  </td>
                                </tr>
                            </table>
                       <br>
       <h6 style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Não foram considerados os débitos dos cadastros sem identificação do sujeito passivo.</h6>
                </div>  
             </div>
             <div class="float-left">
                <div class="card" style="width: 21rem; margin-top:20px; margin-left:70%; ">
                  <div class="card-header" align="center">
                    <strong>Débitos Desparcelados</strong>
                  </div>
                            <table align="center">
                                <tr>
                                  <td width="50" align="left">
                                    <strong>
                                  	<?php 
                                            for ($i=0; $i< 5; $i++){
                                                echo $array[$i].":<br>";
                                            }
                                        ?>
                                     </strong>
                                  </td>
                                  <td width="50" align="center" >
                                          <?php 
                                                for ($i=0; $i< 5; $i++){
                                                    $inscreverDesparcelado = count(anosDesparcelados($array[$i], $natureza, $pdo));

													//comentario alex
                                                   echo '<a href="relacao.php?DA=P'.$array[$i].$natureza.' ">'.$inscreverDesparcelado.'<br></a>';

                                                   echo '<a href="relacao.php?DA=P'.$array[$i].$natureza.' ">'.$inscreverDesparcelado.'<br></a>';
												   //comentario de teste marina

                                                }
                                            ?>
                                  </td>
                                </tr>
                            </table>
                             <br>
       <h6 style="font-size:9px; color:#F00; margin-left:10px;">Obs.: Não foram considerados os débitos dos cadastros sem identificação do sujeito passivo.</h6>
                  </div>
             </div>
        </div>
        </div>
</div>
  
         
<?php desconectar($pdo);?>
</body>
</html>