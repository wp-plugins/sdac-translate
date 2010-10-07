<?php
/*
Plugin Name: SDAC Translate
Plugin URI: http://www.sandboxdev.com/blog-and-cms-development/wordpress/wordpress-plugins/
Description: Offer simple and lightweight site translation using <a href="http://translate.google.com/" target="_blank">Google Translate</a> with this sidebar widget.
Author: Jennifer Zelazny/SDAC Inc.
Version: 1.1
Author URI: http://www.sandboxdev.com/
*/


# HOUSE CLEANING
if ( function_exists('register_deactivation_hook') ) { 
	register_deactivation_hook( __FILE__, 'sdac_translate_cleanup_hook' );
}

# CLEAN UP OPTIONS TABLE WHEN THE PLUGIN IS DEACTIVATED
function sdac_translate_cleanup_hook() {
	delete_option( 'sdac_translate' );
}


# INIT PLUGINS OPTIONS
add_action( 'admin_init', 'sdac_translate_init' );
function sdac_translate_init(){
	register_setting( 'sdac_translate', 'sdac_translate', 'sdac_translate_validate' );
}

# ADD MENU
add_action( 'admin_menu', 'sdac_translate_add_page' );
function sdac_translate_add_page() {
	$sdac_translate = add_options_page( 'SDAC Translate', 'SDAC Translate', 'manage_options', 'sdac_translate', 'sdac_translate_do_page' );
	add_action( "admin_head-$sdac_translate", 'sdac_translate_admin_js' );
	add_action( "admin_print_scripts-$sdac_translate", 'sdac_translate_admin_enqueue_js' );
	add_action( "admin_print_styles-$sdac_translate", 'sdac_translate_admin_css' );
}

# CUSTOM ADMIN CSS
function sdac_translate_admin_css() {
	wp_enqueue_style( 'sdac-translate-css', plugins_url( 'css/sdac-translate.css', __FILE__ ) );
	wp_enqueue_style( 'sdac-translate-admin-css', plugins_url( 'css/sdac-translate_admin.css', __FILE__ ) );
}

# CUSTOM ADMIN JS
function sdac_translate_admin_js() {
	echo '
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$("#sdac_translate").accordion({ autoHeight:false });
				$("#check_all").click( function(){
 					var checkedValue = $(this).attr("checked");
 					$("input.checked").attr("checked", checkedValue); });
				}); 
		</script>
		';
}

# CUSTOM ADMIN JS
function sdac_translate_admin_enqueue_js() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-widget', plugins_url().'/sdac-translate/js/jquery.ui.widget.js' );
	wp_enqueue_script( 'jquery-accordion', plugins_url().'/sdac-translate/js/jquery.ui.accordion.js' );
}

// Set Up All Countries Used
$countries = array(
	array( 'lang' => 'Albanian', 'lang_code' => 'sq' ),	
	array( 'lang' => 'Arabic', 'lang_code' => 'ar'),	
	array( 'lang' => 'Bulgarian', 'lang_code' => 'bg'),	
	array( 'lang' => 'Catalan', 'lang_code' => 'ca' ),	
	array( 'lang' => 'Chinese Simplified', 'lang_code' => 'zh-CN' ),	
	array( 'lang' => 'Chinese Traditional', 'lang_code' => 'zh-TW' ),	
	array( 'lang' => 'Croatian', 'lang_code' => 'hr' ),	
	array( 'lang' => 'Czech', 'lang_code' => 'cs' ),	
	array( 'lang' => 'Danish', 'lang_code' => 'da' ),	
	array( 'lang' => 'Dutch', 'lang_code' => 'nl' ),	
	array( 'lang' => 'Estonian', 'lang_code' => 'et' ),	
	array( 'lang' => 'Filipino', 'lang_code' => 'tl' ),	
	array( 'lang' => 'Finnish', 'lang_code' => 'fi' ),	
	array( 'lang' => 'French', 'lang_code' => 'fr' ),	
	array( 'lang' => 'Galician', 'lang_code' => 'gl' ),	
	array( 'lang' => 'German', 'lang_code' => 'de' ),	
	array( 'lang' => 'Greek', 'lang_code' => 'el' ),	
	array( 'lang' => 'Hebrew', 'lang_code' => 'iw' ),
	array( 'lang' => 'Hindi', 'lang_code' => 'hi' ),
	array( 'lang' => 'Hungarian', 'lang_code' => 'hu' ),
	array( 'lang' => 'Indonesian', 'lang_code' => 'id' ),
	array( 'lang' => 'Italian', 'lang_code' => 'it' ),
	array( 'lang' => 'Japanese', 'lang_code' => 'ja' ),
	array( 'lang' => 'Korean', 'lang_code' => 'ko' ),
	array( 'lang' => 'Lativian', 'lang_code' => 'lv' ),
	array( 'lang' => 'Lithuanian', 'lang_code' => 'lt' ),
	array( 'lang' => 'Maltese', 'lang_code' => 'mt' ),
	array( 'lang' => 'Norwegian', 'lang_code' => 'no' ),
	array( 'lang' => 'Polish', 'lang_code' => 'pl' ),
	array( 'lang' => 'Portuguese', 'lang_code' => 'pt' ),
	array( 'lang' => 'Romanian', 'lang_code' => 'ro' ),
	array( 'lang' => 'Russian', 'lang_code' => 'ru' ),	
	array( 'lang' => 'Serbian', 'lang_code' => 'sr' ),
	array( 'lang' => 'Slovak', 'lang_code' => 'sk' ),
	array( 'lang' => 'Slovenian', 'lang_code' => 'sl' ),
	array( 'lang' => 'Spanish', 'lang_code' => 'es' ),
	array( 'lang' => 'Swedish', 'lang_code' => 'sv' ),
	array( 'lang' => 'Thai', 'lang_code' => 'th' ),
	array( 'lang' => 'Turkish', 'lang_code' => 'tr' ),
	array( 'lang' => 'Ukrainian', 'lang_code' => 'uk' ),	
	array( 'lang' => 'Vietnamese', 'lang_code' => 'vi' )
);

