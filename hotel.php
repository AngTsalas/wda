<?php include 'head.php';?>


	<div id="roompage" class="content">
		
		
		<?php		

			$sql = "SELECT room.room_id, name, city, area, photo, room_type, count_of_guests, price, lat_location, lng_location, long_description,
			CASE WHEN parking = 1 THEN 'Yes' ELSE 'No' END AS parking,
			CASE WHEN wifi = 1 THEN 'Yes' ELSE 'No' END AS wifi,
			CASE WHEN pet_friendly = 1 THEN 'Yes' ELSE 'No' END AS pet_friendly, reviews.rate
			FROM room
            LEFT JOIN reviews ON room.room_id=reviews.room_id
			WHERE room.room_id='".$_POST['room_id']."'";
		
			$result = mysqli_query($conn, $sql);
		
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {?>
					
		<div id="room">
		
			<div id="topbar">
				<span class="topinfo">
					<p class="nospace"><?php echo $row['name']; ?> - <?php echo $row['city']; ?>, <?php echo $row['area']; ?></p>
				</span>
				
				<span class="topinfo">
					<p class="nospace">Reviews:
					<?php
					if ($row['rate'] != NULL){
						for ($i=0; $i < $row['rate']; $i++) { ?>
							<i class="fas fa-star"></i><?php 
						}
						for ($i=0; $i < 5 - $row['rate']; $i++) { 
							?> <i class="far fa-star"></i>
				<?php   } 
					}else{echo("No reviews");}?>	
					</p>		
				</span>
				
				<span id="fav">
					<form method="POST" action="favorite.php" id="favform">
						<input type="hidden" name="room_id" value="<?php echo $_POST['room_id']; ?>"</input>
						<i id="favbut" class="fas fa-heart" style="<?php
						$sql2 = "SELECT status from favorites WHERE room_id='".$_POST['room_id']."' AND user_id=$userid";
						$result2 = mysqli_query($conn, $sql2);
						if (mysqli_num_rows($result2) > 0) {
							$row2 = mysqli_fetch_assoc($result2);
							if($row2['status'] == 1){
								echo("color: orange");
							}			
						}?>"></i>
					</form>
				</span>	

				<span class="topinfo">
					<p class="nospace">Per Night: <?php echo $row['price']; ?>&euro;</p>
				</span>	
			</div>
			
			<div id="images">
				<div id="roompic">
					<img src="images/rooms/<?php echo $row['photo']; ?>"></img>
				</div>	
				<div id="map">
					<form method="POST" action="getloc.php" id="mapform">
						<input type="hidden" name="lat" value="<?php echo $row['lat_location']; ?>"></input>
						<input type="hidden" name="lng" value="<?php echo $row['lng_location']; ?>"></input>
					</form>
				</div>
			</div>
						
			<div id="information">
				<span class="info">
					<p class="nospace"><i class="fas fa-user"></i> <?php echo $row['count_of_guests']; ?> <br> COUNT OF GUESTS</p>
				</span>
				<span class="info">
					<p class="nospace"><i class="fas fa-bed"></i> <?php echo $row['room_type']; ?> <br> TYPE OF ROOM</p>
				</span>
				<span class="info">
					<p class="nospace"><i class="fas fa-car"></i> <?php echo $row['parking']; ?> <br> PARKING</p>
				</span>
				<span class="info">
					<p class="nospace"><i class="fas fa-wifi"></i> <?php echo $row['wifi']; ?> <br> WiFi</p>
				</span>
				<span class="info">
					<p class="nospace"><i class="fas fa-paw"></i> <?php echo $row['pet_friendly']; ?> <br> PET FRIENDLY</p>
				</span>
			</div>
			
			<div id="description">
				<h2>Room Description</h2>
				<br>
				<p> <?php echo $row['long_description']; ?> </p>
				<form id="bookform" method="POST" action="book.php">
					<input type="hidden" name="room_id" value="<?php echo $_POST['room_id']; ?>"></input>
					<input type="hidden" name="checkin" value="<?php echo mysqli_real_escape_string($conn, $_POST['checkin']); ?>"></input>
					<input type="hidden" name="checkout" value="<?php echo mysqli_real_escape_string($conn, $_POST['checkout']); ?>"></input>					
					<div id="book">
						<button type="submit" id="bookbut"><?php
						$sql2 = "SELECT booking_id from bookings WHERE room_id='".$_POST['room_id']."' AND user_id=$userid";
						$result2 = mysqli_query($conn, $sql2);
						if (mysqli_num_rows($result2) > 0) {
							echo("Unbook");					
						}else{
						echo("Book");}?></button>
					</div>	
				</form>
				<?php	}
			}?>
			</div>
			
			<div id="reviews">
				<h2 class="head">Reviews</h2>
				<br>
				
			<?php		

			$sql = "SELECT text, rate, date_created, user.username FROM reviews
			INNER JOIN user ON reviews.user_id=user.user_id
			WHERE room_id='".$_POST['room_id']."'";
		
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				?><ol><?php
				while ($row = mysqli_fetch_assoc($result)) {?>		
				
					<li><h3><?php echo $row['username']; ?></h3>
					<?php
					for ($i=0; $i < $row['rate']; $i++) { ?>
						<i class="fas fa-star"></i><?php 
					}
					for ($i=0; $i < 5 - $row['rate']; $i++) { 
						?> <i class="far fa-star"></i>
			<?php   }?>
						<br>
						<p>Add time: <?php echo $row['date_created']; ?></p>
						<p><?php echo $row['text']; ?></p>
					</li>
				
			<?php	}?></ol><?php
			}else{echo("<p>There are no reviews for this hotel yet! Add one below.</p>");}?>
			</div>
			
			<div id="addreview">
				<h2 class="head">Add review</h2>
				<br>
				<form id="reviewform" method="POST" action="add_review.php">
					<i class="far fa-star" onclick="rate(1)"></i>
					<i class="far fa-star" onclick="rate(2)"></i>
					<i class="far fa-star" onclick="rate(3)"></i>
					<i class="far fa-star" onclick="rate(4)"></i>
					<i class="far fa-star" onclick="rate(5)"></i>
					<input type="hidden" name="rating" id="rating" value="0"></input>
					<br><br>
					<textarea cols="70" rows="5" name="text" placeholder="Review"></textarea>
					<input type="hidden" name="room_id" value="<?php echo $_POST['room_id']; ?>"></input> 
					<br>
					<div id="revbut">
						<button type="submit">Submit</button>
					</div>	
				</form>	
			</div>			
		</div>
	</div>

<?php include 'footer.php';

