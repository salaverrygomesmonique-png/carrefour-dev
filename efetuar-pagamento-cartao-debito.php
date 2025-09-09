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

// Crie uma instância de Sale informando o ID do pedido na loja
$id_interno = 123;
$sale = new Sale($id_interno);

// Crie uma instância de Customer informando o nome do cliente
$customer = $sale->customer($_POST['firstName'] . ' ' . $_POST['lastName']);

// Crie uma instância de Payment informando o valor do pagamento
$payment = $sale->payment((int) ($_POST['total'] . '00'));

$payment->setCapture(1);

$payment->setAuthenticate(1);
$payment->setReturnUrl('https://localhost/projeto-Aylton-Inacio/cursos/integracao-php-api-cielo/curso-ecommerce-cielo/verificar-status.php?id='.$id_interno);

$payment->debitCard($_POST['cc-cvv'], $_POST['cc-flag'])
        ->setExpirationDate($_POST['cc-expiration'])
        ->setCardNumber($_POST['cc-number'])
        ->setHolder($_POST['firstName'] . ' ' . $_POST['lastName']);		

// Crie o pagamento na Cielo
try {
    // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
    $sale = (new CieloEcommerce($merchant, $environment))->createSale($sale);

    // Gravar no seu banco de dados o payment ID
    $paymentId = $sale->getPayment()->getPaymentId();
	$fp = fopen("transacao.txt", "w");
	$escreve = fwrite($fp, $paymentId);
	fclose($fp);
	
	/*echo $sale->getPayment()->getStatus();
	echo "-";
	echo $sale->getPayment()->getReturnCode();
	echo "<pre>";
	print_r($sale->getPayment());
	die()*/
	
	
	Header("Location: " . $sale->getPayment()->getAuthenticationUrl());

} catch (CieloRequestException $e) {
	
	Header("Location: retorno.php?cod=2&erro=" . $e->getCieloError()->getCode());
}