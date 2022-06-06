<?php
/*
* import checksum generation utility
* You can get this utility from https://developer.paytm.com/docs/checksum/
*/
require_once("./PaytmChecksum.php");

// $paytmParams = array();
$paytmParams["body"] = array(
    "requestType" => "Payment",
    "mid" => "lGfrjN75479275496908",
    "websiteName" => "WEBSTAGING",
    "orderId" => "ORDERID_987684",
    "callbackUrl" => "localhost",
    "requestType" => "Payment",
    "txnAmount" => array(
        "value" => "1.00",
        "currency" => "INR",
    ),
    "userInfo" => array(
        "custId" => "CUST_001",
    ),
);



/*
* Generate checksum by parameters we have in body
* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
*/
$checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "KiDQHq0_RYf%zKK5");

$paytmParams["head"] = array(
    "signature" => $checksum
);


$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

/* for Staging */
$url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=lGfrjN75479275496908&orderId=ORDERID_987684";

/* for Production */
// $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=YOUR_MID_HERE&orderId=ORDERID_98765";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
$response = curl_exec($ch);

$res = json_decode($response, true);
print_r($res); // $res["body"]["txnToken"];
echo strval($res["body"]["txnToken"]);
?>

<?php
$paytmParams = array();
$paytmParams["head"] = array(
"tokenType" => "TXN_TOKEN",
'token'     => $res["body"]["txnToken"]
);
$paytmParams["body"] = array(
"mid" => "lGfrjN75479275496908"
);
/* prepare JSON string for request */
$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
/* for Staging */
$url = "https://securegw-stage.paytm.in/theia/api/v2/fetchPaymentOptions?mid=lGfrjN75479275496908&orderId=ORDERID_987684";

/* for Production */
//$url = "https://securegw.paytm.in/theia/api/v2/fetchPaymentOptions?mid=YOUR_MID_HERE&orderId=ORDERID_98765";


$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
$response = curl_exec($ch);
print_r($response);          

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="post" type="redirect" action="https://securegw-stage.paytm.in/theia/api/v1/processTransaction?mid=INTEGR7769XXXXXX9383&orderId=ORDERID_98765">
    <input type="text" name="mid"  value="lGfrjN75479275496908" />
    <input type="text" name="orderId"  value="ORDERID_987684" />
    <input type="text" name="txnToken"  value="<?php echo $res["body"]["txnToken"] ?> " />
    <input type="text" name="paymentMode"  value="UPI" />
    <input type="text" name="payerAccount"  value="9130992368@paytm" />
    <input type="submit">
</form> 
</body>
</html>