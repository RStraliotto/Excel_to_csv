<!--**
 * @author Cesar Szpak - Celke -   cesar@celke.com.br
 * @pagina desenvolvida usando framework bootstrap,
 * o código é aberto e o uso é free,
 * porém lembre -se de conceder os créditos ao desenvolvedor.
 *-->
 <?php
	session_start();

	require_once('inc/seguranca.php');
include("inc/class_mysql.php");
$mysql = new MySQL();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Contato</title>
	<head>
	<body>
		<?php
		// Definimos o nome do arquivo que será exportado
		$arquivo = 'relatorio.xls';
		
		// Criamos uma tabela HTML com o formato da planilha
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="5">Planilha Mensagem de Contatos</tr>';
		$html .= '</tr>';
		
		
		$html .= '<tr>';
		$html .= '<td><b>ID</b></td>';
		$html .= '<td><b>Fornecedor</b></td>';
		$html .= '<td><b>Nome do Software</b></td>';
		$html .= '<td><b>Versão</b></td>';
		$html .= '<td><b>Licença</b></td>';
		$html .= '<td><b>Data Venc</b></td>';
		$html .= '<td><b>Contrato</b></td>';
		$html .= '<td><b>NºNF</b></td>';
		$html .= '</tr>';
		
		
		//Selecionar tos itens da tabela 
		$result_relatorio = "SELECT f.nome as nomefor,p.status,p.id,p.nome,p.versao,l.idlicenca,l.licenca,l.venc,c.nro,c.nrofatura FROM fornecedor f LEFT JOIN produto p ON f.idfornecedor = p.fornecedor JOIN licenca l on p.id = l.idproduto join contratos c on l.contrato = c.idcontratos;";
		$resultado_relatorio = mysqli_query($conn , $result_relatorio);
		
		while($row_relatorio = mysqli_fetch_assoc($resultado_relatorio)){
			$html .= '<tr>';
			$html .= '<td>'.$row_relatorio["nome"].'</td>';
			$html .= '<td>'.$row_relatorio["versao"].'</td>';
			$html .= '<td>'.$row_relatorio["licenca"].'</td>';
			$html .= '<td>'.$row_relatorio["venc"].'</td>';
			$html .= '<td>'.$row_relatorio["nro"].'</td>';
			$html .= '<td>'.$row_relatorio["nrofatura"].'</td>';
			$data = date('d/m/Y H:i:s',strtotime($row_relatorio["created"]));
			$html .= '<td>'.$data.'</td>';
			$html .= '</tr>';
			;
		}
		// Configurações header para forçar o download
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
		// Envia o conteúdo do arquivo
		echo $html;
		exit; ?>
	</body>
</html>