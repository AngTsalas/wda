<?php 
//Pass the hotel's location to Jquery
$result = array('lat' => $_POST['lat'], 'lng' => $_POST['lng']);
header('Content-Type: application/json');
echo json_encode($result);
exit();