// Draw the menu page itself
function sdac_translate_do_page() {
	global $countries;
  	?>
	<div class="wrap">
		<h2>SDAC Translate Options</h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'sdac_translate' ); ?>
			<?php $sdac_translate = get_option( 'sdac_translate' ); ?>
			
			<div id="sdac_translate">
				<h3><a href="#">Widget Settings</a></h3>
				<div id="widget_settings" class="sdac_translate_option">
					<p>Use the options below to best configure your translation widget then <a href="<?php bloginfo('url'); ?>/wp-admin/widgets.php" title="Activate this widget">activate the widget</a> and enjoy!</p>
					<div class="item">
						<label>Show Flags/Text:</label>
						<select name="sdac_translate[show_type]">
							<option value="<?php echo $sdac_translate['show_type'];?>"><?php echo esc_attr( $sdac_translate['show_type'] );?></option>
							<option value="">-------</option>
							<option value="Flags">Flags</option>
							<option value="Text">Text</option>
							<option value="Both">Both</option>
						</select>	
					</div>
					<div class="item check">
						<div id="country_options">
							<h4>Countries:</h4>
							<h5><input type="checkbox" id="check_all" /> Check/Uncheck All</h5>
						</div>
						<div class="clearjz"></div>
						<?php foreach ( $countries as $country ):?>
							<div class="country_option">
								<input type="hidden" name="sdac_translate[<?php echo $country['lang'].'_show';?>]" value="hide" />
								<input type="checkbox" class="checked" name="sdac_translate[<?php echo $country['lang'].'_show';?>]" value="show"<?php if ( $sdac_translate[''.$country['lang'].'_show'] == 'show') :?> checked="yes"<?php endif;?> />
								<label><span class="sdac_flag" id="<?php echo $country['lang_code'];?>"><?php echo $country['lang'];?></span></label>
							</div>
						<?php endforeach;?>
						<div class="clearjz"></div>
					</div>
					<div class="clearjz"></div>
					<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
				</div>
				<h3><a href="#">Support &amp; Customization</a></h3>
				<div id="support" class="sdac_translate_option">
					<ul>
				 		<li>Free support for SDAC Plugins is available in the SDAC Inc. Support Forums: <a href="http://www.sandboxdev.com/forums/" target="_blank">http://www.sandboxdev.com/forums/</a></li>
				 		<li>Paid Customizations are also available for the SDAC Plugins.  Please contact us with your needs and we will give you a free estimate: <a href="http://www.sandboxdev.com/contact-us/" target="_blank">http://www.sandboxdev.com/contact-us/</a></li>
					</ul>
				</div>
		</form>					
	</div>
	<?php	
}


