<?php

if ( $this->message->has_messages() )
{
	echo '<div id="messagebox">';
	$this->message->show();
	echo '</div>';
	$this->message->clear();
}

?>