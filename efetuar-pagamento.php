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
$merchant = new Merchant('', '');

// Crie uma instância de Sale informando o ID do pedido na loja
$sale = new Sale('123');

// Crie uma instância de Customer informando o nome do cliente
$customer = $sale->customer($_POST['firstName'] . ' ' . $_POST['lastName']);

// Crie uma instância de Payment informando o valor do pagamento
$payment = $sale->payment((int) ($_POST['total'] . '00'));

$payment->setCapture(1);

// Crie uma instância de Credit Card utilizando os dados de teste
// esses dados estão disponíveis no manual de integração
$payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
        ->creditCard($_POST['cc-cvv'], $_POST['cc-flag'])
        ->setExpirationDate($_POST['cc-expiration'])
        ->setCardNumber($_POST['cc-number'])  
        ->setHolder($_POST['firstName'] . ' ' . $_POST['lastName']);

// Crie o pagamento na Cielo
try {
    // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
    $sale = (new CieloEcommerce($merchant, $environment))->createSale($sale);

    // Com a venda criada na Cielo, já temos o ID do pagamento, TID e demais
    // dados retornados pela Cielo
    $paymentId = $sale->getPayment()->getPaymentId();

	echo $sale->getPayment()->getStatus();
	echo "-";
	echo $sale->getPayment()->getReturnCode();
	echo "<pre>";
	print_r($sale->getPayment());
	
	if($sale->getPayment()->getStatus() == 2){
		Header("Location: retorno.php?cod=0&TID=" . $sale->getPayment()->getTid());
	}else{
		Header("Location: retorno.php?cod=1&status=".$sale->getPayment()->getStatus()."&erro=".$sale->getPayment()->getReturnCode());
	}
	
    // Com o ID do pagamento, podemos fazer sua captura, se ela não tiver sido capturada ainda
    //$sale = (new CieloEcommerce($merchant, $environment))->captureSale($paymentId, 15700, 0);

    // E também podemos fazer seu cancelamento, se for o caso
    //$sale = (new CieloEcommerce($merchant, $environment))->cancelSale($paymentId, 15700);
} catch (CieloRequestException $e) {
    // Em caso de erros de integração, podemos tratar o erro aqui.
    // os códigos de erro estão todos disponíveis no manual de integração.
    //print_r($e->getCieloError());
	//$erro = $e->getCieloError()->getMessage() . "-" . $e->getCieloError()->getCode();
	//echo $erro; die();
	//echo $e->getCieloError()->code . $e->getCieloError()->message;
	Header("Location: retorno.php?cod=2&erro=" . $e->getCieloError()->getCode());
}