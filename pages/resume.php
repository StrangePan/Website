<?php $pageTitle = "Resume"; ?>
<?php $Parsedown = new Parsedown(); ?>
<div class="button-row">
	<a class="download independent" href="<?=$filesRoot?>resume.pdf" target="_blank" >Download PDF</a>
</div>

<!-- About me information section -->
<article class="document">
	<?=$Parsedown->text(file_get_contents("content/resume.md"))?>
	<footer>
		Last updated <span class="timestamp"><?=date("F d, Y", filemtime("content/resume.md"))?></span>
	</footer>
</article>

<div class="button-row">
	<a class="download independent" href="<?=$filesRoot?>resume.pdf" target="_blank" >Download PDF</a>
</div>
