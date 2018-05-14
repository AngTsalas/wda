<?php include 'dbconnect.php';
//If the room is in this user's favorites, remove it. Otherwise add it to the user's favorites. Return the status to Jquery

$sql = "SELECT status from favorites WHERE room_id='".$_POST['room_id']."' AND user_id=$userid";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);

	if($row['status'] == 1){
		$sql = "UPDATE favorites SET status='0' WHERE room_id='".$_POST['room_id']."'";
		$st = 0;
	}else{
		$sql = "UPDATE favorites SET status='1' WHERE room_id='".$_POST['room_id']."'";
		$st = 1;
	}
		
	
}else{
	
	
 $sql = "INSERT INTO favorites (status, user_id, room_id)
VALUES ('1', $userid, '".$_POST['room_id']."')";


$st = 1;
}	
$result = mysqli_query($conn, $sql);
echo json_encode($st);	