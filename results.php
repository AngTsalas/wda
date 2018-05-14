<?php include 'head.php'; ?>

	<div class="content">
		<span class="left">
			<h4>FIND THE PERFECT HOTEL</h4>
			<form class="searchform" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div class="selectoptions">
					<label>Count of Guests: </label>
					<select name="guests">
						<option value="">Any</option> 
						<?php	$sql = "SELECT DISTINCT count_of_guests FROM room";
							$result = mysqli_query($conn, $sql);
							
							if (mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_assoc($result)) { ?>
									<option value="<?php echo $row['count_of_guests']; ?>"
									<?php if (isset($_POST['guests']) AND ($_POST['guests'] === $row['count_of_guests']) ) {echo "selected";}?>>
									<?php echo $row['count_of_guests']; ?></option>	
			<?php 				}
							} ?>
					</select>
					<label>Room Type: </label>
					<select name="roomtype">
						<option value="">Any</option>
						<?php	$sql = "SELECT DISTINCT room_type.room_type FROM room INNER JOIN room_type ON room.room_type=room_type.id";
							$result = mysqli_query($conn, $sql);
							
							if (mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_assoc($result)) { ?>
									<option value="<?php echo $row['room_type']; ?>"
									<?php if (isset($_POST['roomtype']) AND ($_POST['roomtype'] === $row['room_type']) ) {echo "selected";}?>>
									<?php echo $row['room_type']; ?></option>	
			<?php 				}
							} ?>
					</select>
					<label>City: </label>
					<select name="city">
						<option value="">Any</option> 
 						<?php	$sql = "SELECT DISTINCT city FROM room";
							$result = mysqli_query($conn, $sql);
							
							if (mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_assoc($result)) { ?>
									<option value="<?php echo $row['city']; ?>"
									<?php if (isset($_POST['city']) AND ($_POST['city'] === $row['city']) ) {echo "selected";}?>>
									<?php echo $row['city']; ?></option>
			<?php 				}
							} ?>  
					</select>
				</div>
				
				<p>Price Range: </p>
				<div id="slider-range"></div>
				<input type="text"  id="min_price" name="minprice" class="price-range-field" 
				value="<?php if (isset($_POST['minprice'])){echo ($_POST['minprice']);}else{echo ("75");}?>">
				<input type="text"  id="max_price" name="maxprice" class="price-range-field"
				value="<?php if (isset($_POST['maxprice'])){echo ($_POST['maxprice']);}else{echo ("500");}?>">
				
				<div id="dates">
					<p>Check-in Date: <input <?php if (isset($_POST['checkin'])) {echo 'value="' . strip_tags($_POST['checkin']) . '"';}?>
					name="checkin" type="text" class="datepicker checkin"></p>	
					<p>Check-out Date: <input <?php if (isset($_POST['checkout'])) {echo 'value="' . strip_tags($_POST['checkout']) . '"';}?>
					name="checkout" type="text" class="datepicker checkout"></p>	
				</div>
				
				<button type="submit">FIND HOTEL</button>
			</form>	
		</span>

		<span class="right">
			<div class="rheader">
				<h4>Search Results</h4>
			</div>	
			
			<div class="listings">
										
			<?php include 'searchquery.php';

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
										<input type="hidden" name="checkin" value="<?php echo strip_tags($_POST['checkin']); ?>"></input>
										<input type="hidden" name="checkout" value="<?php echo strip_tags($_POST['checkout']); ?>"></input>
										<button type="submit" class="gotoroom">Go to room page</button>
									</form>	
								</div>	
							</span>	
						</div>
					
						<div id="roomdetails">
							<span id="pricebox">
								<p class="nospace">Per Night: <?php echo $row['price']; ?>&euro;</p>
							</span>
							<span class="detailsbox">
								<span class="details">
									<p class="nospace">Count of Guests: <?php echo $row['count_of_guests']; ?></p>
								</span>
								<span class="details">
									<p class="nospace">Type of Room: <?php echo $row['room_type']; ?></p>
								</span>		
							</span>	
						</div>
					</div>				
		<?php	}
			}else{?> <h4 style="color: #007bff;">No results were found! Try again!</h4> <?php } ?>	
						
			</div>
		</span>
	</div>

<?php include 'footer.php';