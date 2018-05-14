window.onload = function(){

	//Colors the active navigation bar link red
	$(".navbar [href]").each(function() {
        if (this.href == window.location.href) {
            $(this).addClass("here");
        }
    });
	
	//Gets the location of the hotel and creates the map
	$.post(		
		$('#mapform').attr('action'),
		$('#mapform :input').serializeArray(),
		function(data){
			var mapdiv = document.getElementById("map");
			var myLatlng = new google.maps.LatLng(data.lat, data.lng);
		mapdiv.style.display = "block";
		var map = new google.maps.Map(mapdiv, {
		zoom: 17,
		center: myLatlng
		});	
		},
		'json'
	);
	
	//Performs validation on the date inputs of the landing page
	$('.searchform').submit(function() {
		if (!isValidDate($(".checkin").val()) || !isValidDate($(".checkout").val())){
			$.alert({
				title: "Invalid dates",
				content: "You did not specify valid dates for check-in and check-out.",
				type: 'red'
			});
			return false;
		}
		
		if(!newerThan($(".checkout").val(), $(".checkin").val() )){
			$.alert({
				title: "Invalid check-out date",
				content: "The check-out date is not valid. Insert a check-out date later than the check-in date.",
				type: 'red'
			});
			return false;
		}
				
	});
	
	//Provides functionality to the favorite icon in the room page
	$('#favbut').click(function(){
		$.post(		
		$('#favform').attr('action'),
		$('#favform :input').serializeArray(),
		function(st){
			
			if(st == 1){
				$.alert({
					title: "Success",
					content: "Room was added to your favorites!",
					type: 'green'
				});
				$(".fa-heart").css("color", "orange");
			}else{
				$.alert({
					title: "Success",
					content: "Room was removed from your favorites!",
					type: 'green'
				});
				$(".fa-heart").css("color", "white");
			}
			
		}
	);
	});
	
	//Changes the functionality of the review button in the room page. It now gets if the room is already reviewed from the database and works accordingly.
	$('#reviewform').submit(function(){
		return false;
	});
	
	$('#revbut').click(function(){
		$.post(		
			$('#reviewform').attr('action'),
			$('#reviewform :input').serializeArray(),
			function(c){
				$.alert({
					title: "Success",
					content: "Your review was submitted.",
					type: 'green'
				});
			}
		);
	});

	//Changes the functionality of the book button in the room page. It now gets if the room is already booked from the database and works accordingly.
	$('#bookform').submit(function(){
		return false;
	});
	
	$('#bookbut').click(function(){
		$.post(		
			$('#bookform').attr('action'),
			$('#bookform :input').serializeArray(),
			function(st){
				
				if(st == 1){
					$.alert({
						title: "Success",
						content: "The room was booked.",
						type: 'green'
					});
					$('#bookbut').html("Unbook");
				}else{
					$.alert({
						title: "Success",
						content: "The room was unbooked.",
						type: 'green'
					});
					$('#bookbut').html("Book");
				}
				
			}
		);
	});
}

//Functions that create the datepicker and the price range slider
$( function() {
    $( ".datepicker" ).datepicker();
  } );
    
  $(function(){
  $("#slider-range").slider({
	  range: true,
	  orientation: "horizontal",
	  min: 0,
	  max: 1000,
	  values: [75, 500],
	  step: 25,
	  slide: function (event, ui) {
		if (ui.values[0] == ui.values[1]) {
		  return false;
		} 
		$("#min_price").val(ui.values[0]);
		$("#max_price").val(ui.values[1]);
	  }
  }
  );
  });

//Provides functionality to the star icons in the review section of the room page
function rate(rating){
	$("#rating").val(rating);
	$(event.target).prevAll().andSelf().removeClass("far");
	$(event.target).prevAll().andSelf().addClass("fas");
	$(event.target).nextAll("i").removeClass("fas");
	$(event.target).nextAll("i").addClass("far");
}

//Compares dates
function newerThan(date1, date2){
	var d1 = new Date(date1);
	var d2 = new Date(date2);
	return d1.getTime() > d2.getTime();
}

// Validates that the input string is a valid date formatted as "mm/dd/yyyy"
function isValidDate(dateString)
{
    // First check for the pattern
    if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(dateString))
        return false;

    // Parse the date parts to integers
    var parts = dateString.split("/");
    var day = parseInt(parts[1], 10);
    var month = parseInt(parts[0], 10);
    var year = parseInt(parts[2], 10);

    // Check the ranges of month and year
    if(year < 1000 || year > 3000 || month == 0 || month > 12)
        return false;

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    // Check the range of the day
    return day > 0 && day <= monthLength[month - 1];
};



