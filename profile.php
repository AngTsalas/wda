<?php include 'head.php'; ?>

	<div class="content">
		<span class="left">
			<h4>FAVORITES</h4>
			<ol><?php
			$sql = "SELECT name FROM favorites 
						INNER JOIN room ON favorites.room_id=room.room_id
						WHERE user_id=$userid AND status=1";

			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {?>		
					<li><?php echo $row['name']; ?></li>
		<?php	}
			}else{
				echo('<h4 style="color: #007bff;">No favorites yet.</h4>');
			} ?>
			</ol>
			<h4>REVIEWS</h4>
			<ol><?php
			$sql = "SELECT name, rate FROM reviews 
						INNER JOIN room ON reviews.room_id=room.room_id
						WHERE user_id=$userid";

			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {?>
					<li><?php echo $row['name']; ?>
					<br>
					<?php
					for ($i=0; $i < $row['rate']; $i++) { ?>
						<i class="fas fa-star"></i><?php 
					}
					for ($i=0; $i < 5 - $row['rate']; $i++) { 
						?> <i class="far fa-star"></i>
			<?php   }?> </li>				
	<?php 		}
			}else{
				echo('<h4 style="color: #007bff;">No reviews yet.</h4>');
			}				?>	
			</ol>
		</span>
		
		<span class="right">
			<div class="rheader">
				<h4>My bookings</h4>
			</div>	
			
			<div class="listings">
				<?php		

			$sql = "SELECT room.room_id, check_in_date, check_out_date, room.name, room.photo, room.city, room.area, room.short_description, room.price, room_type.room_type  FROM bookings
						INNER JOIN room ON bookings.room_id=room.room_id
						INNER JOIN room_type ON room.room_type=room_type.id
						WHERE user_id=$userid
						ORDER BY bookings.date_created";
						
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {?>
				<div class="listitem">
					<div class="basic">
						<span id="roomphoto">
							<img src="images/rooms/<?php echo $row['photo']; ?>"></img>
						</span>	
						<span id="roominfo">
							<h3><?php echo $row['name']; ?></h3>
							<h4><?php echo $row['city']; ?>, <?php echo $row['area']; ?></h4>
							<br>
							<p><?php echo $row['short_description']; ?></p>
							<div id="roombutton">
								<form method="POST" action="hotel.php">
									<input type="hidden" name="room_id" value="<?php echo $row['room_id']; ?>"></input>
									<button type="submit" class="gotoroom">Go to room page</button>
								</form>	
							</div>	
						</span>	
					</div>
				
					<div id="roomdetails">
						<span id="pricebox">
							<p class="nospace">Total Cost: <?php
							$sql2 = "SELECT DATEDIFF(str_to_date(check_out_date, '%m/%d/%Y'), str_to_date(check_in_date, '%m/%d/%Y')) AS datediff FROM bookings
							WHERE room_id='".$row['room_id']."'";
						
							$result2 = mysqli_query($conn, $sql2);
							
							if (mysqli_num_rows($result2) > 0) {
								while ($row2 = mysqli_fetch_assoc($result2)) {						
									echo $row['price'] * $row2['datediff']; ?>&euro;</p>
					<?php 		}
							}  ?>
						</span>
						<span class="detailsbox">
							<span class="details">
								<p class="nospace">Check-in Date: <?php echo $row['check_in_date']; ?></p>
							</span>
							<span class="details">
								<p class="nospace">Check-out Date: <?php echo $row['check_out_date']; ?></p>
							</span>	
							<span class="details">
								<p class="nospace">Type of Room: <?php echo $row['room_type']; ?></p>
							</span>		
						</span>	
					</div>
				</div>
				<?php	}
			}else{
				echo('<h4 style="color: #007bff;">No bookings yet.</h4>');
			} ?>
			</div>	
		</span>
	</div>

<?php include 'footer.php';	