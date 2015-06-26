<?php
$ads = array();
$bannerAds = array();
$bannerAdsTime = time();
$lines = file($bannerAdsPath) or die();

define( 'PHPADS_ADELEMENT_ID',		 0);
define( 'PHPADS_ADELEMENT_ENABLED',	 1);
define( 'PHPADS_ADELEMENT_WEIGHTING',	 2);
define( 'PHPADS_ADELEMENT_ENDDATE',	 3);
define( 'PHPADS_ADELEMENT_IMPRESSIONS',	 5);
define( 'PHPADS_ADELEMENT_REMAINING',	 4);
define( 'PHPADS_ADELEMENT_CLICKTHRUS',	 6);
define( 'PHPADS_ADELEMENT_WIDTH',	 7);
define( 'PHPADS_ADELEMENT_HEIGHT',	 8);
define( 'PHPADS_ADELEMENT_LINK_URI',	 9);
define( 'PHPADS_ADELEMENT_IMAGE_URI',	10);
define( 'PHPADS_ADELEMENT_NAME',	11);
define( 'PHPADS_ADELEMENT_STARTDATE',	12);
define( 'PHPADS_ADELEMENT_ADTYPE',	13);
define( 'PHPADS_ADELEMENT_OTHERCONTENT',14);

define( 'PHPADS_ADTYPE_IMAGE',           0);
define( 'PHPADS_ADTYPE_OTHER',           1);


foreach ($lines as $line) {
    $line = chop($line);
    if (($line != '') && (!preg_match('/^#/', $line))) {
        if (preg_match('/^[A-Za-z0-9 ]+\|\|/', $line)) {
//            $ads[] = $line;
        } else {
            list ($key, $val) = explode('=', $line);
            $bannerAds[$key] = $val;
        }
    }
}
function readads() {
	global $bannerAds,$ads;
	if (trim(strlen($bannerAds['mysql_host'] . $bannerAds['mysql_username'] . $bannerAds['mysql_password'] . $bannerAds['mysql_database'] . (int)$bannerAds['mysql_port'])) > 0) {

		$mysqli = new mysqli($bannerAds['mysql_host'], $bannerAds['mysql_username'], $bannerAds['mysql_password'], $bannerAds['mysql_database'], (int)$bannerAds['mysql_port']);
		if ($mysqli->connect_error) {
		    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
		}

		if (mysqli_connect_error()) {
		    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}

		if ($result = $mysqli->query("SELECT * FROM `ads`;") ) {
			$ads = array();
			while ($row = $result->fetch_row()) {
				if (is_null($row[PHPADS_ADELEMENT_ENDDATE])) {
					$row[PHPADS_ADELEMENT_ENDDATE] = 99999999;
				} else {
					$row[PHPADS_ADELEMENT_ENDDATE] = strtotime($row[PHPADS_ADELEMENT_ENDDATE]);
                	        }
				if (is_null($row[PHPADS_ADELEMENT_STARTDATE])) {
					$row[PHPADS_ADELEMENT_STARTDATE] = 99999999;
	                        } else {
					$row[PHPADS_ADELEMENT_STARTDATE] = strtotime($row[PHPADS_ADELEMENT_STARTDATE]);
				}
				$ads[] = implode("||",$row);
			}
			$result->close();
		}

		$mysqli->close();
	}
}
date_default_timezone_set($bannerAds['timezone']);
readads();
function writeads()
{
    global $bannerAdsPath, $ads, $bannerAds;
    $data = fopen($bannerAdsPath, 'w') or die();
    flock($data, LOCK_EX) or die();
//    fputs($data, @join("\n", $ads)."\n");
    while (list ($key, $val) = each ($bannerAds)) {
        if ($key != '') {
            fputs($data, $key.'='.$val."\n");
        }
    }
    fflush($data);
    flock($data, LOCK_UN);
    fclose($data);
    reset($bannerAds);
}
?>
