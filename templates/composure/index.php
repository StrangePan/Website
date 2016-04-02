<?php
if (!defined("ENGINE")) die ();
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- Meta information -->
		<meta charset="UTF-8" />
		<meta name="description" content="Personal web site of Daniel 'Deaboy' Ernest Andrus II" />
		<meta name="keywords" content="personal, sandbox, blog, code, custom, daniel, dan, deaboy, andrus" />
		<meta name="author" content="Daniel Andrus" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=1"/> <!--320-->

		<!-- Page title -->
		<title>Dan Andrus</title>

		<!-- Remote CSS links -->
		<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine:400,700|Open+Sans:300italic,700italic,300,700" />

		<!-- Local CSS links -->
		<link rel="stylesheet" type="text/css" href="<?php echo $templateRoot; ?>css/styles.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $templateRoot; ?>css/wide.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $templateRoot; ?>css/medium.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $templateRoot; ?>css/narrow.css" />
	</head>
	<body>

		<!-- Page wrapper -->
		<div id="page">
			
			<!-- Page header -->
			<header id="header" role="banner">

				<div class="title">
					<a href="/">
						<img src="/images/profile.jpg" class="profile-picture logo" />
						Dan Andrus
					</a>
				</div>
				<?php include "content/nav_main.php"; ?>

			</header>

			<!-- Page main content -->
			<main id="content" role="main">

				<?php include $page; ?>

			</main>

			<!-- Page footer -->
			<footer id="footer" role="contentinfo">

				<!-- Everybody loves social links. Right? -->
				<?php include "content/nav_social.php"; ?>
				
				<!-- Copyright info -->
				<div class="copyright">
					&copy; 2014-2016 Daniel Andrus
				</div>
				
			</footer>
		</div>
	</body>
</html>
