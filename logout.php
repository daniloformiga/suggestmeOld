<?php

require_once('facebook-php-sdk/src/facebook.php');

$facebook = new Facebook(array('appId'  => '379200745559167', 'secret' => 'b48715ce89081c9c1f36e2d6ea9938f7', 'cookie' => true));
$facebook->destroySession();
header('location: index.php');

?>