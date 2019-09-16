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
		$arrayexerciciosEDados = buscarColunasExercicosEDados($pdo, $natureza);
		
		$select = selectGerarViewInscricao($natureza, $arrayexerciciosEDados);
		criarViewInscricao($select, $natureza, $pdo);
		
			
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
                  	<h6>Critérios:</h6>
                           <ul>
                            <li>Com CPF Válido</li>
                            <li>Com Nome e pelo menos um Sobrenome</li>
                            <li>Débitos Não Prescritos</li>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Soma dos Débitos acima do Valor Ínfimo</li>
                            <li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
                           </ul>
                  </div>
               </div>
           </div>
           <div class="float-left" style="margin-left:1%;">
               <div class="card" style="width: 21rem; margin-top:20px;">
                  <h6 class="card-header">Débitos<br> Desparcelados</h6>
                  <div class="card-body" align="left" style="font-size:11px;">
                   	<h6>Critérios:</h6>
                           <ul>
                            <li>Com CPF Válido</li>
                            <li>Com Nome e pelo menos um Sobrenome</li>
                            <li>Débitos Não Prescritos</li>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Soma dos Débitos acima do Valor Ínfimo</li>
                            <li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
                           </ul>
                  </div>
               </div>
           </div>
           <div class="float-left" style="margin-left:1%;">
               <div class="card" style="width: 21rem; margin-top:20px; font-size:12px ">
                  <h6 class="card-header">Débitos <br>Relançados</h6>
                  <div class="card-body" align="left" style="font-size:11px;">
                 		<h6>Critérios:</h6>
                           <ul>
                            <li>Com CPF Válido</li>
                            <li>Com Nome e pelo menos um Sobrenome</li>
                            <li>Débitos Não Prescritos</li>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Soma dos Débitos acima do Valor Ínfimo</li>
                            <li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
                           </ul>
                  </div>
               </div>
           </div>
           
         </div>
         <div align="center">
            <form action="TelaResultadosCadastroCompletoEAN.php" method="post">
            	<input type="hidden" name="natureza" value="<?php echo $natureza; ?>">
                <button type="submit" class="btn btn-primary btn-lg btn-block" style="width:50%;">Consultar Resultados</button>
            </form>
        </div>
        <br>
     </div>  
        
