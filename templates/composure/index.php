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
		<link rel="stylesheet" type="text/css" href="<?=$templateRoot?>css/styles.css" />
		<link rel="stylesheet" type="text/css" href="<?=$templateRoot?>css/wide.css" />
		<link rel="stylesheet" type="text/css" href="<?=$templateRoot?>css/medium.css" />
		<link rel="stylesheet" type="text/css" href="<?=$templateRoot?>css/narrow.css" />

		<!-- Icons -->
		<link rel="icon" type="image/png" href="<?=$relRoot?>images/favicon-16x16.png" sizes="16x16" />
		<link rel="icon" type="image/png" href="<?=$relRoot?>images/favicon-32x32.png" sizes="32x32" />
		<link rel="icon" type="image/png" href="<?=$relRoot?>images/favicon-96x96.png" sizes="96x96" />
		<link rel="apple-touch-icon" href="<?=$relRoot?>images/favicon-120x120.png" /> <!-- 120px -->
		<link rel="apple-touch-icon" href="<?=$relRoot?>images/favicon-180x180.png" sizes="180x180" />
		<link rel="apple-touch-icon" href="<?=$relRoot?>images/favicon-152x152.png" sizes="152x152" />
		<link rel="apple-touch-icon" href="<?=$relRoot?>images/favicon-167x167.png" sizes="167x167" />
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
					&copy; 2014-2017 Daniel Andrus
				</div>
				
			</footer>
		</div>
	</body>
</html>
