<?php
use Dompdf\Dompdf;
ob_start();

$imagen = 'imagenes/logo/'.$empresa->getImagen();

echo "<img src='".$imagen."' border='0' height='50'>"; 

?>

    <table  width=100%><tr>
        <th style="text-align: left;" width="50%"> Impresión de ruta día :21/01/2019</th>
        <th style="text-align:right;" > Técnico: <?php echo $partes[0]->getTrabajador()->getNombre(); ?></th>
        </tr></table><hr><br>
<?php
echo '<table><tr><th>Entrada</th><th>Cliente</th><th>Observaciones</th><th>Direccion</th><th>Producto</th></tr>';
        foreach ( $partes as $item) {
            echo "<tr style='border-bottom: 1px solid #666;'>";
            echo "<td style='border-bottom: 1px solid #666;'>";
                echo $item->getFechaEntrada()->format('H:i');
            echo "</td>";
            echo "<td style='border-bottom: 1px solid #666;'>";
                echo $item->getCliente()->getNombre();
            echo "</td>";
            echo "<td style='border-bottom: 1px solid #666;'>";
                echo $item->getObservaciones();
            echo "</td>";            
            echo "<td style='border-bottom: 1px solid #666;'>";
                echo $item->getDireccion(). ' - '.$item->getDireccion()->getCodigoPostal(). '-'.
                    $item->getDireccion()->getPoblacion(). '-' . $item->getDireccion()->getProvincia().'<br>' ;
                echo $item->getDireccion()->getTelefono().'<br>';
                echo $item->getDireccion()->getObservaciones();
            echo "</td>";            
            echo "<td style='border-bottom: 1px solid #666;'>";
                foreach ( $item->getProducto() as $productos) {
                    echo '- '.$productos->getModelo(). '<br><i>'.$productos->getObservaciones().'</i><br>';
                }
            echo "</td>";  
            echo "</tr>"; 
           //  echo "<tr style='border-bottom: 1px solid #666;'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";

        }
    echo "</table>";       

//generate some PDFs!

$dompdf = new DOMPDF(); //if you use namespaces you may use new \DOMPDF()
$dompdf->set_paper('letter', 'landscape'); 
$dompdf->loadHtml(ob_get_clean());
$dompdf->render();
$dompdf->stream('sample.pdf', array("Attachment"=>0));

?>