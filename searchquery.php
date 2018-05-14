<?php

			//Gets all the rooms that match the user's selections and for which the dates selected are not already booked.
			$sql = "SELECT room.room_id, photo, name, city, area, short_description, price, count_of_guests, room_type.room_type, bookings.check_in_date, bookings.check_out_date  FROM room 
						INNER JOIN room_type ON room.room_type=room_type.id
						LEFT JOIN bookings ON room.room_id=bookings.room_id
						WHERE (city='".$_POST['city']."' OR '".$_POST['city']."' = '')
						AND (room_type.room_type='".$_POST['roomtype']."' OR '".$_POST['roomtype']."' = '')
                        AND (STR_TO_DATE('".$_POST['checkin']."', '%m/%d/%Y') NOT BETWEEN STR_TO_DATE(bookings.check_in_date, '%m/%d/%Y') AND STR_TO_DATE(bookings.check_out_date, '%m/%d/%Y')
                        AND STR_TO_DATE('".$_POST['checkout']."', '%m/%d/%Y') NOT BETWEEN STR_TO_DATE(bookings.check_in_date, '%m/%d/%Y') AND STR_TO_DATE(bookings.check_out_date, '%m/%d/%Y') 
						OR bookings.check_in_date IS NULL)";
			
			//Accounts for the extra options in the filter section of the result page.
			if(isset($_POST['guests']) AND $_POST['guests'] != ""){
				$sql .="AND count_of_guests='".$_POST['guests']."'";	}

			if(isset($_POST['minprice']) AND isset($_POST['maxprice'])){
				$sql .="AND price BETWEEN '".$_POST['minprice']."' AND '".$_POST['maxprice']."'";	}				
					
					