<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/get_connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/get_events.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/add_event.php';

session_start();

$eventName = isset($_GET['event'])? $_GET['event'] : null;
$dateBegin = isset($_GET['date_begin'])? $_GET['date_begin'] : null;
$dateEnd = isset($_GET['date_end'])? $_GET['date_end'] : null;
$agregBy = isset($_GET['agreg_by'])? $_GET['agreg_by'] : 1;

if (!empty($_POST)) {
	$event = $_POST['event_name'] ?? "";
	$isAuth = !empty($_POST['is_auth']) && $_POST['is_auth'] = 'on' ? 1 : 0;
    $result = addEvent($event, $isAuth) ;
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Events</title>
</head>
<body>
	<div>
	    <form action='?add=yes' method="post">
			<table width="40%" border="0" cellspacing="10" cellpadding="0">
				<tbody>
				<tr>
					<td><b>Добавление</b></td>
				</tr>
				<tr>
					<td colspan="2">
		                <label for="event_name">Название события:</label>
		                <input required id="event_name" size="30" name="event_name"?>
		            </td>
		            <td>
		                <label for="is_auth">Пользователь авторизован:</label>
		                <input id="is_auth" type="checkbox" size="30" name="is_auth" ?>
		            </td>
		            <td>
		            	<input type="submit" value="Добавить" >
		            </td>
				</tr>
				</tbody>
			</table>
		</form>
		<hr>
		<form action='' method="get">
			<table width="40%" border="0" cellspacing="10" cellpadding="0">
				<tbody>
				<tr>
					<td><b>Фильтр</b></td>
				</tr>
				<tr>
					<td colspan="2">
		                <label for="event">Название события:</label>
		                <input id="event" size="30" name="event" value="<?php if(isset($_GET['event'])){echo $_GET['event'];}?>"?>
		            </td>
		            <td>
		                <label for="date_begin">От:</label>
		                <input id="date_begin" type="date" size="30" name="date_begin" value="<?php if(isset($_GET['date_begin'])){echo $_GET['date_begin'];}?>"?>
		            </td>
		            <td>
		                <label for="date_end">До:</label>
		                <input id="date_end" type="date" size="30" name="date_end" value="<?php if(isset($_GET['date_end'])){echo $_GET['date_end'];}?>"?>
		            </td>
		            <td>
		            	<label for="agreg_by">Агрегировать по:</label>
	            	   	<select name="agreg_by">
					    <option <?php if ($agregBy == 1) echo 'selected' ?> value="1">Событие</option>
					    <option <?php if ($agregBy == 2) echo 'selected' ?> value="2">IP-адрес</option>
					    <option <?php if ($agregBy == 3) echo 'selected' ?> value="3">Статус пользователя</option>
					   </select>
		            </td>
		            <td>
		            	<input type="submit" value="Поиск" >
		            </td>
				</tr>
				</tbody>
			</table>
		</form>
	</div>
	<hr>
	<table border="1" cellpadding="5" style="border-collapse: collapse; border: 1px solid black;">
	<tr>
		<th>Название события</th>
		<th>IP Пользователя</th>
		<th>Статус пользователя</th>
		<th>Дата</th>
		<th>Количество</th>
	</tr>
	<div style="margin:10px">
		<?php
			$events = getEvents($eventName, $dateBegin, $dateEnd, $agregBy);
			$decode = json_decode($events);
			foreach ($decode as $item) { ?>
				<tr>
					<td><?=$item->event ?></td>
					<td><?=$item->ip ?></td>
					<td><?=$item->user_status ?></td>
					<td><?=$item->date ?></td>
					<td><?=$item->count ?></td>
				</tr>
				<?php } ?>
		</table>
	</div>
</body>
</html>
