<?php
error_reporting(0);
$uamjson = file_get_contents("uam.json");
$uam = json_decode($uamjson, true);

$ip = $_SERVER["REMOTE_ADDR"];

function ban($ip) {
// Make the ban from here ip address variable: $ip
die("banned");
}

if(empty(trim($_COOKIE["nn-uam-id"]))) {

if(isset($_POST["nn-post"])) {
if(empty(trim($_POST["rand"] and $_GET["nn-uam-id"]))) { ban($ip); exit; }

$uamjson = file_get_contents("uam.json");
$uam = json_decode($uamjson, true);

if($uam[$ip][$_GET["nn-uam-id"]]["activation"]!="1") {
ban($ip); exit;
}

$getRand = $_COOKIE[$uam[$ip][$_GET["nn-uam-id"]]["challange-rand"]];

if($getRand!=$_POST["rand"]) {
    ban($ip); exit;
}

$date_s = date("d.m.Y H:i:s");

if($uam[$ip][$_GET["nn-uam-id"]]["5-seconds"]!=$date_s) {
$addoneseconds = date($uam[$ip][$_GET["nn-uam-id"]]["5-seconds"], strtotime('+1 seconds'));
} elseif($addoneseconds!=$date_s) {
    echo 'ney';
    ban($ip); exit;
}

$uam[$ip][$_GET["nn-uam-id"]]["js-challange"] = "1";
$uam_encode = json_encode($uam);
file_put_contents("uam.json", $uam_encode);
setcookie("nn-uam-id", $_GET["nn-uam-id"]);
setcookie($uam[$ip][$_GET["nn-uam-id"]]["challange-rand"], "");
header("Refresh:0;");
exit;
}

if(isset($_GET["nnval"])) {
    if(empty(trim($_GET["nnval"]))) {
        exit;
}

if(strstr($_SERVER["REQUEST_URI"], $_SERVER["HTTP_REFERER"])) { 
    ban($ip); exit;
}

$nnval = $_GET["nnval"];

$activation = explode("|", $uam[$ip][$nnval]["activation"]);

$date = date("d.m.Y");

if(empty(trim($uam[$ip][$nnval]["challange-rand"]))) {
ban($ip);
exit;
} 

if($activation[0]=="1") {
ban($ip);
exit;
}

if($activation[1]==$date) {

} else {
exit;
}

$uam[$ip][$nnval]["activation"] = "1";
$uam_encode = json_encode($uam);
file_put_contents("uam.json", $uam_encode);
exit;
}

$rand = rand(1,90000);

$client = md5(sha1($_SERVER["REMOTE_ADDR"].rand(1,90000)));

$seconds = date("d.m.Y H:i:s");
if(empty(trim($uam[$ip]["request-seconds"]))) {
    $requestseconds = "1|".$seconds;
} else {
    $reqex = explode("|", $uam[$ip]["request-seconds"]);
    if($seconds==$reqex[1]) {
    if($reqex[0]=="30") {
    ban($ip);
    } elseif($reqex[0]>30) {
    ban($ip);
    } else {
    $requestseconds = $reqex[0]+1;
    }
    }
}

$uam[$ip]["request-seconds"] = $requestseconds."|".$seconds;
$uam[$ip][$client]["activation"] = "0|".date("d.m.Y");
$uam[$ip][$client]["user-agent"] = $_SERVER["HTTP_USER_AGENT"];
$uam[$ip][$client]["5-seconds"] = date("d.m.Y H:i:s", strtotime('+5 seconds'));
$uam[$ip][$client]["challange-rand"] = $rand;
$uam[$ip][$client]["js-challange"] = "0";


$uam_encode = json_encode($uam);
file_put_contents("uam.json", $uam_encode);

setcookie($rand, md5($rand));
?>
<html>
<head>
<title>NNUAM - Under Attack Mode</title>
<style type="text/css">body {text-align:center;}</style>
</head>
<body>
<img src="https://1.bp.blogspot.com/-DdJhpwGyffo/XojT0YHHxnI/AAAAAAAABA0/AYc7AvPzpIQPEehGZ_wna6wuPs8EGT9hQCPcBGAYYCw/s1600/J31lly.png">
<form action="?nn-uam-id=<?php echo $client ?>" method="POST">
<input type="hidden" name="rand">
<input type="submit" style="display:none;" name="nn-post">
</form>
<script type="text/javascript">
document.getElementsByTagName("input")[0].setAttribute("value", "<?php echo md5($rand) ?>");
var nnval = document.createElement("img");
nnval.style = "display:none;";
nnval.src = "?nnval="+document.getElementsByTagName("form")[0].getAttribute("action").split("?nn-uam-id=")[1];
document.getElementsByTagName("body")[0].appendChild(nnval);
setTimeout(function(){ document.getElementsByTagName("input")[1].click(); }, 3000);
</script>
<?php
exit;
} else {
if($uam[$ip][$_COOKIE["nn-uam-id"]]["js-challange"]!="1") {
    setcookie("nn-uam-id", "");
}
}
?>
<!-- write your code here -->
github.com/v4r1able
