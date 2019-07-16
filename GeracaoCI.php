<?php 

	use Dompdf\Dompdf;
	require_once 'dompdf/autoload.inc.php';
	
	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	$dataatual = strftime('%d de %B de %Y', strtotime('today'));
	
	$conteudoCI = "
		<html>
		 <head>
		   <style ='text/css'>
			 body {
			   font-family: Arial, Calibri, DejaVu Sans;
			   margin-top:-20px;
			   margin-right:10px;
			   margin-left:25px;
			   margin-bottom:-30px;
			   padding: 0;
			   border: none;
			 }
			 
			 p {
			  text-indent: 2em;
			  margin-top: 1,5em;
			  line-height: 150%;
			  }
		 
			 #formatacaoCabecalho {
			   font-family: Times New Roman, Arial, Calibri, DejaVu Sans;
			   width: 100%;
			   height: auto;
			   text-align: center;
			   font-size: 14px;
			   color: #696969;
			   line-height: 120%;
			 }
			
		 
			 #formatacaoDestinatario {
			   width: 100%;
			   height: auto;
			   text-align: left;
			   font-size: 14px;
			   font-weight: bold;
			   color: #000;
			   line-height: 120%;
			 }
		 
			 #formatacaoTitulo {
			   width: 100%;
			   height: auto;
			   text-align: left;
			   font-size: 14px;
			   color: #000;
			 }
			 
			 #formatacaoTexto {
			   width: 100%;
			   height: auto;
			   text-align: justify;
			   font-size: 14px;
			   color: #000;
			 }
			 
			 #formatacaoRodape{
			   text-align: center;
			   font-size: 14px;
			   color: #696969; 
			 }
			 
		   </style>
		 </head>
		 <body>
		   
		   <div id='formatacaoCabecalho'>
			   <center>
				 <img src='img/logoPrefeitura.jpg' alt='logo prefeitura' width=95 height=110><br />
				 <div style='margin-top:8px'>
					 <b>Secretaria Municipal de Planejamento e Fazenda<br />
					 Secretaria Executiva da Receita<br /></b>
					 Gerência de Tributos Imobiliários, Arrecadação e Dívida Ativa - GTIAD<br /><br /><br />
				 </div>
				 
			   </center>
		   </div>
		   
		   <b style='text-align: left'>CI nº 087/2019 – GTIAD/CADA</b>
		   <p style='text-align: right; font-size: 15px;'>Jaboatão dos Guararapes, </p>
		   <?php
		   echo $dataatual;
		   ?>
		   
		   <div id='formatacaoDestinatario'>
			 A(o) Sr(a).<br />
			 Destinatario<br />
			 Cargo Destinatario<br /><br /><br />
		   </div>
		   
		   <div id='formatacaoTitulo'>
			 <b>Assunto: </b>
			 Confirmação sobre a notificação dos débitos imobiliários lançados reatroativamente<br />
		   </div>
		   
		   <div id='formatacaoTexto'>
			 <p>Prezado(a) Sr(a). Luciana,<br/></p>
			 <p>Cumprimentando-a cordialmente, servimo-nos da oportunidade para solicitar a confirmação quanto a 
			notificação dos débitos mercantis lançados retroativamente que se encontram no arquivo que segue em anexo no e-mail com assunto 
			“Confirmação de notificações” enviado em 10/06/2019. Necessitamos desta confirmação para realizar as inscrições em Dívida Ativa.
			</p>
			
			<p>Sem mais para o momento, reitero os protestos de estima e consideração.</p><br />
			
			<center>Atenciosamente,<br/><br/><br/><br/><br/></center>
			
			<center>
				<b>Alexsandro Nunes Viana</b><br/>
				Coordenador de Arrecadação e Dívida Ativa<br/>
				Mat. 15.374-5<br/>
			</center>
			<br />
			<br />
			<br />
			<br />
			<br />
		   </div>
		   
		   <footer id='formatacaoRodape'>

			    PREFEITURA MUNICIPAL DO JABOATÃO DOS GUARARAPES<br />
				Av Barreto De Menezes, 1648 – Prazeres- Jaboatão dos Guararapes – PE.<br />
				CEP: 54.330-900 – Fone: (81) 33782519 - CNPJ: 10.377.679/0001-96
		   </footer>
		   
		 </body>
		 </html>";
	
	$dompdf = new DOMPDF();

	$dompdf->load_html($conteudoCI);

	$dompdf->render();
	
	$dompdf->stream("CI LancamentosRetroativos", array("Attachment" => false));
	
	
	
	function gerarCIProblemasCadastroCPFCNPJ(){
		
		$dompdf = new DOMPDF();

		$dompdf->load_html('
		
			<h1>Gerando PDF</h1>
		
		');

		$dompdf->render();
		
		$dompdf->stream("CI ProblemasCadastroCPFCNPJ", array("Attachment" => false));
			
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
		
		$dompdf->stream("CI LancamentosRetroativos", array("Attachment" => false));
	}


?>