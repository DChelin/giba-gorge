<?php
// Add Thumbnail Theme Support
if (function_exists('add_theme_support')){
    add_theme_support('post-thumbnails');
}
//Head Enqueue
	function bc_head() {
		wp_enqueue_script( 'google-js', 'https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
    }
    
// Load BC styles
    function bcBlank_styles() {
        wp_register_style('bcBlank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
        wp_enqueue_style('bcBlank'); // Enqueue it!
        wp_enqueue_style('Swiper-css', 'https://unpkg.com/swiper@7/swiper-bundle.min.css');
        wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
    }

//Footer Enque
	function bc_footer() {
		wp_enqueue_script( 'custom-scripts', get_template_directory_uri() . '/scripts.js');
    }
    
// Custom login screen for wp-admin
function admin_login_logo() {
    echo '<style type="text/css">
    h1 a {
        background-image: url('.get_template_directory_uri().'/logo.png) !important;
        background-size: 75% !important;
        height: 150px !important;
        width: 70% !important; }
    body{
        background: #fff !important;
        color: #fff !important;}
    .login form{
        background: #373a46 !important;
        border: 2px solid;}
    .login #login_error, .login .message, .login .success{
        color: #373a46 !important;}
    .login form label{
            color: #fff;}
    .login #login_error, .login .message, .login .success{
            background-color: transparent;}
    </style>';
}
// custom logo
function config_custom_logo() {
    add_theme_support( 'custom-logo' );
}
/* =========== Navigation ==============*/
// register the nav tab
function register_BC_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'bcBlank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'bcBlank'), // Sidebar Navigation
        'logged-in' => __('Logged in', 'bcBlank'), // Logged in menu
        'logged-out' => __('Logged out', 'bcBlank') //logged out menu
    ));
}
  add_action('init', 'register_BC_menu'); // Add BC Blank Menu

// custom menu
function brandcandy_nav(){
    wp_nav_menu(
        array(
            'theme_location'  => 'header-menu',
            'menu'            => '',
            'container'       => 'div',
            'container_class' => 'menu-{menu slug}-container',
            'container_id'    => 'acrb-menu',
            'menu_class'      => 'menu',
            'menu_id'         => '',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '<ul>%3$s</ul>',
            'depth'           => 0,
            'walker'          => ''
        )
    );
}
// custom quick link menu
function brandcandy_quicklinknav(){
    wp_nav_menu(
        array(
            'theme_location'  => 'sidebar-menu',
            'menu'            => '',
            'container'       => 'div',
            'container_class' => 'menu-{menu slug}-container',
            'container_id'    => 'acrb-ql-menu',
            'menu_class'      => 'ql-menu',
            'menu_id'         => '',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '<ul>%3$s</ul>',
            'depth'           => 0,
            'walker'          => ''
        )
    );
}
/* =========== END Navigation ==============*/

// BC Theme Options
    if( function_exists('acf_add_options_page') ) {
        $option_page = acf_add_options_page(array(
            'page_title' 	=> 'Theme Settings',
            'menu_title' 	=> 'Theme Settings',
            'menu_slug' 	=> 'Theme-settings',
            'capability' 	=> 'edit_posts',
            'icon_url' => 	'dashicons-text-page' ,
            'redirect' 	=> false,
            'position' => 2
        ));
    }

function eventFilter( $query ) {
	
	// do not modify queries in the admin
	if( is_admin() ) {
		
		return $query;
		
	}
	

	// only modify queries for 'event' post type
	if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'Event' ) {
		
		$query->set('orderby', 'meta_value');	
		$query->set('meta_key', 'start_date');	 
		$query->set('order', 'DESC'); 
		
	}
	

	// return
	return $query;

}

add_action('pre_get_posts', 'eventFilter');


/* =========== Show Future Posts ==============*/

add_filter('get_post_status', function($post_status, $post) {
    if ($post->post_type == 'Events' && $post_status == 'future') {
        return "publish";
    }
    return $post_status;
}, 10, 2);

//Add Actions
add_action( 'get_header', 'bc_head' );
// add_action( 'get_footer', 'bc_footer' );
add_action('login_head', 'admin_login_logo');
add_action('wp_enqueue_scripts', 'bcBlank_styles'); // Add Theme Stylesheet
add_action( 'after_setup_theme' , 'config_custom_logo' );