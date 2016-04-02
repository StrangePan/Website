<?php $Parsedown = new Parsedown(); ?>
<?php
$projects = array();
foreach (glob("projects/*/project.xml") as $projectFile)
{
	if (!is_file($projectFile)) continue;

	$projectDir = "/" . dirname($projectFile);	
	$xml = new SimpleXMLElement($projectFile, 0, true);

	$project = array();
	foreach ($xml->children() as $property)
	{
		$project[$property->getName()] = $property->__toString();
	}
	if (isset($project['thumbnail'])) {
		$project['thumbnail'] = $projectDir . "/" . $project['thumbnail'];
	}
	$project['url'] = $projectDir;
	$projects[] = $project;
}
?>

<!-- Home page welcome -->
<h1>Projects</h1>

<?php echo $Parsedown->text(file_get_contents("content/projects.md")) ?>

<hr />

<ul class="project-list">
<?php foreach ($projects as $project) { ?>
	<li>
		<a href="<?php echo $project['url'] ?>">
<?php	if (isset($project['thumbnail'])) { ?>
			<img class="thumbnail" src="<?php echo $project['thumbnail'] ?>" />
<?php	} if (isset ($project['name'])) { ?>
			<h2><?php echo $project['name']; ?></h2>
<?php	} ?>
		</a>
	</li>
<?php } ?>
</ul>
