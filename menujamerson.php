
<!DOCTYPE HTML>

<html>
	<head>

		<title>Arrecadação</title>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="icon" href="imagens/graph.png">
		
		<script type="text/javascript" src="bootstrap-3.3.7-dist/js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
		
		<link href="bootstrap-3.3.7-dist/css/bootstrap-datepicker.css" rel="stylesheet"/>
		<script src="bootstrap-3.3.7-dist/js/bootstrap-datepicker.min.js"></script> 
		<script src="bootstrap-3.3.7-dist/js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>
		
		<script type="text/javascript" src="bootstrap-3.3.7-dist\js\jquery.maskmoney.min.js"></script>
		<script type="text/javascript" src="bootstrap-3.3.7-dist\js\jquery.maskedinput.min.js"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
		<script type="text/javascript" src="https://kryogenix.org/code/browser/sorttable/sorttable.js"></script>
		
		<link rel="stylesheet" href="font-awesome/css/all.css">

		
		<script>
		$(document).ready(function(){
		  $('.dropdown-submenu a.test').on("click", function(e){
			$(this).next('ul').toggle();
			e.stopPropagation();
			e.preventDefault();
		  });
		});
		</script>
		
		<style>
		.dropdown-submenu {
		  position: relative;
		}

		.dropdown-submenu .dropdown-menu {
		  top: 0;
		  left: 100%;
		  margin-top: -1px;
		}
		
		ul.nav li.dropdown-submenu:hover ul.dropdown-menu
		{ 
			display: block; 
		}
		</style>
		
		

	</head>

<body>

<style>
		
			body {
				background-color: #eee;
			}
	
	</style>

<nav class="navbar navbar-inverse navbar-fixed-top role=navigation">
  <div class="container">
    <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="sel_modulo.php" class="navbar-brand"><i class="fas fa-home"></i></a>
    </div>
	<div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
	
		<li><a href="sair.php"><i class="fas fa-file-invoice-dollar"></i>&nbsp;&nbsp;Home</a></li>
	
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-chart-line"></i>&nbsp;&nbsp;Inscrição
			<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="TelaEnviarArquivo_v2.php?tipo=Inscrição">Análise dos Débitos</a></li>
			</ul>
		</li>
	  
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-university"></i>&nbsp;&nbsp;Remessa
			<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="TelaEnviarArquivo_v2.php?tipo=Remessa">Análise das CDA em DAT</a></li>
			</ul>
		</li>
		
		
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-calculator"></i>&nbsp;&nbsp;Utilitários<span class="caret"></span></a>
			
			<ul class="dropdown-menu">
				<li><a href="atualizacao_monetaria.php">Atualização Monetária</a></li>
				<li><a href="filtro_multa_juros.php">Calcular Acréscimos</a></li>
			</ul>
		</li>
		
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-cogs"></i>&nbsp;&nbsp;Configurações
			<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="cadastrar_usuario.php">Cadastrar Usuário</a></li>
				<li><a href="exibe_usuarios.php">Exibir Usuários</a></li>
				<li><a href="alterar_senha.php">Alterar Senha</a></li>		
			</ul>
		</li>
	  
		<li><a href="sair.php"><i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Sair</a></li>
    </ul>
  </div>
  </div>
</nav>



</body>
</html>