<?php

/*
 * Definition declaring that the engine is indeed the one accessing a file.
 * A simple solution to prevent users from accessing a file directly.
 */
define("ENGINE", 1);

require_once "includes/parsedown/Parsedown.php";

// Site paths and such
$relRoot = "/";
$absRoot = "/";
$pageRoot = "pages/";
$imgRoot = $relRoot."images/";
$templateRoot = $relRoot."templates/composure/";

// Figure out what page to display
$page = isset($_GET["p"]) ? $_GET["p"] : "home";

switch ($page) {
	case "index":
	case "home":
		$page = "home";
		break;

	case "resume":
		$page = "resume";
		break;

	case "blog":
	case "library":
	case "portfolio":
	case "contact":
		$page = "construction";
		break;

	case "projects":
		$page = "projects";
		break;
	
	case "403":
		$page = "403";
		break;

	case "404":
	default:
		$page = "404";
		break;
}

$page = $pageRoot.$page.".php";

include "templates/composure/index.php";
include "content/cowbell.php";
?>
