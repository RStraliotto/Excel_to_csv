<?php
// Inclua a biblioteca PHPExcel
require 'PHPExcel/PHPExcel.php';

// Caminho para o arquivo Excel de entrada
$arquivo_excel = 'caminho/para/seuarquivo.xlsx';

// Carregue o arquivo Excel
$objPHPExcel = PHPExcel_IOFactory::load($arquivo_excel);

// Obtenha as colunas do arquivo Excel
$colunas = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

// Exiba as colunas
echo '<h1>Colunas do Arquivo Excel:</h1>';
echo '<ul>';
foreach ($colunas[1] as $coluna => $valor) {
    echo '<li>' . $coluna . '</li>';
}
echo '</ul>';

// Verifique se o formulário foi enviado
if (isset($_POST['ordenar'])) {
    // Obtenha a ordem desejada das colunas do formulário
    $ordem = $_POST['ordem'];

    // Crie um novo arquivo CSV com as colunas na ordem desejada
    $novo_arquivo_csv = 'caminho/para/novoarquivo.csv';
    $arquivo = fopen($novo_arquivo_csv, 'w');

    // Escreva o cabeçalho do CSV na ordem desejada
    foreach ($ordem as $coluna) {
        fputcsv($arquivo, [$coluna]);
    }

    // Escreva os dados do Excel no CSV
    foreach ($colunas as $linha) {
        $linha_csv = [];
        foreach ($ordem as $coluna) {
            $linha_csv[] = $linha[$coluna];
        }
        fputcsv($arquivo, $linha_csv);
    }

    fclose($arquivo);

    echo '<p>Arquivo CSV gerado com sucesso: <a href="' . $novo_arquivo_csv . '">Download CSV</a></p>';
}
?>

<!-- Formulário para escolher a ordem das colunas -->
<h2>Escolha a ordem das colunas:</h2>
<form method="post">
    <ul>
        <?php foreach ($colunas[1] as $coluna => $valor) { ?>
            <li>
                <label>
                    <input type="checkbox" name="ordem[]" value="<?php echo $coluna; ?>" checked>
                    <?php echo $coluna; ?>
                </label>
            </li>
        <?php } ?>
    </ul>
    <input type="submit" name="ordenar" value="Ordenar e Salvar em CSV">
</form>
