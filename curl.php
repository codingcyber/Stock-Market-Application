<?php
require_once('includes/config.php');
// json response

//https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=GOOG&apikey=$key

$curl = curl_init();
$symbol = "INFY.NS";

curl_setopt_array($curl, array(
	CURLOPT_URL => "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=$symbol&apikey=$key",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 90,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET"
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if($err){
	echo "cURL Error :" . $err;
}else{
	//echo $response;
}

// convert the response to php array or object
$array = json_decode($response, true);
echo "<br><pre>";
print_r($array);
print_r($array['Time Series (Daily)']['2019-12-06']['2. high']);
echo "</pre>";


// we should get all these dates, so that we can get the days information with these dates






?>