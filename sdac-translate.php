<?php
/*
Plugin Name: SDAC Translate
Plugin URI: http://www.sandboxdev.com/blog-and-cms-development/wordpress/wordpress-plugins/
Description: Offer simple and lightweight site translation using <a href="http://translate.google.com/" target="_blank">Google Translate</a> with this sidebar widget.
Author: Jennifer Zelazny/SDAC Inc.
Version: 1.0.2
Author URI: http://www.sandboxdev.com/
*/


// House cleaning
if ( function_exists('register_deactivation_hook') ) { 
	register_deactivation_hook( __FILE__, 'sdac_translate_cleanup_hook');
}

//Clean up options table when deactivated	
function sdac_translate_cleanup_hook() {
	delete_option('sdac_translate');
}


// Plugin location
$sdac_plugin_directory_slug = '/' . basename( dirname( __FILE__ ) ); 
if ( function_exists('wpcom_is_vip')  || function_exists('wp_is_sdac')) { 
	$sdac_plugin_url = get_bloginfo('template_url').'/plugins/'.$sdac_plugin_directory_slug;
} else {
	$sdac_plugin_url = WP_PLUGIN_URL . $sdac_plugin_directory_slug;
}

//Custom Shared CSS
function sdac_translate_shared_css() {
	$styles = '
		#sdacTranslate .sdacFlag {height:11px !important;line-height:11px !important;margin-top:3px;}
		#sdacTranslate .sdacFlag#sq {background-position: 0 0;} #sdacTranslate .sdacFlag#ar {background-position: 0 -11px;}
		#sdacTranslate .sdacFlag#bg {background-position: 0 -22px;} #sdacTranslate .sdacFlag#ca {background-position: 0 -33px;}
		#sdacTranslate .sdacFlag#zh-CN {background-position: 0 -44px;} #sdacTranslate .sdacFlag#zh-TW {background-position: 0 -44px;} 
		#sdacTranslate .sdacFlag#hr {background-position: 0 -55px;} #sdacTranslate .sdacFlag#cs {background-position: 0 -66px;}
		#sdacTranslate .sdacFlag#da {background-position: 0 -77px;} #sdacTranslate .sdacFlag#nl {background-position: 0 -88px;}
		#sdacTranslate .sdacFlag#et {background-position: 0 -99px;} #sdacTranslate .sdacFlag#tl {background-position: 0 -110px;} 
		#sdacTranslate .sdacFlag#fi {background-position: 0 -121px;} #sdacTranslate .sdacFlag#fr {background-position: 0 -132px;}
		#sdacTranslate .sdacFlag#gl {background-position: 0 -143px;} #sdacTranslate .sdacFlag#de {background-position: 0 -154px;}
		#sdacTranslate .sdacFlag#el {background-position: 0 -165px;} #sdacTranslate .sdacFlag#iw {background-position: 0 -176px;}
		#sdacTranslate .sdacFlag#hi {background-position: 0 -187px;} #sdacTranslate .sdacFlag#hu {background-position: 0 -198px;} 
		#sdacTranslate .sdacFlag#id {background-position: 0 -209px;} #sdacTranslate .sdacFlag#it {background-position: 0 -220px;} 
		#sdacTranslate .sdacFlag#ja {background-position: 0 -231px;} #sdacTranslate .sdacFlag#ko {background-position: 0 -242px;} 
		#sdacTranslate .sdacFlag#lv {background-position: 0 -253px;} #sdacTranslate .sdacFlag#lt {background-position: 0 -264px;} 
		#sdacTranslate .sdacFlag#mt {background-position: 0 -275px;} #sdacTranslate .sdacFlag#no {background-position: 0 -286px;} 
		#sdacTranslate .sdacFlag#pl {background-position: 0 -297px;} #sdacTranslate .sdacFlag#pt {background-position: 0 -308px;} 
		#sdacTranslate .sdacFlag#ro {background-position: 0 -319px;} #sdacTranslate .sdacFlag#ru {background-position: 0 -330px;} 
		#sdacTranslate .sdacFlag#sr {background-position: 0 -341px;} #sdacTranslate .sdacFlag#sk {background-position: 0 -352px;} 
		#sdacTranslate .sdacFlag#sl {background-position: 0 -363px;} #sdacTranslate .sdacFlag#es {background-position: 0 -374px;} 
		#sdacTranslate .sdacFlag#sv {background-position: 0 -385px;} #sdacTranslate .sdacFlag#th {background-position: 0 -396px;} 
		#sdacTranslate .sdacFlag#tr {background-position: 0 -407px;} #sdacTranslate .sdacFlag#uk {background-position: 0 -418px;} 
		#sdacTranslate .sdacFlag#vi {background-position: 0 -429px;}
	';
	return $styles;
}

