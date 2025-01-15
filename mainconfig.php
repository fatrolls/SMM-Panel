<?php
/**
 * Pembuat script : Tomy Satriandy Sinulingga
 * Nomor wa : 082384238403
 * Website : https://medan-smm.co.id
 *
 */

date_default_timezone_set('America/New_York');
ini_set('memory_limit', '128M');

/* CONFIG */
$config['web'] = array(
	'maintenance' => 0, // 1 = yes, 0 = no
	'title' => 'HighGamer.com\'s SMM Panel V1',
	'title2' => 'HighGamer.com\'s | FREE Panel SMM V1',
	'meta' => array(
		'description' => 'rizkiagungid - Cheapest SMM Panel a cheapest and no.1 smm panel reseller platform in Indonesia that provides various social media marketing services that operate mainly in Indonesia. By joining us, you can become a social media service provider or social media reseller such as services to add Followers, Likes, etc. Currently available various services for the most popular social media such as Instagram, Facebook, Twitter, Youtube, etc. SMM Panel Indonesia which provides social media panels such as Followers, Likes, Views, Subscribers, for various social media: Instagram Youtube, Facebook, Twitter at the Cheapest price.',
		'keywords' => 'smm panel',
		'author' => 'HighGamer.com'
	),
	'base_url' => 'https://highgamer.com/smm/', // ganti link domainmu
	'register_url' => 'https://highgamer.com/smm/auth/register.php' // ganti link domainmu
);

$config['register'] = array(
	'price' => array(
		'member' => 10000,
		'reseller' => 30000,
	),
	'bonus' => array(
		'member' => 5000,
		'reseller' => 10000,
	)
);

$config['db'] = array(
	'host' => 'localhost',
	'name' => 'smm',
	'username' => 'root',
	'password' => 'password'
);
/* END - CONFIG */

require 'lib/db.php';
require 'lib/model.php';
require 'lib/function.php';

session_start();
$model = new Model();
