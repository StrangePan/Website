<?php if (isset($_GET["cowbell"]) || (isset($cowbell) && $cowbell)) { ?>
<style>
.cowbell {
	position: fixed;
	z-index: -1;
}
</style>
<script type="text/javascript">
spawnCowbell = function() {
	var cowbell = document.createElement("img");
	cowbell.setAttribute("src", "<?=$imgRoot?>cowbell.svg");
	cowbell.className = "cowbell";
	cowbell.style.width = (5 + Math.random() * 15) + "%";
	cowbell.style.left = ((0.1 + Math.random() * 0.6) * 100) + "%";
	cowbell.style.top = ((0.1 + Math.random() * 0.6) * 100) + "%";
	cowbell.style.opacity = "0.0";
	document.body.appendChild(cowbell);
	var translateAngle = Math.random() * Math.PI * 2;
	var translateDist = 250;
	var deltaLeft = Math.cos(translateAngle) * translateDist;
	var deltaTop = Math.sin(translateAngle) * translateDist;
	var startAngle = Math.random() * 360;
	var deltaAngle = 15 * ((Math.floor(Math.random() * 2) * 2) - 1);
	var opacity = 0.15;
	var animationStart = new Date().getTime();
	var animationDuration = 20000;
	var motionInterval = setInterval(function() {
		var animTime = new Date().getTime() - animationStart;
		var animScale = animTime / animationDuration;
		if (animTime < 1000) {
			cowbell.style.opacity = "" + ((animTime / 1000) * opacity);
		} else if (animTime > animationDuration - 1000) {
			cowbell.style.opacity = "" + (((animationDuration - animTime) / 1000) * opacity);
		} else {
			cowbell.style.opacity = "" + opacity;
		}
		cowbell.style.transform = (
			"rotate(" + (startAngle + deltaAngle * animScale) + "deg) "
			+ "translate("
				+ (deltaLeft * animScale) + "px,"
				+ (deltaTop * animScale) + "px)");
		if (animTime > animationDuration) {
			clearInterval(motionInterval);
			cowbell.remove();
		}
	}, 20);
}
setInterval(spawnCowbell, 3500);
</script>
<?php } ?>