//Custom Admin CSS
function sdac_translate_admin_css_js() {
	global $sdac_plugin_url;
	echo '
		<style type="text/css">
			#sdacTranslate fieldset {border:1px solid #aaa; margin-bottom:15px; padding:10px 10px 20px 20px; width:725px;}
			#sdacTranslate fieldset legend {text-transform:uppercase;font-weight:bold;}
			#sdacTranslate textarea {padding:1px;border:1px solid #aaa;width:585px;height:205px;}
			#sdacTranslate label {font-weight:bold;float:left;width:150px;}
			#sdacTranslate .check p {float:left;display:inline;width:175px;margin-right:5px;}
			#sdacTranslate .check label {font-weight:bold;float:none;width:auto}
			#sdacTranslate input.text, #sdacTranslate select {width:150px;border:1px solid #bbb;padding:2px;}
			#sdacTranslate .item {border-bottom:1px dashed #bbb;padding:10px 0 10px 0;}
			#sdacTranslate .item h4 {float:left;display:inline;width:400px;margin:0;padding:0;}
			#sdacTranslate .item h5 {float:right;display:inline;margin:0;padding:0;}
			#sdacTranslate #countryOptions {border-bottom:1px dashed #bbb;padding:10px 0 10px 0;height:25px}
			.clearjz {clear:both;}
			#sdacTranslate p.countryOption input {float:left;width:auto;}
			#sdacTranslate .item p.countryOption span {float:left;display:block;background: url('.$sdac_plugin_url.'/flags.gif) no-repeat;height:11px;line-height:11px;margin-left:5px;padding-left:20px;}
			#sdacTranslate .sdacFlag {margin-top:2px;}
			.wp-admin #sdacTranslate .item p.countryOption span {height:16px;line-height:16px !important;}
			'.sdac_translate_shared_css().'
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$("#checkAll").click( function(){
 					var checkedValue = $(this).attr("checked");
 					$("input.checked").attr("checked", checkedValue); });
				}); 
		</script>
		';
}

//Custom Admin JS
function sdac_translate_admin_enqueue_js() {
	wp_enqueue_script('jquery');
}

add_action('admin_init', 'sdac_translate_init' );
add_action('admin_menu', 'sdac_translate_add_page');


// Init plugin options to white list our options
function sdac_translate_init(){
	register_setting( 'sdac_translate_options', 'sdac_translate', 'sdac_translate_validate');
}

// Add menu page
function sdac_translate_add_page() {
	$sdac_translate = add_options_page('SDAC Translate', 'SDAC Translate', 'manage_options', 'sdac_translate_options', 'sdac_translate_options_do_page');
	add_action( "admin_print_scripts-$sdac_translate", 'sdac_translate_admin_enqueue_js' );
	add_action( "admin_head-$sdac_translate", 'sdac_translate_admin_css_js' );
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
	array( 'lang' => 'Vietnamese', 'lang_code' => 'vi' ),	
);

// Draw the menu page itself
function sdac_translate_options_do_page() {
	global $countries;
  	?>
	<div id="sdacTranslate" class="wrap">
		<h2>SDAC Translate Options</h2>
		<form method="post" action="options.php">
			<?php settings_fields('sdac_translate_options'); ?>
			<?php $sdac_translate_options = get_option('sdac_translate'); ?>
			<fieldset>
				<legend>Widget Settings</legend>
					<p>Use the options below to best configure your translation widget then <a href="<?php bloginfo('url'); ?>/wp-admin/widgets.php" title="Activate this widget">activate the widget</a> and enjoy!</p>
					<div class="item">
						<label>Show Flags/Text:</label>
						<select name="sdac_translate[show_type]">
							<option value="<?php echo $sdac_translate_options['show_type'];?>"><?php echo esc_attr( $sdac_translate_options['show_type'] );?></option>
							<option value="">-------</option>
							<option value="Flags">Flags</option>
							<option value="Text">Text</option>
							<option value="Both">Both</option>
						</select>	
					</div>
					<div class="item check">
						<div id="countryOptions">
							<h4>Countries:</h4>
							<h5><input type="checkbox" id="checkAll" /> Check/Uncheck All</h5>
						</div>	
						<?php foreach ( $countries as $country ):?>
							<p class="countryOption">
								<input type="hidden" name="sdac_translate[<?php echo $country['lang'].'_show';?>]" value="hide" />
								<input type="checkbox" class="checked" name="sdac_translate[<?php echo $country['lang'].'_show';?>]" value="show"<?php if ( $sdac_translate_options[''.$country['lang'].'_show'] == 'show') :?> checked="yes"<?php endif;?> />
								<label><span class="sdacFlag" id="<?php echo $country['lang_code'];?>"><?php echo $country['lang'];?></span></label>
							</p>
						<?php endforeach;?>
						<div class="clearjz"></div>
					</div>
				</fieldset>
				<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
		</form>					
	</div>
	<?php	
}


