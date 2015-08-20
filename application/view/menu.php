<!-- navigation -->

		<div id="menu">
			<ul>
			<?php
			$menu_items = array(
				 'home' => 'welcome'
			);
			foreach($menu_items as $mcontroller => $maction)
			{
				echo '<li';
				if ( $mcontroller == $controller )
				{
					echo ' class="current_menu_item"';
				} 
				echo ' style="width:33%"><a href="' . Controller::url( $mcontroller, $maction ) . '" id="menu-' . $mcontroller . '">' . Language::gettext( 'menu-' . $mcontroller, $language ) . "</a></li>";
			}
			?>
			</ul>
		</div>
		<?php
			if ($language==Language::FRENCH)
			{
				$services_items = array(
				 'menu un'
				,'menu deux'
				,'menu trois'
				);
			}
			else
			{
				$services_items = array(
				 'menu one'
				,'menu two'
				,'menu three'
				);
			}
		?>
		<div id="services-list" class="menu-submenu">
			<ul>
				<?php
				foreach($services_items as $saction)
				{
					echo '<li';
					if ( $saction == $action )
					{
						echo ' class="current_menu_item"';
					}
					echo '><a href="' . Controller::url( 'services', $saction ) . '">' . Language::gettext( 'menu-services-' . $saction) . '</a></li>';
				}
				?>
			</ul>
		</div>
		<script type="text/javascript">
		$(document).ready(function () {
    		$('#menu-services').click(function () {
    			if ($('#services-list').is(':visible')) {
        			$('#services-list').fadeOut();
        		} else {
        			$('#services-list').fadeIn();
        		}
        		return false;
    		});
    		$(document).click(function () {
        		$('#services-list').fadeOut();
    		});
		});
		</script>

<!-- navigation -->