<?php
	require_once('html_pageSetup.php');
	require_once('cts-schedule.php');
	require_once('topnav.php');
?>
<!DOCTYPE html>

<html lang="en">
		<?php html_head(); ?>
		<header>
			<?php displayNav(); ?>
			<div class="cts-page-title">Upcoming Performances:</div>
		</header>
		<body>
		<div class="cts-main-content">
			<div id="php-schedule">
				<ul>
					<?php formatCalEvents($cal); ?>
				</ul>	
			</div>
		</div>
	</body>
</html>
