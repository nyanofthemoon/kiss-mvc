<!-- sidebar -->

	<div id="sidebar">
		<ul>
			<li>
			<h2><?php echo Language::gettext( 'menu-services' ) ?></h2>
			<br />
			<?php
			foreach($services_items as $k => $saction)
			{
				echo '<a href="' . Controller::url( 'services', $saction ) . '">' . Language::gettext( 'menu-services-' . $saction) . '</a><br /><br />';
			}
			?>
			</li>
		</ul>
	</div>

<!-- sidebar -->