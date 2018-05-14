<?php include 'head.php'; ?>
		
	<div class="content" id="landing">
		<div id="inputarea">	
			<form class="searchform" method="POST" action="results.php">
				<div id="cityroom">
					<span>
						<label>City:</label>
						<select name="city">
							<option value="">Any</option>
							<?php	$sql = "SELECT DISTINCT city FROM room";
							$result = mysqli_query($conn, $sql);
							
							if (mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_assoc($result)) { ?>
									<option value="<?php echo $row['city']; ?>"><?php echo $row['city']; ?></option>
										
			<?php 				}
							} ?> 
						</select>
					</span>
					<span>
						<label>Room Type:</label>
						<select name="roomtype">
							<option value="">Any</option>
						<?php	$sql = "SELECT DISTINCT room_type.room_type FROM room INNER JOIN room_type ON room.room_type=room_type.id";
							$result = mysqli_query($conn, $sql);
							
							if (mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_assoc($result)) { ?>
									<option value="<?php echo $row['room_type']; ?>"><?php echo $row['room_type']; ?></option>	
			<?php 				}
							} ?>
						</select>
					<span>
				</div>

				<div id="ldates">
					<p>Check-in Date: <input name="checkin" type="text" class="datepicker checkin"></p>	
					<p>Check-out Date: <input name="checkout" type="text" class="datepicker checkout"></p>	
				</div>
					
				<div id="button">
					<button type="submit">Search</button>
				</div>
			</form>	
		</div>
	</div>
	
<?php include 'footer.php';