//Translation Widget
class sdac_translate_widget extends WP_Widget {
    function  sdac_translate_widget() {
        parent::WP_Widget(false, $name = 'SDAC Translate');	
    }
	function widget($args, $instance) {		
        global $countries;
        $sdac_translate_options = get_option('sdac_translate');
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        ?>
       <?php echo $before_widget; ?>
       <?php if ( $title ) echo $before_title . $title . $after_title; ?>
			
		<?php
			// Cached Output
			$translate = wp_cache_get('sdac_translate_options', 'sdac_translate_cache'); 
			if ( !$translate ) {
				$translate .= '<ul id="sdacTranslate">'."\n";
					foreach ( $countries as $country ) {
						if ( $sdac_translate_options[''.$country['lang'].'_show'] == 'show') {
							if ( $sdac_translate_options['show_type'] == 'Text' ) {
								$translate .= '<li><a href="http://translate.google.com/translate?hl=en&langpair=en|'.$country['lang_code'].'&u='.get_bloginfo('url').'" title="'.$country['lang'].'">'.$country['lang'].'</a></li>'."\n";
							} elseif ( $sdac_translate_options['show_type'] !== 'Text' ) {
								if ( $sdac_translate_options['show_type'] == 'Both' ) {
									$translate .= '<li><a class="sdacFlag" id="'.$country['lang_code'].'" href="http://translate.google.com/translate?hl=en&langpair=en|'.$country['lang_code'].'&u='.get_bloginfo('url').'" title="'.$country['lang'].'">'.$country['lang'].'</a></li>'."\n";
								} else {
									$translate .= '<li class="flagsOnly"><a class="sdacFlag" id="'.$country['lang_code'].'" href="http://translate.google.com/translate?hl=en&langpair=en|'.$country['lang_code'].'&u='.get_bloginfo('url').'" title="'.$country['lang'].'"></a></li>'."\n";
								}
							}
						}
					}
					$translate .='</ul>'."\n";
					wp_cache_set('sdac_translate_options', $translate, 'sdac_translate_cache', 86400);
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
        	<p style="font-weight:bold;font-size:.9em;"><a href="<?php bloginfo('url');?>/wp-admin/options-general.php?page=sdac_translate_options" title="Set all options">SDAC Translate Widget Options &raquo;</a></p>
        <?php 
    }
}
add_action('widgets_init', create_function('', 'return register_widget("sdac_translate_widget");'));


function sdac_translate_validate( $input ) {
	global $countries;
	do_action('sdac_translate_validate');
	
	foreach ( $countries as $country ) {
		$input['show_type'] = esc_attr( $input['show_type'] );
		$input[''.$country['lang'].'_show'] = esc_attr( $input[''.$country['lang'].'_show'] );
	}
	return $input;
}

//Invalidate the cache on
function sdac_invalidate_custom_caches() {
	$sdac_translate_options = get_option('sdac_translate');
	wp_cache_delete( 'sdac_translate_options', 'sdac_translate_cache' );
}
add_action( 'sdac_translate_validate', 'sdac_invalidate_custom_caches', 1, 2 );


function sdac_translate_css() {
	global $sdac_plugin_url;
	$sdac_translate_options = get_option('sdac_translate');
	if ( $sdac_translate_options['show_type'] == 'Text' ) {
		$styles .= 'ul#sdacTranslate li {float:left;width:49%;margin-right:10px;background:none !important;margin:0 !important;padding:0 !important;font-size:90% !important;}';
	}
	else if ( $sdac_translate_options['show_type'] !== 'Text' ) {
		$styles .= '#sdacTranslate a.sdacFlag {float:left !important;display:block !important;background: url('.$sdac_plugin_url.'/flags.gif); background-repeat:no-repeat  !important;height:11px !important;line-height:11px !important;margin-left:5px !important;padding-left:20px !important;}';
		
		if ( $sdac_translate_options['show_type'] == 'Both' ) {
			$styles .= 'ul#sdacTranslate li {float:left;width:49%;margin-right:10px;background:none !important;font-size:90% !important;margin:0 0 10px 0 !important;padding:0 !important;}';
			$styles .= '#sdacTranslate a.sdacFlag {float:left !important;display:block !important;background: url('.$sdac_plugin_url.'/flags.gif); background-repeat:no-repeat  !important;height:11px !important;line-height:11px !important;margin-left:5px !important;padding-left:20px !important;}';
		} 
		else if ( $sdac_translate_options['show_type'] == 'Flags' ) {
			$styles .= 'ul#sdacTranslate li.flagsOnly {background:none !important;float:left;width:25px !important;height:11px !imporant;margin:0 0 10px 0 !important;padding:0 !important;}';
		}
		$styles .= sdac_translate_shared_css();
	}
	echo '
		<style type="text/css">
			'.$styles.'
		</style>
		';
}		
add_action('wp_head', 'sdac_translate_css');
