<?php 

	use Dompdf\Dompdf;
	require_once 'dompdf/autoload.inc.php';
	
	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	$dataatual = strftime('%d de %B de %Y', strtotime('today'));
	$nci = $_POST['nCI'];
	$destinatario = $_POST['destinatario'];
	$cargo = $_POST['cargo'];
	$natureza = $_POST['natureza'];
	
	$conteudoCI = "
		<html>
		 <head>
		   <style ='text/css'>
			 body {
			   font-family: Arial, Calibri, DejaVu Sans;
			   margin-top:auto;
			   margin-right:20px;
			   margin-left:30px;
			   margin-bottom:auto;
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
			   font-size: 12px;
			   color: #696969;
			   line-height: 120%;
			 }
			
		 
			 #formatacaoDestinatario {
			   width: 100%;
			   height: auto;
			   text-align: left;
			   font-size: 13px;
			   font-weight: bold;
			   color: #000;
			   line-height: 120%;
			 }
		 
			 #formatacaoTitulo {
			   width: 100%;
			   height: auto;
			   text-align: left;
			   font-size: 13px;
			   color: #000;
			 }
			 
			 #formatacaoTexto {
			   width: 100%;
			   height: auto;
			   text-align: justify;
			   font-size: 13px;
			   color: #000;
			 }
			 
			 #footer {
				position: fixed;
				bottom: 40px;
				width: 100%;
				text-align: center;
				border-top: 1px solid gray;
				font-size: 11px;
			 }
			 
		   </style>
		 </head>
		 <body>
		   
		   <div id='formatacaoCabecalho'>
			   <center>
				 <img src='img/logoPrefeitura.jpg' alt='logo prefeitura' width=85 height=100><br />
				 <div style='margin-top:8px'>
					 <b>Secretaria Municipal de Planejamento e Fazenda<br />
					 Secretaria Executiva da Receita<br /></b>
					 Gerência de Tributos Imobiliários, Arrecadação e Dívida Ativa - GTIAD<br /><br /><br />
				 </div>
				 
			   </center>
		   </div>
		   
		   <b style='text-align: left; font-size: 14px;'>CI nº {$nci} – GTIAD/CADA</b>
		   <p style='text-align: right; font-size: 13px;'>Jaboatão dos Guararapes, {$dataatual} </p>
		   
		   <div id='formatacaoDestinatario'>
			 A(o) Sr(a).<br />
			 {$destinatario}<br />
			 {$cargo}<br /><br /><br />
		   </div>
		   
		   <div id='formatacaoTitulo'>
			 <b>Assunto: </b>
			 Confirmação sobre a notificação dos débitos de natureza {$natureza} lançados reatroativamente<br />
		   </div>
		   
		   <div id='formatacaoTexto'>
			 <p>Prezado(a) {$destinatario},<br/></p>
			 <p>Cumprimentando-o(a) cordialmente, servimo-nos da oportunidade para solicitar a confirmação quanto a 
			notificação dos débitos de natureza {$natureza} lançados retroativamente que se encontram no arquivo que segue em anexo no e-mail com assunto 
			“Confirmação de notificações” enviado em {$dataatual}. Necessitamos desta confirmação para realizar as inscrições em Dívida Ativa.
			</p>
			
			<p>Sem mais para o momento, reitero os protestos de estima e consideração.</p><br />
			
			<center>Atenciosamente,<br/><br/><br/><br/><br/><br/><br/></center>
			
			<center>
				<b>Alexsandro Nunes Viana</b><br/>
				Coordenador de Arrecadação e Dívida Ativa<br/>
				Mat. 15.374-5<br/>
			</center>
			
		   </div>
		   
		   <div id='footer'>
				<h>
					PREFEITURA MUNICIPAL DO JABOATÃO DOS GUARARAPES<br />
					Av Barreto De Menezes, 1648 – Prazeres- Jaboatão dos Guararapes – PE.<br />
					CEP: 54.330-900 – Fone: (81) 33782519 - CNPJ: 10.377.679/0001-96
				</h>
			</div>
		   
		 </body>
		 </html>";
	
	$dompdf = new DOMPDF();

	$dompdf->load_html($conteudoCI);
	
	$dompdf->set_paper("a4", "portrait");

	$dompdf->render();
	
	$dompdf->stream("CI LancamentosRetroativos", array("Attachment" => false));

?>