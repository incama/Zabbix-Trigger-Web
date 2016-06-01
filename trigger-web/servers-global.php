<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Company Trigger Web</title>
    <script src="lib/js/jquery-2.1.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style/triggers.css" />
    <script> 
		var auto_refresh = setInterval(
		function()
		{
			// $('#serverdata').fadeOut('slow').load('servers-data.php').fadeIn("slow");
			$('#serverdata').load('servers-data.php');
		}, 30000);
</script>
</head>
<body>
			<?php include 'servers-data.php';?>
</body>
</html>

