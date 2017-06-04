<?php
$Parsedown = new Parsedown();
$projects = array();
$projectsRoot = $relRoot . "projects/";
$projectFile = "projects/projects.xml";
if (is_file($projectFile))
{
	$xml = new SimpleXMLElement($projectFile, 0, true);
	foreach ($xml->children() as $projectXml)
	{
		$project = array();
		foreach($projectXml->children() as $property)
		{
			$project[$property->getName()] = $property->__toString();
		}
		if (isset($project['thumbnail']))
		{
			$project['thumbnail'] = $imgRoot . $project['thumbnail'];
		}
		if (isset($project['directory']))
		{
			$project['url'] = $projectsRoot . $project['directory'] . "/";
		}
		$projects[] = $project;
	}
}

$pageTitle = "Projects";
?>

<?=$Parsedown->text(file_get_contents("content/projects.md"))?>

<ul class="project-list">
<?php foreach ($projects as $project) { ?>
	<li>
		<a href="<?=$project['url']?>">
<?php	if (isset($project['thumbnail'])) { ?>
			<img class="thumbnail" src="<?=$project['thumbnail']?>" />
<?php	} if (isset($project['name'])) { ?>
			<h2><?=$project['name']?></h2>
<?php	} ?>
		</a>
	</li>
<?php } ?>
</ul>
