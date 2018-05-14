<?php include 'dbconnect.php';
//If there is a review from this user, update it. Otherwise add a new review.

$sql = "SELECT review_id from reviews WHERE room_id='".$_POST['room_id']."' AND user_id=$userid";

$result = mysqli_query($conn, $sql);

$text = mysqli_real_escape_string($conn, $_POST['text']);

if (mysqli_num_rows($result) > 0){
	$sql = "UPDATE reviews SET text='".$text."', rate='".$_POST['rating']."' WHERE room_id='".$_POST['room_id']."'";
	
}else{
	 $sql = "INSERT INTO reviews (text, rate, user_id, room_id)
VALUES ('".$text."', '".$_POST['rating']."', $userid, '".$_POST['room_id']."')";
}

$result = mysqli_query($conn, $sql);












			




