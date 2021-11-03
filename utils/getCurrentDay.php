<?php
function setDayIDURL()
{
    require_once("connection.php");
    $conn = Connect();

    $currentDay = date('D');
    $query = "SELECT * FROM week WHERE day_name = '$currentDay'";
    $result = $conn->query($query);
    $day_id = mysqli_fetch_array($result)['day_id'];

    return $day_id;
}
