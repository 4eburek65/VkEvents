<?php
function addEvent($eventName, $isAuthorize = 0)
{
	if (!empty($eventName)){
		$conn = getConnection();
		$sql = "
			INSERT INTO events (name, is_auth, ip, date) 
			VALUES (?, ?, ?, ?)
		";
		$stmt = $conn->prepare($sql);
		$date = date("Y-m-d H:i:s");
		$ip = '';
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (!empty($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$stmt->bind_param("siss", $eventName, $isAuthorize, $ip, $date);
		$stmt->execute();
		redirect();
		return true;
	}
	return false;
}
