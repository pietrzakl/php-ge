<?php
if($_REQUEST["dupa"]=="jasiukaruzela"){

include_once("secret.php");
// First, include Requests
include('Requests-1.6.0/library/Requests.php');
// Next, make sure Requests can load internal classes
Requests::register_autoloader();


//error_reporting(0);
$im_server = "https://im.gigaset-elements.com";
$status_server ="https://status.gigaset-elements.de/api/v1/status";
$im_api["login"] ="/identity/api/v1/user/login";
$im_api["info"]="/identity/api/v1/user/info";
$cloud_server="https://api.gigaset-elements.com";
$c_api["begin"]="/api/v1/auth/openid/begin?op=gigaset_elements&return_to=https://my.gigaset-elements.com/";
$c_api["basestations"]="/api/v1/me/basestations";
$c_api["p"]="/api/v1/me/basestations/8655B3ECDAAC70BD18218FB4657A132D/endnodes/027c14fe6c/cmd";


//$t = Requests::get($status_server, array('Content-type' => 'application/x-www-form-urlencoded'));
//$t = json_decode($t->body);
//if($t->isMaintenance==false){echo "ok\n";}

$request = Requests::post($im_server.$im_api["login"], array('Content-type' => 'application/x-www-form-urlencoded'),array('email'=>$email,'password'=>$password));
$r=json_decode($request->body);
//echo $r->reefssid;
//$request =  Requests::get($im_server.$im_api["info"], array('Content-type' => 'application/x-www-form-urlencoded','Cookie'=>'reefssid='.$r->reefssid));
//var_dump($request);

$request =  Requests::get($cloud_server.$c_api["begin"], array('Content-type' => 'application/x-www-form-urlencoded','Cookie'=>'reefssid='.$r->reefssid,'Upgrade-Insecure-Requests'=>'1','User-Agent'=>'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36'));
$a=$request->cookies["usertoken"];
//echo $a->value;


$request =  Requests::get($cloud_server.$c_api["basestations"], array('Content-type' => 'application/x-www-form-urlencoded','Cookie'=>'reefssid='.$r->reefssid,'Cookie'=>'usertoken='.$a->value,'Upgrade-Insecure-Requests'=>'1','User-Agent'=>'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36'));
//var_dump($request);
$payload=array('name'=>'on');
$payload=json_encode($payload);
$request =  Requests::post($cloud_server.$c_api["p"], array('Content-type' => 'application/json','Cookie'=>'reefssid='.$r->reefssid,'Cookie'=>'usertoken='.$a->value,'Upgrade-Insecure-Requests'=>'1','User-Agent'=>'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36'),$payload);
var_dump($request->status_code);
sleep(5);
$payload=array('name'=>'off');
$payload=json_encode($payload);
$request =  Requests::post($cloud_server.$c_api["p"], array('Content-type' => 'application/json','Cookie'=>'reefssid='.$r->reefssid,'Cookie'=>'usertoken='.$a->value,'Upgrade-Insecure-Requests'=>'1','User-Agent'=>'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36'),$payload);

var_dump($request->status_code);

}
?>
