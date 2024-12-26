<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>loading</title>
	<link rel="stylesheet" type="text/css" href="load.css">
</head>

<body>

	<div class="container">
		<div class="ring"></div>
		<div class="ring"></div>
		<div class="ring"></div>

		<p id="timer"></p>
	</div>
	<script>
		// Set the timer duration in seconds
		var duration = 1;

		// Get the timer element
		var timerElement = document.getElementById('timer');

		// Update the timer display every second
		var timer = setInterval(function() {
			// Calculate the minutes and seconds remaining
			var minutes = Math.floor(duration / 60);
			var seconds = duration % 60;

			// Pad the minutes and seconds with leading zeros
			minutes = ('0' + minutes).slice(-2);
			seconds = ('0' + seconds).slice(-2);

			// Update the timer display
			timerElement.innerHTML = minutes + ':' + seconds;

			// Decrement the duration
			duration--;

			// If the timer reaches zero, redirect to another page
			if (duration < 0) {
				clearInterval(timer);
				window.location.href = 'home.php';
			}
		}, 1000);
	</script>
</body>

</html>