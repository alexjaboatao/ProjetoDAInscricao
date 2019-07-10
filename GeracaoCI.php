<?php 

	use Dompdf\Dompdf;
	require_once 'dompdf/autoload.inc.php';
	
	$conteudoCI = "
		<html>
		 <head>
		   <style ='text/css'>
			 body {
			   font-family: Calibri, DejaVu Sans, Arial;
			   margin: 0;
			   padding: 0;
			   border: none;
			   font-size: 13px;
			 }
		 
			 #exemplo {
			   width: 100%;
			   height: auto;
			   overflow: hidden;
			   padding: 5px 0;
			   text-align: center;
			   background-color: #CCC;
			   color: #FFF;
			 }
		   </style>
		 </head>
		 <body>
		   <div id='exemplo'>
			 Gerar PDF com a classe DOMPDF para PHP.<br />
		   </div>
		 </body>
		 </html>";
	
	$dompdf = new DOMPDF();

	$dompdf->load_html($conteudoCI);

	$dompdf->render();
	
	$dompdf->stream("CI LancamentosRetroativos", array("Attachment => false"));
	
	
	
	function gerarCIProblemasCadastroCPFCNPJ(){
		
		$dompdf = new DOMPDF();

		$dompdf->load_html('
		
			<h1>Gerando PDF</h1>
		
		');

		$dompdf->render();
		
		$dompdf->stream("CI ProblemasCadastroCPFCNPJ", array("Attachment => false"));
			
	}
	
	function gerarCILancadosCNPJPrefeitura(){
		
		$dompdf = new DOMPDF();

		$dompdf->load_html('
		
			<h1>Gerando PDF</h1>
		
		');

		$dompdf->render();
		
		$dompdf->stream("CI LancadosCNPJPrefeitura", array("Attachment => false"));
		
	}
	
	function gerarCILancamentosRetroativos($numeroCI, $destinatário, $cargodestinatario){
		
		$dompdf = new DOMPDF();

		$dompdf->load_html('
		
			<h1>Assunto: Confirmação sobre a notificação dos débitos mercantis lançados reatroativamente<br><br></h1>
			
			<p>Prezada Sra. Luciana,<br>Cumprimentando-a cordialmente, servimo-nos da oportunidade para solicitar a confirmação quanto a 
			notificação dos débitos mercantis lançados retroativamente que se encontram no arquivo que segue em anexo no e-mail com assunto 
			“Confirmação de notificações” enviado em 10/06/2019. Necessitamos desta confirmação para realizar as inscrições em Dívida Ativa.
			</p>
		
		');

		$dompdf->render();
		
		$dompdf->stream("CI LancamentosRetroativos", array("Attachment => false"));
	}


?>