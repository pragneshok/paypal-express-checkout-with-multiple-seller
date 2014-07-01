<?php
// Include config file
require_once('config.php');


// Store request params in an array
$request_params = array
					(
					'USER' => $api_username, 
					'PWD' => $api_password, 
					'SIGNATURE' => $api_signature,
					'METHOD' => 'SetExpressCheckout',
					'RETURNURL' => 'http://localhost/paycreditcard/success.php',
					'CANCELURL' => 'http://localhost/paycreditcard/cancel.php',
					'VERSION' => $api_version,
					
					'L_PAYMENTREQUEST_0_NAME0' => 'Gim gaffigum',
					'L_PAYMENTREQUEST_0_NUMBER0' => '007',
					'L_PAYMENTREQUEST_0_DESC0' => 'Gim gaffigum The movie of Love',
					'L_PAYMENTREQUEST_0_AMT0' => 9,
					'L_PAYMENTREQUEST_0_QTY0' => 1,
					'PAYMENTREQUEST_0_PAYMENTREQUESTID' => 'CART286-120',
					'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'kalpesh.thakkar.sandbox@imobdevtech.com',
					'PAYMENTREQUEST_0_ITEMAMT' => 9,
					'PAYMENTREQUEST_0_TAXAMT' => 0,
					'PAYMENTREQUEST_0_SHIPPINGAMT' => 0,
					'PAYMENTREQUEST_0_HANDLINGAMT' => 0,
					'PAYMENTREQUEST_0_SHIPDISCAMT' => 0,
					'PAYMENTREQUEST_0_INSURANCEAMT' => 0,
					'PAYMENTREQUEST_0_AMT' => 9,
					'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
					
					'L_PAYMENTREQUEST_1_NAME0' => 'Gim gaffigum',
					'L_PAYMENTREQUEST_1_NUMBER0' => '007',
					'L_PAYMENTREQUEST_1_DESC0' => 'Gim gaffigum The movie of Love',
					'L_PAYMENTREQUEST_1_AMT1' => 1,
					'L_PAYMENTREQUEST_1_QTY1' => 1,
					'PAYMENTREQUEST_1_PAYMENTREQUESTID' => 'CART286-121',
					'PAYMENTREQUEST_1_SELLERPAYPALACCOUNTID' => 'kalpesh.thakkar.merchant@imobdevtech.com',
					'PAYMENTREQUEST_1_ITEMAMT' => 1,
					'PAYMENTREQUEST_1_TAXAMT' => 0,
					'PAYMENTREQUEST_1_SHIPPINGAMT' => 0,
					'PAYMENTREQUEST_1_HANDLINGAMT' => 0,
					'PAYMENTREQUEST_1_SHIPDISCAMT' => 0,
					'PAYMENTREQUEST_1_INSURANCEAMT' => 0,
					'PAYMENTREQUEST_1_AMT' => 1,
					'PAYMENTREQUEST_1_CURRENCYCODE' => 'USD'
					);
					
// Loop through $request_params array to generate the NVP string.
$nvp_string = '';
foreach($request_params as $var=>$val)
{
	$nvp_string .= '&'.$var.'='.urlencode($val);	
}

$nvp_string = ltrim($nvp_string , '&');
//echo "<pre>";print_r($nvp_string);exit;

// Send NVP string to PayPal and store response
$curl = curl_init();
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_URL, $api_endpoint);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

$result = curl_exec($curl);
//echo $result.'<br /><br />';
curl_close($curl);

// Parse the API response
$result_array = NVPToArray($result);

echo '<pre />';
print_r($result_array);

//step - 2
$SESSION['paypal_token'] = $result_array['TOKEN'];

header("Location: https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=".$result_array['TOKEN']."");



// Function to convert NTP string to an array
function NVPToArray($NVPString)
{
	$proArray = array();
	while(strlen($NVPString))
	{
		// name
		$keypos= strpos($NVPString,'=');
		$keyval = substr($NVPString,0,$keypos);
		// value
		$valuepos = strpos($NVPString,'&') ? strpos($NVPString,'&'): strlen($NVPString);
		$valval = substr($NVPString,$keypos+1,$valuepos-$keypos-1);
		// decoding the respose
		$proArray[$keyval] = urldecode($valval);
		$NVPString = substr($NVPString,$valuepos+1,strlen($NVPString));
	}
	return $proArray;
}
