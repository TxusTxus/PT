<?php

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
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
</head><body>
    <table  width=100%><tr>
        <th style="text-align: left;" width="50%"> Ruta: 
            <?php 
            echo $dias[$partes[0]->getFechaParte()->format('w')].', ';  
            echo $partes[0]->getFechaParte()->format('d/m'); 
            ?></th>
        <th style="text-align:right;" > Técnico: <?php echo $partes[0]->getTrabajador()->getNombre(); ?></th>
        </tr></table><hr><br>
<?php
echo '<table width=100%><tr><th>Entrada</th><th>Cliente</th><th>Observaciones</th><th>Direccion</th><th>Producto</th></tr>';
        foreach ( $partes as $item) {
            echo "<tr style='border-bottom: 1px solid #666;'>";
            echo "<td style='border-bottom: 1px solid #666;'>";
                echo $item->getFechaEntrada()->format('H:i');
                If ($item->getTrabajador()->getId()==1) { echo '<br>Sin asignar'; }

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
                    echo '- '.$productos->getFamilia().': '.$productos->getModelo(). '<br><i>'.$productos->getObservaciones().'</i><br>';
                }
            echo "</td>";  
            echo "</tr>"; 
           //  echo "<tr style='border-bottom: 1px solid #666;'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";

        }
    echo "</table>";       

//generación del PDF

$dompdf = new DOMPDF(); 
$dompdf->set_paper('letter', 'landscape'); 
$dompdf->loadHtml(ob_get_clean());
$dompdf->render();
$dompdf->stream('sample.pdf', array("Attachment"=>0));

?>