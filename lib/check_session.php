<?php
/**
 * Penulis Kode - SMM Panel script
 * Domain: http://penuliskode.com/
 * Documentation: http://penuliskode.com/smm/script/version-n1/documentation.html
 *
 */

if (!isset($_SESSION['login'])) {
	$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Authentication required!', 'msg' => 'Please log in to your account.');
	exit(header("Location: ".$config['web']['base_url']."auth/login.php"));
}