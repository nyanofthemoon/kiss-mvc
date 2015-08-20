<?php
	$logged_in  = Session::isLoggedIn();
	$user       = Session::getUser();
	$access     = Session::getUserAccess();
	$language   = Session::get( Cookie::LANGUAGE );
	$controller = Language::controller( Session::get( Cookie::CONTROLLER ), $language, true );
	$action     = Language::action( Session::get( Cookie::ACTION ), $language, true );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo Language::gettext('website-header') . ' - ' . Language::gettext('website-sub-header') . ' :: ' . ucwords( Language::controller( $controller ) ) . ' - ' . ucwords( str_replace( '-', ' ',  Language::action( $action ) ) ) ?></title>
	<meta name="keywords" content="<?php echo Language::gettext('meta-keywords', array($controller, $action)) ?>" />
	<meta name="description" content="<?php echo Language::gettext('meta-description', array($controller, $action)) ?>" />
	<?php
		foreach( $this->head_css as $css )
		{
			if ( !empty( $css['browser'] ) )
			{
				echo '<link rel="stylesheet" type="text/css" href="' . CSS . $this->browser . '/' . $css['file'] . '.css"/>';
			}
			else
			{
				echo '<link rel="stylesheet" type="text/css" href="' . CSS . $css['file'] . '.css"/>';
			}
		}
	?>
	<?php
		foreach( $this->head_script as $js )
		{
			echo '<script language="javascript" src="' . JS . $js . '.js"></script>';
		}
	?>
	<link rel="shortcut icon" href="/img/icon.ico">
</head>

<body>

<!-- header -->

<a name="top"></a>

<div id="wrapper">
	<div id="logo">
		<a href="/"><h1><span style="float:left"><?php echo Language::gettext( 'website-header' ) ?></span><span style="float:right"><?php echo Language::gettext( 'website-motto' ) ?></span></h1></a>
		<div class="clear"></div>
		<h2><?php echo Language::gettext( 'website-sub-header' ) ?></h2>
   		<h3 style="float:left"><?php echo $this->breadcrumb->generate() ?></h3>
		<h3>[&nbsp;
			<?php
			$register_link = '';
   			if ( !$logged_in )
    		{
    			$status = 'login';
   			}
    		else
    		{
    			$status = 'logout';
    		}
    		echo '<a href="' . Controller::url( 'member', $status ) . '">'. Language::gettext( 'header-' . $status ) . '</a>';
   			?>
   			&nbsp;|&nbsp;
			<?php 
   			if ( $this->language == Language::FRENCH )
    		{
    			$label = Language::gettext( Language::ENGLISH, null, Language::ENGLISH );
    			$change = Language::ENGLISH;
   			}
    		else
    		{
    			$label = Language::gettext( Language::FRENCH, null, Language::FRENCH );
    			$change = Language::FRENCH;
    		}
    		echo '<a href="/' . $change . '">'. $label . '</a>';
   			?>
   			&nbsp;]
   		</h3>
	</div>
	<div id="header">
		<?php
			include( VIE . 'menu' . EXT );
			if ( $logged_in )
			{
				include( VIE . 'submenu' . EXT );
			}
		?>
	</div>
</div>

<!-- header -->

<div id="page">
	
	<?php include( VIE . 'message' . EXT ); ?>