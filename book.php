<?php include 'dbconnect.php';
//If there is a booking from this user, delete it. Otherwise add a new booking. Return the status to Jquery

$sql = "SELECT booking_id from bookings WHERE room_id='".$_POST['room_id']."' AND user_id=$userid";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

		$sql = "DELETE FROM bookings WHERE room_id='".$_POST['room_id']."'";
		$st = 0;
			
	
}else{
	
	
 $sql = "INSERT INTO bookings (check_in_date, check_out_date, user_id, room_id)
VALUES ('".$_POST['checkin']."', '".$_POST['checkout']."', $userid, '".$_POST['room_id']."')";


$st = 1;
}	
$result = mysqli_query($conn, $sql);
echo json_encode($st);	