</div>  
<br>
 <div class="container">
 		    
  	<div class="card">
    	<div class="card-header" align="center">
            <h5><strong>Análise para Inscrição</strong></h4></strong></h5>
        </div>
         <div class="card-body" align="center">
           <div class="float-left" style="margin-left:2%">
               <div class="card" style="width: 21rem; margin-top:20px;">
                 <a href="#"> <h6 class="card-header">CPF/CNPJ em Branco +<br> Apenas 1 Nome</h6></a>
                  <div class="card-body" align="left" style="font-size:11px;">
                  	<h6>Critérios:</h6>
                           <ul>
                            <li>Débitos Não Prescritos</li>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Soma dos Débitos acima do Valor Ínfimo</li>
                            <li>Situação Diferente a Ativ. Encerrada (Mercantil)</li>
                           </ul>
                  </div>
               </div>
           </div>
           <div class="float-left" style="margin-left:1%;">
               <div class="card" style="width: 21rem; margin-top:20px;">
                  <a href="#"><h6 class="card-header">CPF/CNPJ Inválido +<br> Apenas 1 Nome</h6></a>
                  <div class="card-body" align="left" style="font-size:11px;">
                   	<h6>Critérios:</h6>
                          <ul>
                            <li>Débitos Não Prescritos</li>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Soma dos Débitos acima do Valor Ínfimo</li>
                            <li>Situação Diferente a Ativ. Encerrada (Mercantil)</li>
                           </ul>
                  </div>
               </div>
           </div>
           <div class="float-left" style="margin-left:1%;">
               <div class="card" style="width: 21rem; margin-top:20px; font-size:12px ">
                 <a href="#"> <h6 class="card-header">CPF/CNPJ Válido +<br> Apenas 1 Nome</h6></a>
                  <div class="card-body" align="left" style="font-size:11px;">
                 		<h6>Critérios:</h6>
                           <ul>
                            <li>Débitos Não Prescritos</li>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Soma dos Débitos acima do Valor Ínfimo</li>
                            <li>Situação Diferente a Ativ. Encerrada (Mercantil)</li>
                            <li>Excluído o CNPJ da Prefeitura</li>
                           </ul>
                  </div>
               </div>
           </div>
           <div class="float-left" style="margin-left:2%">
               <div class="card" style="width: 21rem; margin-top:20px;">
                  <a href="#"><h6 class="card-header">CPF/CNPJ em Branco +<br> Nome e Sobrenome</h6></a>
                  <div class="card-body" align="left" style="font-size:11px;">
                  	<h6>Critérios:</h6>
                           <ul>
                            <li>Débitos Não Prescritos</li>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Soma dos Débitos acima do Valor Ínfimo</li>
                            <li>Situação Diferente a Ativ. Encerrada (Mercantil)</li>
                           </ul>
                  </div>
               </div>
           </div>
           <div class="float-left" style="margin-left:1%;">
               <div class="card" style="width: 21rem; margin-top:20px;">
                  <a href="#"><h6 class="card-header">CPF/CNPJ Inválido +<br> Nome e Sobrenome</h6></a>
                  <div class="card-body" align="left" style="font-size:11px;">
                   	<h6>Critérios:</h6>
                           <ul>
                            <li>Débitos Não Prescritos</li>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Soma dos Débitos acima do Valor Ínfimo</li>
                            <li>Situação Diferente a Ativ. Encerrada (Mercantil)</li>
                           </ul>
                  </div>
               </div>
           </div>
           <div class="float-left" style="margin-left:1%;">
               <div class="card" style="width: 21rem; margin-top:20px; font-size:12px ">
                  <a href="#"><h6 class="card-header">CDA's <br>Baixadas</h6></a>
                  <div class="card-body" align="left" style="font-size:11px;">
                 		<h6>Critérios:</h6>
                          <ul>
                            <li>Débitos Não Prescritos</li>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Soma dos Débitos acima do Valor Ínfimo</li>
                            <li>Situação Diferente a Ativ. Encerrada (Mercantil)</li>
                            <li>Excluído o CNPJ da Prefeitura</li>
                           </ul>
                  </div>
               </div>
           </div>

         </div>
         <div align="center">
            <form action="TelaResultadosAnaliseInscricoesEAN.php" method="post">
              	<input type="hidden" name="natureza" value="<?php echo $natureza; ?>">
                <button type="submit" class="btn btn-primary btn-lg btn-block" style="width:50%;">Consultar Resultados</button>
            </form>
        </div>
        <br>
     </div>  
        
</div> 
<br>
 <div class="container">
 		   
  	<div class="card">
    	<div class="card-header" align="center">
            <h5><strong>Análise para Não Inscrição</strong></h4></strong></h5>
        </div>
         <div class="card-body" align="center">
           <div class="float-left" style="margin-left:2.4%">
               <div class="card" style="width: 15rem; margin-top:20px;">
                  <a href="#"><h6 class="card-header">Débitos abaixo do Valor Ínfimo</h6></a>
                  <div class="card-body" align="left" style="font-size:11px;">
                  	<h6>Critérios:</h6>
                           <ul>
                            <li>Débitos Não Prescritos</li>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Soma dos Débitos abaixo do Valor Ínfimo</li>
                            <li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
                           </ul>
                  </div>
               </div>
           </div>
           <div class="float-left" style="margin-left:1.7%;">
               <div class="card" style="width: 15rem; margin-top:20px;">
                  <a href="#"><h6 class="card-header">CMC com ATIVIDADE ENCERRADA com Débitos</h6></a>
                  <div class="card-body" align="left" style="font-size:11px;">
                   	<h6>Critérios:</h6>
                           <ul>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
                           </ul>
                           <br><br><br>
                  </div>
               </div>
           </div>
           <div class="float-left" style="margin-left:1.7%;">
               <div class="card" style="width: 15rem; margin-top:20px; font-size:12px ">
                  <a href="#"><h6 class="card-header">Débitos Passíveis de Prescrição</h6></a>
                  <div class="card-body" align="left" style="font-size:11px;">
                 		<h6>Critérios:</h6>
                           <ul>
                            <li>Débitos Prescritos</li>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
                           </ul>
                           <br><br>
                  </div>
               </div>
           </div>
           <div class="float-left" style="margin-left:1.7%;">
               <div class="card" style="width: 15rem; margin-top:20px; font-size:12px ">
                  <a href="#"><h6 class="card-header">Débitos com Exigibilidade Suspensa</h6></a>
                  <div class="card-body" align="left" style="font-size:11px;">
                 		<h6>Critérios:</h6>
                           <ul>
                            <li>Débitos Com Suspensão de Exigibilidade</li>
                           </ul>
                           <br><br><br><br><br>
                  </div>
               </div>
           </div>

         </div>
        <div align="center">
            <form action="TelaResultadoInscricoesEAN.php">
                <button type="button" class="btn btn-primary btn-lg btn-block" style="width:50%;">Consultar Resultados</button>
            </form>
        </div>
        <br>
     </div>  
        
