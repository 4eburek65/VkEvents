<?php
function getEvents($eventName = NULL, $dateBegin = NULL, $dateEnd = NULL, $aggregBy = 1)
{
	$conn = getConnection();
	$sql = "
		WITH authcount
		AS (SELECT e.is_auth,
		    Count(e.is_auth) auth_count
		FROM   events e
		GROUP  BY e.is_auth),
		ipcount
		AS (SELECT e.ip,
		    Count(e.ip) ip_count
		FROM   events e
		GROUP  BY e.ip),
		eventcount
		AS (SELECT e.NAME,
		    Count(e.NAME) event_count
		FROM   events e
		GROUP  BY e.name)

		SELECT e.id,
		e.name,
		e.ip,
		e.is_auth,
		e.date, 
	";
	switch ($aggregBy) {
		case 1:
			$sql .= "
		    ec.event_count count
			FROM   events e
			INNER JOIN eventcount ec
	           	ON ec.NAME = e.NAME 
			";
			break;
		case 2:
			$sql .= "
			ic.ip_count count
			FROM   events e
			INNER JOIN ipcount ic
				ON ic.ip = e.ip 
			";
			break;
		case 3:
			$sql .= "
			ac.auth_count count
			FROM   events e
		   	INNER JOIN authcount ac
		        ON ac.is_auth = e.is_auth 
			";
			break;
	}
	$sql .= " 
		WHERE (IFNULL(?,'') = '' OR e.date >= ?)
			AND  (IFNULL(?,'') = '' OR e.date <= ?)
			AND (IFNULL(?,'') = '' OR e.NAME = ?)
	";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("ssssss", $dateBegin, $dateBegin, $dateEnd, $dateEnd, $eventName, $eventName);
	$stmt->execute();
	return $stmt->get_result();
}