<?php $Parsedown = new Parsedown(); ?>

<a class="download independent" href="files/resume.pdf" target="_blank" />Download PDF</a>

<!-- About me information section -->
<article class="document">
	<?php echo $Parsedown->text(file_get_contents("content/resume.md")) ?>
	<footer>
		Last updated <span class="timestamp"><?php echo date("F d, Y", filemtime("content/resume.md")); ?></span>
	</footer>
</article>

<a class="download independent" href="files/resume.pdf" target="_blank" />Download PDF</a>
