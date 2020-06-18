<?php

require __DIR__ . '/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

/*
Este ejemplo imprime un hola mundo en una impresora de tickets
en Windows.
La impresora debe estar instalada como genérica y debe estar
compartida
 */

/*
Conectamos con la impresora
 */

/*
Aquí, en lugar de "POS-58" (que es el nombre de mi impresora)
escribe el nombre de la tuya. Recuerda que debes compartirla
desde el panel de control
 */

$nombre_impresora = "POS-80";

$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
$printer->setJustification(Printer::JUSTIFY_CENTER);

$logo = EscposImage::load("Karina.jpg", false);
$printer->bitImage($logo);

/*
Imprimimos un mensaje. Podemos usar
el salto de línea o llamar muchas
veces a $printer->text()
 */
$printer->setTextSize(1, 2);
$printer->text("Calle 10 Avenida 28 Tel: 633-121-0748\n Agua Prieta Son.\n");
$printer->text("______________________________________\n");
$printer->feed();
$printer->setTextSize(1, 1);
$printer->feed();
$printer->text("No. Cliente: 24          Fecha: 23/01/2020\n");
$printer->text("Credito: 2\n");
$printer->text("Cliente: Diana Luara Lopez B.\n");
$printer->text("______________________________________\n");
$printer->text("No. pago: 4     Fecha: 23/01/2020\n");
$printer->text("Abono________________________$200\n");
$printer->text("Intereses_____________________$0.00\n");
$printer->text("Descuento_____________________$0.00\n");
$printer->text("______________________________________\n");
$printer->text("Total a pagar_________________$200.00\n");
$printer->feed();
$printer->text("Saldo actual___________$1400.00\n");
$printer->text("Proximo pago :23/02/2020\n");
$printer->feed();
$printer->setTextSize(1, 2);
$printer->text("Gracias por su preferencia\n");
$printer->text("---CUIDE SU CREDITO---");

/*
Hacemos que el papel salga. Es como
dejar muchos saltos de línea sin escribir nada
 */
$printer->feed(3);

/*
Cortamos el papel. Si nuestra impresora
no tiene soporte para ello, no generará
ningún error
 */
$printer->cut();

/*
Por medio de la impresora mandamos un pulso.
Esto es útil cuando la tenemos conectada
por ejemplo a un cajón
 */
$printer->pulse();

/*
Para imprimir realmente, tenemos que "cerrar"
la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
 */
$printer->close();
