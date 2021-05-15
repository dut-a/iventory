<?php

function redirect_to($new_location) {
	header("Location: " . $new_location);
	exit;
}

/**
 * 
 * @param $array The array to search.
 * @param $element The element to find in a given array.
 * @return $element if last in a given array.
 * 
 */
function last($array, $element) {
	return $element == array_values(array_slice($array, -1))[0];
}

function contains($where_to_find_it, $what_to_find) {
	return strpos(strtolower($where_to_find_it), strtolower($what_to_find)) !== false;
}

function starts_with($string_to_check_in, $string_to_check_for) {
	$length = strlen($string_to_check_for);
	return (substr($string_to_check_in, 0, $length) === $string_to_check_for);
}

function ends_with($string_to_check_in, $string_to_check_for) {
	$length = strlen($string_to_check_for);
	if ($length == 0) {
		return true;
	}
	return (substr($string_to_check_in, -$length) === $string_to_check_for);
}

function remove_first($text) {
	return substr($text, 1);
}

function remove_last($text) {
	return substr($text, 0, -1);
}

function append($text_append, $original_text) {
	return $original_text . $text_append;
}

function prepend($text_to_prepend, $original_text) {
	return $text_to_prepend . $original_text;
}

function u($string = "") {
	return urlencode($string);
}

function raw_u($string = "") {
	return rawurlencode($string);
}

function h($string = "") {
	return htmlspecialchars($string);
}

// is_blank('abcd')
// * validate data presence
// * uses trim() so empty spaces don't count
// * uses === to avoid false positives
// * better than empty() which considers "0" to be empty
function is_blank($value) {
	return !isset($value) || trim($value) === '';
}

function get_auto_copyright_year($year = 'auto') {
	$current_year = date('Y');

	if($year == 'auto') {
		return $current_year;
	}
	if($year == $current_year) {
		return intval($year);
	}
	if($year < $current_year) {
		return intval($year) . ' &mdash; ' . $current_year;
	}
	if($year > $current_year) {
		return $current_year;
	}
}

function get_copyright_info($year = 'auto', $rights = true) {
	$rights = " All rights reserved. ";
	$site_name = "iVentory";
	$y = get_auto_copyright_year($year);
	$year_site_name = "{$y} {$site_name}.";
	$copy_right = $rights ? "&copy; " . $year_site_name . $rights : $year_site_name;
	return $copy_right;
}

// all things DB
function db_connect() {
	try {
		$connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PASS);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->exec("SET NAMES 'utf8'"); // set charset
		confirm_db_connect();
		return $connection;
	} catch (Exception $e) {
		echo "Could not connect to the database.<br>";
		exit;
	}
}

function db_disconnect($connection) {
	if(isset($connection)) {
		mysqli_close($connection);
	}
}

function db_escape($connection, $string) {
	return mysqli_real_escape_string($connection, $string);
}

function confirm_db_connect() {
	if (mysqli_connect_errno()) {
		$msg = "Database connection failed: ";
		$msg .= mysqli_connect_error();
		$msg .= " (" . mysqli_connect_errno() . ")";
		exit($msg);
	}
}

function confirm_result_set($result_set) {
	if (!$result_set) {
		exit("Database query failed.");
	}
}

