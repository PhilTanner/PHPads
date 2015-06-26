<?php
$bannerAdsPath = './ads.dat';
require './ads.inc.php';
///////////////////////////////////////
// Don't Edit Anything Below This Line!
///////////////////////////////////////
for ($i = 0; $i < count($ads); $i++) {
    if(preg_match('/^' .$_GET['id']. '\|\|/', $ads[$i])) {
        $data = explode('||', $ads[$i]);
	if ($_SERVER['REMOTE_ADDR'] != $bannerAds['blockip']) {
            if (trim(strlen($bannerAds['mysql_host'] . $bannerAds['mysql_username'] . $bannerAds['mysql_password'] . $bannerAds['mysql_database'] . (int)$bannerAds['mysql_port'])) > 0) {
	            $mysqli = new mysqli($bannerAds['mysql_host'], $bannerAds['mysql_username'], $bannerAds['mysql_password'], $bannerAds['mysql_database'], (int)$bannerAds['mysql_port']);
        	    if ($mysqli->connect_error) die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	            if (mysqli_connect_error()) die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        	    $mysqli->query('UPDATE `ads` SET `clickthrus`=`clickthrus`+1 WHERE `id`='.(int)$_GET['id'].' LIMIT 1;');
	            $mysqli->close();
            }
	}
        $ads[$i] = join('||', $data);
        break;
    }
}
if (!$data[PHPADS_ADELEMENT_LINK_URI]) {
    die();
}
Header("Location: ". $data[PHPADS_ADELEMENT_LINK_URI]);
exit;
?>
