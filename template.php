<html>

<head>
	<title>Layout Set 1</title>
	<link rel="stylesheet" href="css/font-awesome.min.css" />
	<link rel="stylesheet" href="css/pure-min.css" />
	<link rel="stylesheet" href="css/style.css" />
	<script src="js/processing.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/main.js"></script>
</head>

<body>
	<div id="ground" class="pure-g">
		<div id="leftside" class="pure-u-1-6">
			<!--Left Gap-->
		</div>
		<div id="page" class="pure-u-2-3">
			<div id="pageTitle">
				<div id="pageTitleContent">
					PAGE
				</div>
			</div>
			<div id="pageContent">
				<!--Hello-->
				
			</div>
		</div>
		<div id="rightside" class="pure-u-1-6">
			<!--Right Gap-->
		</div>
	</div>

	<div id="titlebar">
		<?php include 'assets/titlebar.php'; ?>
	</div>
	
	<div id="sidemenu">
		<?php include 'assets/sidebar.php'; ?>
	</div>
</body>

</html>