//Translation Widget
class sdac_translate_widget extends WP_Widget {
    function  sdac_translate_widget() {
        parent::WP_Widget( false, $name = 'SDAC Translate' );	
    }
	function widget($args, $instance) {		
        global $countries;
        $sdac_translate = get_option( 'sdac_translate' );
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        ?>
       <?php echo $before_widget; ?>
       <?php if ( $title ) echo $before_title . $title . $after_title; ?>
			
		<?php
			// Cached Output
			$translate = wp_cache_get( 'sdac_translate', 'sdac_translate_cache' ); 
			if ( !$translate ) {
				$translate .= '<ul id="sdac_translate">'."\n";
					foreach ( $countries as $country ) {
						if ( $sdac_translate[''.$country['lang'].'_show'] == 'show' ) {
							if ( $sdac_translate['show_type'] == 'Text' ) {
								$translate .= '<li><a href="http://translate.google.com/translate?hl=en&langpair=en|'.$country['lang_code'].'&u='.get_bloginfo('url').'" title="'.$country['lang'].'">'.$country['lang'].'</a></li>'."\n";
							} elseif ( $sdac_translate['show_type'] !== 'Text' ) {
								if ( $sdac_translate['show_type'] == 'Both' ) {
									$translate .= '<li><a class="sdac_flag" id="'.$country['lang_code'].'" href="http://translate.google.com/translate?hl=en&langpair=en|'.$country['lang_code'].'&u='.get_bloginfo('url').'" title="'.$country['lang'].'">'.$country['lang'].'</a></li>'."\n";
								} else {
									$translate .= '<li class="flags_only"><a class="sdac_flag" id="'.$country['lang_code'].'" href="http://translate.google.com/translate?hl=en&langpair=en|'.$country['lang_code'].'&u='.get_bloginfo('url').'" title="'.$country['lang'].'"></a></li>'."\n";
								}
							}
						}
					}
					$translate .='</ul>'."\n";
					wp_cache_set( 'sdac_translate', $translate, 'sdac_translate_cache', 86400 );
			}	
			echo $translate;
		?>
			  		
       <?php echo $after_widget; ?>
         
        <?php
    }
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }
    function form($instance) {				
        $title = esc_attr($instance['title']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        	<p style="font-weight:bold;font-size:.9em;"><a href="<?php bloginfo('url');?>/wp-admin/options-general.php?page=sdac_translate" title="Set all options">SDAC Translate Widget Options &raquo;</a></p>
        <?php 
    }
}
add_action('widgets_init', create_function('', 'return register_widget("sdac_translate_widget");'));


function sdac_translate_validate( $input ) {
	global $countries;
	do_action( 'sdac_translate_validate');
	
	foreach ( $countries as $country ) {
		$input['show_type'] = esc_attr( $input['show_type'] );
		$input[''.$country['lang'].'_show'] = esc_attr( $input[''.$country['lang'].'_show'] );
	}
	return $input;
}

# INVALIDATE THE CACHE WHEN THE OPTIONS UPDATE
add_action( 'sdac_translate_validate', 'sdac_invalidate_custom_caches', 1, 2 );
function sdac_invalidate_custom_caches() {
	$sdac_translate = get_option( 'sdac_translate' );
	wp_cache_delete( 'sdac_translate', 'sdac_translate_cache' );
}


# LOAD STANDARD STYLES IN HEADER
add_action( 'wp_print_styles', 'sdac_translate_styles' );
function sdac_translate_styles() {
	wp_enqueue_style( 'sdac-translate-css', plugins_url( 'css/sdac-translate.css', __FILE__ ) );
}

# LOAD CUSTOM STYLES IN HEADER
add_action( 'wp_head', 'sdac_translate_css' );
function sdac_translate_css() {
	$sdac_translate = get_option( 'sdac_translate' );
	if ( $sdac_translate['show_type'] == 'Text' ) {
		$styles .= 'ul#sdac_translate li {float:left;width:49%;margin-right:10px;background:none !important;margin:0 !important;padding:0 !important;font-size:90% !important;}';
	}
	else if ( $sdac_translate['show_type'] !== 'Text' ) {
		$styles .= '#sdac_translate a.sdac_flag {float:left !important;display:block !important;background: url('.plugins_url( 'images/flags.gif', __FILE__ ).'); background-repeat:no-repeat  !important;height:11px !important;line-height:11px !important;margin-left:5px !important;padding-left:20px !important;}';
		
		if ( $sdac_translate['show_type'] == 'Both' ) {
			$styles .= 'ul#sdac_translate li {float:left;width:49%;margin-right:10px;background:none !important;font-size:90% !important;margin:0 0 10px 0 !important;padding:0 !important;}';
			$styles .= '#sdac_translate a.sdac_flag {float:left !important;display:block !important;background: url('.plugins_url( 'images/flags.gif', __FILE__ ).'); background-repeat:no-repeat  !important;height:11px !important;line-height:11px !important;margin-left:5px !important;padding-left:20px !important;}';
		} 
		else if ( $sdac_translate['show_type'] == 'Flags' ) {
			$styles .= 'ul#sdac_translate li.flags_only {background:none !important;float:left;width:25px !important;height:11px !imporant;margin:0 0 10px 0 !important;padding:0 !important;}';
		}
	}
	echo '
		<style type="text/css">
			'.$styles.'
		</style>
		';
}		

