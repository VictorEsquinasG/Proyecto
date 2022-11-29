
<?php
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;

$rutaPDF = "index.html";

$mipdf = new Dompdf();
# Definimos el tamaño y orientación del papel que queremos.
# O por defecto cogerá el que está en el fichero de configuración.
$mipdf->setPaper("A4", "portrait");
# Cargamos el contenido HTML.
# $mipdf->loadHtml($html);
$mipdf->getOptions()->setChroot("C:\\xampp\\htdocs\\dompdf\\");
$mipdf->loadHtmlFile($rutaPDF);

# Renderizamos el documento PDF.
$mipdf->render();

// # Creamos un fichero
// $pdf = $mipdf->output();
// $filename = "HeavenTicket.pdf";
// file_put_contents($filename, $pdf);

$array = [];
$array['compress'] = 1;
$array['Attachment'] = 0;

# Enviamos el fichero PDF al navegador.
$mipdf->stream($rutaPDF, $array);
?>
