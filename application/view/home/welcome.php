<?php include( VIE . 'header'. EXT ) ?>

<!-- content -->

	<img src="/img/welcome.jpg" width="878" height="290" style="margin-bottom:25px">
	<div id="content">
		<div class="post">
			<h1 class="title"><?php echo Language::gettext( 'home-welcome-header' ) ?></h1>
			<div class="entry">
				<?php echo Language::gettext( 'home-welcome-text' ) ?>
			</div>
			<br />
		</div>
	</div>

	<?php include( VIE . '/home/sidebar'. EXT ) ?>

	<div class="clear"></div>

<!-- content -->

<?php include( VIE . 'footer'. EXT ) ?>