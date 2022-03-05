<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$cupos = $sala->cupos - $sala->inscriptos;
$inscriptos = $sala->inscriptos;
?>
<?php
// SDK de Mercado Pago
require __DIR__ .  '/../vendor/autoload.php';

// Agrega credenciales
MercadoPago\SDK::setAccessToken('PROD_ACCESS_TOKEN');

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

// Crea un ítem en la preferencia
$item = new MercadoPago\Item();
$item->title = 'Mi producto';
$item->quantity = 1;
$item->unit_price = 75.56;
$preference->items = array($item);
$preference->save();
?>

TEST-1532967727451503-121018-3952fbd2dc525e313f772b078b4aa368-679423245

APP_USR-1532967727451503--121018-bb6ac77e21686c0825eeda874c217ee-679423245