</div> 
<br>
 <div class="container">
 		   
  	<div class="card">
    	<div class="card-header" align="center">
            <h5><strong>Débitos Lançados CNPJ da Prefeitura</strong></h4></strong></h5>
        </div>
         <div class="card-body" align="center">
           <div class="float-left" style="margin-left:2%">
               <div class="card" style="width: 15rem; margin-top:20px;">
                  <a href="#"><h6 class="card-header">Débitos Não Prescrito Acima do Ínfimo</h6></a>
                  <div class="card-body" align="left" style="font-size:11px;">
                  	<h6>Critérios:</h6>
                    	   <ul>
                            <li>Débitos Não Prescritos</li>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Soma dos Débitos acima do Valor Ínfimo</li>
                            <li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
                           </ul>
                  </div>
               </div>
           </div>
           <div class="float-left" style="margin-left:1%;">
               <div class="card" style="width: 15rem; margin-top:20px;">
                  <a href="#"><h6 class="card-header">Débitos Não Prescritos Abaixo do valor Ínfimo</h6></a>
                  <div class="card-body" align="left" style="font-size:11px;">
                   	<h6>Critérios:</h6>
                            <ul>
                            <li>Débitos Não Prescritos</li>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Soma dos Débitos abaixo do Valor Ínfimo</li>
                            <li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
                           </ul>
                  </div>
               </div>
           </div>
           <div class="float-left" style="margin-left:1%;">
               <div class="card" style="width: 15rem; margin-top:20px; font-size:12px ">
                  <a href="#"><h6 class="card-header">Débitos <br>Prescritos</h6></a>
                  <div class="card-body" align="left" style="font-size:11px;">
                 		<h6>Critérios:</h6>
                           <ul>
                            <li>Débitos Prescritos</li>
                            <li>Débitos Sem Suspensão de Exigibilidade</li>
                            <li>Situação Diferente de Ativ. Encerrada (Mercantil)</li>
                           </ul>
                           <br><br>
                  </div>
               </div>
           </div>
           <div class="float-left" style="margin-left:1%;">
               <div class="card" style="width: 15rem; margin-top:20px; font-size:12px ">
                  <a href="#"><h6 class="card-header">Débitos Com Exigibilidade Suspensa</h6></a>
                  <div class="card-body" align="left" style="font-size:11px;">
                 		<h6>Critérios:</h6>
                           <ul>
                            <li>Débitos Com Suspensão de Exigibilidade</li>
                           </ul>
                           <br><br><br><br><br>
                  </div>
               </div>
           </div>

         </div>
         <div align="center">
            <form action="TelaResultadoInscricoesEAN.php">
                <button type="button" class="btn btn-primary btn-lg btn-block" style="width:50%;">Consultar Resultados</button>
            </form>
        </div>
        <br>
     </div>  
        
</div> 
<br>
</html>