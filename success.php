<?php
	require_once('config.php');
	
	$request_params = array
					(
					'USER' => $api_username, 
					'PWD' => $api_password, 
					'SIGNATURE' => $api_signature,
					'METHOD' => 'GetExpressCheckoutDetails',
					'VERSION' => $api_version,
					'TOKEN' => $_GET['token']
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


//-------------------------------------------------------------------------------------------------------
//final step
//------------------------------------------------------------------------------------------------------- 


$request_params = array
					(
					'USER' => $api_username, 
					'PWD' => $api_password, 
					'SIGNATURE' => $api_signature,
					'METHOD' => 'DoExpressCheckoutPayment',
					'VERSION' => $api_version,
					'TOKEN' => $_GET['token'],
					'PAYERID' => $_GET['PayerID'],
					'PAYMENTREQUEST_0_AMT' => 9,
					'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
					'PAYMENTREQUEST_0_PAYMENTREQUESTID' => 'CART286-120',
					'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'kalpesh.thakkar.sandbox@imobdevtech.com',
					'PAYMENTREQUEST_1_AMT' => 1,
					'PAYMENTREQUEST_1_CURRENCYCODE' => 'USD',
					'PAYMENTREQUEST_1_PAYMENTREQUESTID' => 'CART286-121',
					'PAYMENTREQUEST_1_SELLERPAYPALACCOUNTID' => 'kalpesh.thakkar.merchant@imobdevtech.com',
					
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
?>
