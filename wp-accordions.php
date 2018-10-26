<?php
/**
 * Plugin Name: WP Accordions
 * Plugin URI:  https://wordpress.org/plugins/wp-accordions
 * Description: WordPress Simple Accordions to show with short-codes It is based on CSS and Java-script Both
 * Version:     1.0.1
 * Author:      Hassan Ali
 * Author URI:  https://coresol.com.pk
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: wp-accordions
 */
define('TEMPLATESPATH', get_template_directory().'/');
define('PLUGINSPATH', plugin_dir_path( __FILE__ ));

if ( ! class_exists( 'wp-accordions' ) ) {
    class wp_accordions {
		var $plugin_name = "";
        public function __construct() {
			$this->plugin_name = "wp-accordions";
			
            add_action( 'wp_footer', array($this, 'popup_generator'), 0 );
            add_action( 'admin_footer', array($this, 'popup_generator'), 0 );
			
			// Add Btn after 'Media'
			add_action( 'media_buttons', array($this, 'add_my_media_button'), 15);
			
			
			add_shortcode('wp_accordions', array($this, 'custom_accordions_show_shortcode'));
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_style' ), 10 );
			add_action('admin_enqueue_scripts', array( $this, 'admin_style_scripts' ));
			
			add_action( 'init', array( $this, 'custom_wp_accordions_post_type'), 0 );
			add_action( 'add_meta_boxes', array( $this, 'wpt_add_wp_accordions_metaboxes') );
			add_action( 'save_post', array( $this, 'wpt_save_accordions_metaboxes'), 1, 2 );
			
			
			add_action( 'wp_ajax_nopriv_custom_accordion_data', array( $this, 'custom_accordion_data') );
			add_action( 'wp_ajax_custom_accordion_data', array( $this, 'custom_accordion_data') );
			
			// register_activation_hook( __FILE__,  array( $this, 'accordions_plugin_create_db'));
			add_action( 'plugins_loaded', array( $this, 'accordions_plugin_textdomain' ));
        }
		
		function accordions_plugin_textdomain(){
			$plugin_rel_path = basename( dirname( __FILE__ ) ) . '/languages';
			load_plugin_textdomain( 'wp-accordions', false, $plugin_rel_path );
		}
		
		function custom_accordion_data(){
			include( PLUGINSPATH . 'includes/options-functions.php');
			if( file_exists( TEMPLATESPATH . 'options.php' ) ) {
				include( TEMPLATESPATH . 'options.php');
			}else{
				include( PLUGINSPATH . 'includes/options.php');
			}
			$xx = intval( $_POST['xx'] );
			$namee = $_POST['name']; 
			if( $namee == "accordion_meta_id" ){ $options = $options_meta ;}else{$options = $options;}
			?>
			<div id="main-block<?php echo $xx; ?>" class="main-block">
				<h2 class="block-head">
			   <span class="move"><i class="fa  fa-arrows-alt"></i></span>
			   <b class="expand"></b>
			   <input class="main-tile-input" type="text" value="<?php _e('Title of Accordion','wp-accordion'); ?>" name="<?php echo $namee ; ?>[<?php echo $xx ; ?>][block_main_name_top]" placeholder="<?php _e('Title of Accordion','wp-accordion'); ?>" />
			   <a href="#" class="remove_field">X</a>
			</h2>
				<div class="options-holder" id="oh<?php echo $xx; ?>">
					<?php
						wp_accordion_create_form($options,$xx,"",$namee);
					?>
				</div>
			</div>
			<?php
			wp_die();
		}
		
		
		function popup_generator(){
			ob_start();
			include_once( "admin/parts/accordion-shortcode.php" );
			echo ob_get_clean();
		}
		
		function add_my_media_button() { ?>
			<style>
				.wp-core-ui a.editr_media_link {
					padding-left: 0.4em;
				}
				.label-desc {
					width: 27%;
					margin-right: 3%;
					float: left;
					font-weight: bold;
					text-align: right;
					padding-top: 2px;
				}
				.wp_doin_shortcode .content {
					float: left;
					width: 70%;
				}
				.field-container {
					margin: 5px 0;
					display: inline-block;
					width: 100%;
				}
				#TB_ajaxContent h3 {
					margin-bottom: 20px;
				}
			</style>
			<a href = "#TB_inline?width=600&height=600&inlineId=wp-accordion-div-shortcode" class = "button thickbox wp_doin_media_link dashicons-before dashicons-editor-justify dashicons-accordion" id = "wp-add-div-shortcode" title = "<?php echo __('Add Accordion', $this->plugin_name); ?>"><?php echo __('Add Accordion', $this->plugin_name); ?></a></li>
			<?php
		}
		
		/**
		 * Load frontend JS.
		 */
		public function enqueue_scripts_style(){
			wp_enqueue_script('wp-accordions', plugin_dir_url( __FILE__ ) . 'assets/js/wp-accordions.js');
			wp_register_script('wp-accordion-animated', plugin_dir_url( __FILE__ ) . 'assets/js/wp-accordion-animated.js');
			wp_register_script('wp-accordion-simple', plugin_dir_url( __FILE__ ) . 'assets/js/wp-accordion-simple.js');
			
			wp_register_style( 'wp-accordion-basic', plugin_dir_url( __FILE__ ) . 'assets/css/wp-accordion-basic.css' );
			wp_register_style( 'wp-accordion-slide', plugin_dir_url( __FILE__ ) . 'assets/css/wp-accordion-slide.css' );
			wp_register_style( 'wp-accordion-animated', plugin_dir_url( __FILE__ ) . 'assets/css/wp-accordion-animated.css' );
			wp_register_style( 'wp-accordion-simple', plugin_dir_url( __FILE__ ) . 'assets/css/wp-accordion-simple.css' );
			wp_register_style( 'accordion-load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );

		}
		
		// Update CSS within in Admin
		public function admin_style_scripts() {
			wp_enqueue_style( 'wp-color-picker');
			wp_enqueue_script( 'wp-color-picker');
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_style('wp-accordions-admin', plugin_dir_url( __FILE__ ) . 'assets/css/wp-accordions-admin.css');
			wp_enqueue_style( 'accordion-load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
			wp_enqueue_script('wp-accordions-admin', plugin_dir_url( __FILE__ ) . 'assets/js/wp-accordions-admin.js');
			
			wp_localize_script( 'wp-accordions-admin', 'ajax_object',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nx' => 'accordion_meta_id' ) );
		}
		
		
		function custom_accordions_show_shortcode($atts, $content){
			// let's fetch all of the arguments of the shortcode
			$atts = shortcode_atts( 
						array(
							'accordion_id' => '',
							'accordion_class' => '',
						), $atts );
			$accordion_type = get_post_meta( $atts['accordion_id'], 'accordion_type', true );
			ob_start();
			if($accordion_type){
				if( file_exists( get_stylesheet_directory().'/wp-accordions/templates/accordion-'.$accordion_type.'.php' ) ){
					include_once( get_stylesheet_directory().'/wp-accordions/templates/accordion-'.$accordion_type.'.php' );
				} else {
					include_once( 'templates/accordion-'.$accordion_type.'.php' );
				}
			} else {
				include_once( 'templates/accordion-basic.php' );
			}
			$output_string = ob_get_contents();
			ob_end_clean();
			return $output_string;
			wp_reset_postdata();
		}
		function wpt_wp_accordions_location() {
			// Nonce field to validate form request came from current site
			include_once( 'admin/parts/accordion-metabox.php' );
		}
		function wpt_wp_accordions_setting() {
			// Nonce field to validate form request came from current site
			wp_nonce_field( basename( __FILE__ ), 'wp_accordions_fields' );
			include_once( 'admin/parts/accordion-metabox-setting.php' );
		}
		function wpt_wp_accordions_type() {
			include_once( 'admin/parts/accordion-metabox-type.php' );
		}
		function wpt_add_wp_accordions_metaboxes() {
			add_meta_box(
				'wpt_wp_accordions_location',
				__('Accordions Detail', $this->plugin_name),
				array($this, 'wpt_wp_accordions_location'),
				'wp-accordions',
				'normal',
				'high'
			);
			add_meta_box(
				'wpt_wp_accordions_type',
				__('Accordions Settings', $this->plugin_name),
				array($this, 'wpt_wp_accordions_type'),
				'wp-accordions',
				'side',
				'high'
			);
			/* add_meta_box(
				'wpt_wp_accordions_setting',
				__('Accordions Settings', $this->plugin_name),
				array($this, 'wpt_wp_accordions_setting'),
				'wp-accordions',
				'side',
				'high'
			); */
		}
		
		function wpt_save_accordions_metaboxes($post_id, $post){
			// Return if the user doesn't have edit permissions.
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
			
			// Verify this came from the our screen and with proper authorization,
			// because save_post can be triggered at other times.
			if ( isset($_POST['wp_accordions_fields']) && ! wp_verify_nonce( $_POST['wp_accordions_fields'], basename(__FILE__) )) {
				return $post_id;
			}
			// Now that we're authenticated, time to save the data.
			// This sanitizes the data from the field and saves it into an array $accordion_meta.
			if(isset($_POST['accordion_meta_id'])){
				// $accordion_meta['heading_color'] = sanitize_text_field($_POST['heading_color']);
				// $accordion_meta['heading_bgcolor'] = sanitize_text_field($_POST['heading_bgcolor']);
				// $accordion_meta['content_color'] = sanitize_text_field($_POST['content_color']);
				// $accordion_meta['content_bgcolor'] = sanitize_text_field($_POST['content_bgcolor']);
				// $accordion_meta['accordion_type'] = sanitize_text_field($_POST['accordion_type']);
				$accordion_meta['accordion_meta_id'] = $_POST['accordion_meta_id'];
				$accordion_meta['accordion_open_one'] = $_POST['accordion_open_one'];
				// $accordion_meta['accordion_meta_key'] = $_POST['accordion_meta_key'];
			}
		
			
			// Cycle through the $accordion_meta array.
			// Note, in this example we just have one item, but this is helpful if you have multiple.
			if(!empty($accordion_meta)){
				foreach ( $accordion_meta as $key => $value ) :

					if ( get_post_meta( $post_id, $key, false ) ) {
						// If the custom field already has a value, update it.
						update_post_meta( $post_id, $key, $value );
					} else {
						// If the custom field doesn't have a value, add it.
						add_post_meta( $post_id, $key, $value);
					}
					if ( ! $value ) {
						// Delete the meta key if there's no value
						delete_post_meta( $post_id, $key );
					}
				endforeach;
			}
			
			if( $post->post_type == "wp_accordions" ) {
				if (isset( $_POST ) ) {
					update_post_meta( $post_ID, '_embed_code', strip_tags( $_POST['embed_code'] ) );
				}
			}
		}
		
		function custom_wp_accordions_post_type() {
			include_once('admin/accordion-post-type.php');
		}
    }
	$wp_accordions = new wp_accordions();
}
