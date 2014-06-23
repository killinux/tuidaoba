<?php
/*
	Plugin Name: WP_FlashTime Widget
	Plugin URI: http://horoscop2009.org/wp-flashtime
	Description: With WP_FlashTime Widget you can add a flash clock to your wordpress.This plugin include 25 different flash clocks.
	Version: 2.1.6
	Author: Horoscop2009.org
	Author URI: http://Horoscop2009.org
	
	Copyright 2009, Horoscop2009.org

	This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

function WP_FlashTime_2009_install () {
	$widgetoptions = get_option('WP_FlashTime2009_widget');
	$newoptions['width'] = '180';
	$newoptions['height'] = '180';
	$newoptions['FlashClock'] = '2';
	add_option('WP_FlashTime2009_widget', $newoptions);
}

function WP_FlashTime_2009_init($content){
	if( strpos($content, '[WP_FlashTime-2009]') === false ){
		return $content;
	} else {
		$code = WP_FlashTime_2009_createflashcode(false);
		$content = str_replace( '[WP_FlashTime-2009]', $code, $content );
		return $content;
	}
}

function WP_FlashTime_2009_insert(){
	echo WP_FlashTime_2009_createflashcode(false);
}

function WP_FlashTime_2009_createflashcode($widget){
	if( $widget != true ){
	} else {
		$options = get_option('WP_FlashTime2009_widget');
		$soname = "widget_so";
		$divname = "wpWP_FlashTime2009widgetcontent";
	}
	if( function_exists('plugins_url') ){ 
		$clocknum = $options['FlashClock'].".swf";
		$movie = plugins_url('wp-flashtime-widget/flash/wp-clock-').$clocknum;
		$path = plugins_url('wp-flashtime-widget/');
	} else {
		$clocknum = $options['FlashClock'].".swf";
		$movie = get_bloginfo('wpurl') . "/wp-content/plugins/wp-flashtime-widget/flash/wp-clock-".$clocknum;
		$path = get_bloginfo('wpurl')."/wp-content/plugins/wp-flashtime-widget/";
	}

	$flashtag = '<script type="text/javascript" src="'.$path.'swfobject.js"></script>';	
	$flashtag .= '<script type="text/javascript">swfobject.registerObject("FlashTime", "8.0.0", "'.$path.'expressInstall.swf");</script>';
	$flashtag .= '<center><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'.$options['width'].'" height="'.$options['height'].'" id="FlashTime" align="middle">';
	$flashtag .= '<param name="movie" value="'.$movie.'" /><param name="menu" value="false" /><param name="wmode" value="transparent" /><param name="allowscriptaccess" value="always" />';
	$flashtag .= '<!--[if !IE]>--><object type="application/x-shockwave-flash" data="'.$movie.'" width="'.$options['width'].'" height="'.$options['height'].'" align="middle"><param name="menu" value="false" /><param name="wmode" value="transparent" /><param name="allowscriptaccess" value="always" /><!--<![endif]-->';
	$flashtag .= '<p><a href="http://horoscop2009.org">horoscop 2009</a> <a href="http://www.vidics.com">free online movies</a> <a href="http://horoscop2010.net">horoscop 2010</a> | <a href="http://horoscop2009.org/category/horoscop-saptamanal">horoscop saptamanal</a> | <a href="http://horoscop2009.org/category/horoscop-zilnic">horoscop zilic</a> | <a href="http://horoscopnet.ro">horoscop</a> | </p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a><!--[if !IE]>--></object><!--<![endif]--></object></center>';
	return $flashtag;
}


function WP_FlashTime_2009_uninstall () {
	delete_option('WP_FlashTime2009_widget');
}


function widget_init_WP_FlashTime_2009_widget() {
	if (!function_exists('register_sidebar_widget'))
		return;

	function WP_FlashTime_2009_widget($args){
	    extract($args);
		$options = get_option('WP_FlashTime2009_widget');
		$title = empty($options['title']) ? __('WP_FlashTime Widget') : $options['title'];
		?>
	        <?php echo $before_widget; ?>
				<?php echo $before_title . $title . $after_title; ?>
				<?php 
					if( !stristr( $_SERVER['PHP_SELF'], 'widgets.php' ) ){
						echo WP_FlashTime_2009_createflashcode(true);
					}
				?>
	        <?php echo $after_widget; ?>
		<?php
	}
	
	function WP_FlashTime_2009_widget_control() {
		$options = $newoptions = get_option('WP_FlashTime2009_widget');
		if ( $_POST["WP_FlashTime2009_widget_submit"] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST["WP_FlashTime2009_widget_title"]));
			$newoptions['width'] = strip_tags(stripslashes($_POST["WP_FlashTime2009_widget_width"]));
			$newoptions['height'] = strip_tags(stripslashes($_POST["WP_FlashTime2009_widget_height"]));
			$newoptions['FlashClock'] = strip_tags(stripslashes($_POST["WP_FlashTime2009_widget_FlashClock"]));
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('WP_FlashTime2009_widget', $options);
		}
		$title = attribute_escape($options['title']);
		$width = attribute_escape($options['width']);
		$height = attribute_escape($options['height']);
		$FlashClock = attribute_escape($options['FlashClock']);
		?>
			<p><label for="WP_FlashTime2009_widget_title"><?php _e('Title:'); ?> <input class="widefat" id="WP_FlashTime2009_widget_title" name="WP_FlashTime2009_widget_title" type="text" value="<?php echo $title; ?>" /></label></p>
			<p><label for="WP_FlashTime2009_widget_width"><?php _e('Width:'); ?> <input class="widefat" id="WP_FlashTime2009_widget_width" name="WP_FlashTime2009_widget_width" type="text" value="<?php echo $width; ?>" /></label></p>
			<p><label for="WP_FlashTime2009_widget_height"><?php _e('Height:'); ?> <input class="widefat" id="WP_FlashTime2009_widget_height" name="WP_FlashTime2009_widget_height" type="text" value="<?php echo $height; ?>" /></label></p>
			<p><label for="WP_FlashTime2009_widget_FlashClock"><?php _e('**Clock Number:'); ?> <input class="widefat" id="WP_FlashTime2009_widget_FlashClock" name="WP_FlashTime2009_widget_FlashClock" type="text" value="<?php echo $FlashClock; ?>" /></label></p>
			<p>**Check this for clocks styles : <a href="http://horoscop2009.org/wp-flashtime">Clock Number</a></p>
			
			<input type="hidden" id="WP_FlashTime2009_widget_submit" name="WP_FlashTime2009_widget_submit" value="1" />
		<?php
	}
	
	register_sidebar_widget( "WP_FlashTime Widget", WP_FlashTime_2009_widget );
	register_widget_control( "WP_FlashTime Widget", "WP_FlashTime_2009_widget_control" );
}

function flashtime_add_options_page() 
{
	add_options_page('FlashTime Optons', 'FlashTime', 8, 'wp-flashtime.php','FlashTimeDisply');
}

if ( function_exists("is_plugin_page") && is_plugin_page() ) {
	FlashTimeDisply(); 
	return;
}
function FlashTimeDisply() {

echo <<<END
<h2>FlashTime Widget</h2>
<p>Go to Appearance->Widgets page to add the FlashTime widget.</p>
END;
}

add_action('admin_menu', 'flashtime_add_options_page');
add_action('widgets_init', 'widget_init_WP_FlashTime_2009_widget');
add_filter('the_content','WP_FlashTime_2009_init');
register_activation_hook( __FILE__, 'WP_FlashTime_2009_install' );
register_deactivation_hook( __FILE__, 'WP_FlashTime_2009_uninstall' );
?>
