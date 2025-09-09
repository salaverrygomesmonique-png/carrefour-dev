<?php

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/

require 'vendor/autoload.php';

use Cielo\API30\Merchant;

use Cielo\API30\Ecommerce\Environment;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\CieloEcommerce;
use Cielo\API30\Ecommerce\Payment;
use Cielo\API30\Ecommerce\CreditCard;

use Cielo\API30\Ecommerce\Request\CieloRequestException;



// ...
// Configure o ambiente
$environment = $environment = Environment::sandbox();

// Configure seu merchant
$merchant = new Merchant('5cb9bdf7-3541-45c6-b6d6-b76020811183', 'WNSBSESTVQVQFXADPPBSCEDUCUWGHQETQNCAMGEZ');

// buscar no banco do seu sistema o Payment ID da transação Cielo pelo ID interno do seu sistema
$id_seu_sistema = $_GET['id'];
$payment_id = fgets(fopen ('transacao.txt', 'r'), 1024);

$sale = (new CieloEcommerce($merchant, $environment))->getSale($payment_id);
		
//echo $sale->getPayment()->getStatus();

if($sale->getPayment()->getStatus() == 2){
	Header("Location: retorno.php?cod=0&TID=" . $sale->getPayment()->getTid());
}else{
	Header("Location: retorno.php?cod=1&status=".$sale->getPayment()->getStatus()."&erro=".$sale->getPayment()->getReturnCode());
}
