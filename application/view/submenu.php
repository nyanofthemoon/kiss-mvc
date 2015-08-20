<!-- sub-navigation -->

		<div id="submenu">
			<ul>
			<?php
			if ( $access != User::ADMIN )
			{
				$submenu_items = array(
					'member' => 'logout'
				);
			}
			else
			{
				$submenu_items = array(
					'member' => 'logout'
				);
			}
			foreach($submenu_items as $scontroller => $saction)
			{
				echo '<li';
				if ( $scontroller == $controller && $saction == $action )
				{
					echo ' class="current_page_item_sub"';
				} 
				echo '><a href="' . Controller::url( $scontroller, $saction ) . '">' . Language::action( $saction, $language ) . "</a></li>";
			}
			?>
			</ul>
		</div>
		
		<div class="clear"></div>
	
<!-- sub-navigation -->