<?php
require_once('../vendor/autoload.php');

use Smalot\PdfParser\Parser;

// Verificar si se envió un archivo y si no hay errores
if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
    // Obtener la ruta temporal del archivo cargado
    $pdfPath = $_FILES['pdf_file']['tmp_name'];

    // Instanciar el parser de PDF
    $parser = new Parser();

    // Extraer texto de todas las páginas
    $pdf = $parser->parseFile($pdfPath);
    $texto = '';
    foreach ($pdf->getPages() as $page) {
        $texto .= $page->getText();
    }

    // Insertar $texto en la base de datos
    // Ejemplo: $query = "INSERT INTO tabla (columna) VALUES ('$texto')";
    // Ejecutar la consulta SQL aquí...

    echo "Texto extraído del PDF y guardado en la base de datos.";
} else {
    // Manejar el caso en que no se envió ningún archivo o hay un error
    echo "Se produjo un error al cargar el archivo PDF.";
}   