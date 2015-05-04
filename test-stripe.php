<?php 

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

require_once('stripe/init.php');

// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("");

// Get the credit card details submitted by the form
$token = $request->stripeToken;

// Create the charge on Stripe's servers - this will charge the user's card
try {
$charge = \Stripe\Charge::create(array(
  "amount" => $request->amount, // amount in cents, again
  "currency" => "eur",
  "source" => $token,
  "description" => "Example charge")
);
} catch(Exception $e) {
	echo $e->getMessage();
}

echo $postdata;

?>