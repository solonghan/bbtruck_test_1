<!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?=base_url() ?>">
	<meta charset="UTF-8">
	<title>溫度部落</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="<?=base_url() ?>assets/css/floating-labels.css?v=<?=date("His") ?>" rel="stylesheet">
</head>
<body>
    <canvas id="map" style="width: 750px; height: 390px;"></canvas>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.4.0/fabric.min.js"></script>
	
	<script src="assets/Acdemic_map.js"></script>

	<script src="https://www.gstatic.com/firebasejs/8.8.0/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.8.0/firebase-analytics.js"></script>

	<!-- <script src="pushnoti.js?v=<?=rand(10000,999999) ?>"></script> -->
	<script>
		
  
var config = {
  apiKey: "AIzaSyAKBpfXoC2TQq7hUWdQzLrWo43daEKhOew",
  authDomain: "wundoo-social.firebaseapp.com",
  projectId: "wundoo-social",
  storageBucket: "wundoo-social.appspot.com",
  messagingSenderId: "160690801837",
  appId: "1:160690801837:web:22892c9f9e7fe0d95e8a24",
  measurementId: "G-3G62DSZZ8T"
};
var VapidKey = 'BBrxGlwyNtwy7_6FPMXqRsQtAXF7BpAzDjLKiBPgjF5B0AzhZPy_OGWQkL2nhZ3OiYxk7DD1xJ_VOo9ajexy8vc';
var messaging = null;
    // Initialize Firebase
    firebase.initializeApp(config);

    messaging = firebase.messaging();
	</script>
</body>
</html>