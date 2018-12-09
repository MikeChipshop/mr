<!doctype html>
<?php include 'keys.php'; ?>
<html lang="en-US" prefix="og: http://ogp.me/ns#">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="initial-scale=1">
	<title>A tool to help you avoid the dreaded Scottish Highland Midge | Midger</title>
	<meta name="description" content="A tool to help you avoid the dreaded Scottish Highland Midge"/>
	<meta name="robots" content="noodp">
	<link rel="canonical" href="https://midger.uk/">
	<meta property="og:locale" content="en_GB">
	<meta property="og:type" content="website">
	<meta property="og:title" content="A tool to help you avoid the dreaded Highland Midge | Midger">
	<meta property="og:description" content="A tool to help you avoid the dreaded Highland Midge | Midger">
	<meta property="og:url" content="https://midger.uk/">
	<meta property="og:site_name" content="Midger">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:description" content="A tool to help you avoid the dreaded Highland Midge | Midger">
	<meta name="twitter:title" content="A tool to help you avoid the dreaded Highland Midge | Midger">
	<meta name="twitter:image" content="https://midger.uk/assets/midger-avatar.jpg">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-title" content="Midger">
	<script src="https://use.typekit.net/wey6lbt.js"></script>
	<!-- Favicons -->	
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="/manifest.json">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#06695c">
	<meta name="theme-color" content="#1f1f1f">
	<!-- End fav -->
	<script>try{Typekit.load({ async: true });}catch(e){}</script>
	<link rel="stylesheet" href="style.css" type="text/css" media="all">	
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
	<script src="/assets/fontawesome/fontawesome.min.js"></script>
	<script src="/assets/fontawesome/fa-light.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
	<div class="mt_main-splash-container">
 		<div class="mt_splash-wrap">
 			<div class="mt_splash-logo">
 				<img src="android-chrome-144x144.png">
				<h1>Midger</h1>				
			</div>
			<div class="mt_intro-content">
				<p>Midger is a tool to help you plan your Scottish outdoor pursuits around the ever looming threat of the Scottish Highland Midge.</p>
				<p>Simply click the button below and receive back your MidgeScore, a unit of Midge intensity</p>
				<button class="mt_start-call">Find my Midge score <span class="fal fa-compass"></span></button>
				<div class="information"></div>
			</div>
			<div class="result">
				<div class="mt_result-score"></div>
				<div class="mt_result-location"></div>
				<div class="mt_result-ui"></div>
				
			</div>
		</div>
	</div>
	
	<script>
		$( document ).ready(function() {
			
			
			
			$("button").click(function() {
				
				// Get Location
				if(navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(success);
				} else {
					console.log('blocked');
					$(".information").html('Your browser doesn\'t support the geolocation api.');
				}
				function success(position) {
					var userlat = position.coords.latitude;
					var userlon = position.coords.longitude;
					var userloc = "" + userlat + "," + userlon + "";
					$('button').html('Finding Location...  <span class="fal fa-circle-notch fa-spin"></span>');
				
					$("body").addClass("mt_loading-data");
				
					console.log(userloc);
					$.ajax({ 
						type: "GET",
						dataType: "jsonp",
						//url: "https://midger.uk/api.php?loc="+ userloc +"",
						url: "https://midgr.uk/go/nads/?<?php echo $secret; ?>&loc=" + userloc +"",
						cache: false,
						success: function(data){  
							var finalscore = data[0].results.score;
							console.log(finalscore);
							$(".mt_result-score").html(data[0].results.score);
							$(".mt_result-location").html(data[0].results.locationLabel);
							$("body").removeClass("mt_loading-data");
							$(".mt_intro-content").hide();
							
							$("body").addClass("circle-"+ finalscore +"");					

							$('.mt_result-score').each(function () {
								$(this).prop('Counter',0).animate({
									Counter: $(this).text()
								}, {
									duration: 3000,
									easing: 'swing',
									step: function (now) {
										$(this).text(Math.ceil(now));
									}
								});
							});
							

							$('.mt_result-ui').each(function () {
								$(this).prop('Counter',0).animate({
									Counter: $(this).addClass()
								}, {
									duration: 3000,
									easing: 'swing',
									step: function (now) {
										$(this).addClass(Math.ceil(now));
									}
								});
							}); 	
						} // End Success AJAX
					});
				}; // End success
			}); // endclick
		}); // End Doc Ready
		
		// Service worker call
		if ("serviceWorker" in navigator){
			navigator.serviceWorker
			.register("/serviceworker.js")
			.then(function(){
				console.log("Service Worker Registered");
			});
		}
	</script>
</body>
</html>