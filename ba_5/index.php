<html>
<head></head>

<h1>CTF-BA5</h1>
<div id="content">
<body>
FINALLY! I have a secure site! Crypto used the right way!<br>
Now that my code is perfect I've checked it into my GitHub repo so everyone can make use of it.<br/><br/>

<?php

$iv = file_get_contents('./resources/iv.txt');
$pass = file_get_contents('./resources/key.txt');

$method = 'aes-128-cbc';

function encrypt($text)
{
    return openssl_encrypt ($text, $GLOBALS['method'], $GLOBALS['pass'], true, $GLOBALS['iv']);
}

function decrypt($text)
{
    return openssl_decrypt ($text, $GLOBALS['method'], $GLOBALS['pass'], true, $GLOBALS['iv']);
}

$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$data = "userrole:guest,url:" . $url;

$encrypted_value = encrypt($data);

setcookie('debug','0',time() + (86400 * 7),'/ba_5/','',false,true);
setcookie('state',base64_encode($encrypted_value),time() + (86400 * 7),'/ba_5/','',false,true);

$enc_cookie_value = $_COOKIE['state'];

$dec_cookie_value = decrypt(base64_decode($enc_cookie_value));

if ($_COOKIE['debug'] === "1")
{
   print "Decrypted cookie: ".$dec_cookie_value."<br><br>";
}

$tempStrArry = explode(",", $dec_cookie_value);
$tempStrArry2 = explode(":", $tempStrArry[0]);
$cookie_userrole = $tempStrArry2[1];

if ($cookie_userrole === "admin")
{
    print "<br>Welcome admin user! <br><br>";
    print "The flag is: '<insertflaghere>'<br><br>";
    print "<img src='<insertimagehere>'><br>";
}
else
{
   print "You do not have access to this site!";
}
?>

</div>
</body>
</html>
