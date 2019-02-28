<?php


use Dompdf\Dompdf;
ob_start();

$imagen = 'imagenes/logo/'.$empresa->getImagen();

echo "<img src='".$imagen."' border='0' height='50' align='left'>"; 
echo "Calle Palleter 62 bajo izq. (46008) Valencia<br>";
echo 'Telf: 622 207 130 - 963 235 287<br><br>';

?>

   <style type="text/css">
        @page {
            margin: 0;
        }
        * { padding: 0; margin: 5; }
        @font-face {
            font-family: "source_sans_proregular";           
            src: local("Source Sans Pro"), url("fonts/sourcesans/sourcesanspro-regular-webfont.ttf") format("truetype");
            font-weight: normal;
            font-style: normal;

        }        
        body{
            font-family: "source_sans_proregular", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;            
        }
    </style>
</head><body><hr>
    <table  width=100%><tr>
        <th style="text-align: left;" width="20%"> Albarán: 
            <?php  
            // cabecera del albarán
            echo $albaran->getId(); 
            ?></th>

        <th style="text-align: left;" width="20%"> Fecha: 
 <?php           
            // cabecera del albarán
            echo $albaran->getFecha()->format('d/m/Y'); 
            echo '</th><th  align="right"> Cliente  </th><td>';
            if (!is_null($albaran->getCliente())){
                echo $albaran->getCliente()->getNombre().'</td></tr>'; 
                // echo $albaran->getCliente()->getDirecciones(); 
                echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>';
                foreach ( $albaran->getCliente()->getDirecciones() as $item) {
                    if ($item->getPrincipal()==1) {
                        echo $item.'<br>';
                        echo $item->getCodigoPostal().' - '. $item->getPoblacion().'<br>';
                        echo $item->getProvincia().'<br>';
                    }


                }
                echo '</td>';
            }
            echo '</tr></table><hr><br>';

echo '<table width=100%><tr><th>Concepto</th><td align="right"><b>Cantidad</b></td><td align="right"><b>Precio</b></td><td align="right"><b>Importe</b></td></tr>';
        foreach ( $albaran->getconcepto() as $item) {
            echo "<tr style='border-bottom: 1px solid #666;'>";
            echo "<td style='border-bottom: 1px solid #666;'>";
                echo $item->getConcepto();

            echo "</td>";
            echo "<td style='border-bottom: 1px solid #666;' align='right'>";
                echo $item->getCantidad();
            echo "</td>";
            echo "<td style='border-bottom: 1px solid #666;' align='right'>";
                echo number_format($item->getPrecio(), 2, ',', ' ').' €';
            echo "</td>";            
            echo "<td style='border-bottom: 1px solid #666;' align='right'>";
                echo number_format($item->getCantidad()*$item->getPrecio(), 2, ',', ' ').' €';
            echo "</td>";            
            echo "<td style='border-bottom: 1px solid #666;' align='right'>";

            echo "</td>";  
            echo "</tr>"; 
           //  echo "<tr style='border-bottom: 1px solid #666;'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";

        }
    echo "</table>";       
    echo "<table width=100% style='border-bottom: 1px solid #666;' >";
    echo '<tr><td width=70%></td><th align="right">Base: </th><td align="right">'.number_format($albaran->getTotal(), 2, ',', ' ').' €</td></tr>';
    $IVA = (($albaran->getTotal()*$albaran->getIVA())/100);
    echo '<tr><td></td><th align="right">IVA (' .$albaran->getIVA().' %) </th><td align="right">'.number_format($IVA, 2, ',', ' ').' €</td></tr>';
    $totalAlbaran = $albaran->getTotal() +$IVA;
    echo '<tr><td></td><th align="right">Total: </th><td align="right">'.number_format($totalAlbaran, 2, ',', ' ').' €</td></tr>';
    echo '</table>';    
//generación del PDF

$dompdf = new DOMPDF(); 
$dompdf->set_paper('letter', 'portrait'); 
$dompdf->loadHtml(ob_get_clean());
$dompdf->render();
$dompdf->stream('sample.pdf', array("Attachment"=>0));

?>