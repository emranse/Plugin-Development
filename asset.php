<?php
/*
Plugin Name: Assets Ninja
Plugin URI: http://bestwebfix.com
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
Author: Mohammad Emran
Version: 1.0.0
Author URI: http://bestwebfix.com
text-domain: assets-ninja
*/

define("ASN_NINJA_PUBLIC_DIR", plugin_dir_url(__FILE__)."assets/public");
define("ASN_NINJA_ADMIN_DIR", plugin_dir_url(__FILE__)."assets/admin");
define("ASN_VERSION", time() );

Class AssetsNinja{
  function __construct() {
    add_action('plugins_loaded',array($this, 'load_textdomain') );
    add_action('wp_enqueue_scripts', array($this, 'load_front_assets'));
    add_action('admin_enqueue_scripts', array($this, 'load_admin_assets'));
  }
  function load_admin_assets($screen){
    $_screen = get_current_screen();
    if('edit.php'  == $screen && 'page'  == $_screen->post_type){
      //wp admin js get_included_files
      wp_enqueue_script('asn-admin-main-js',ASN_NINJA_ADMIN_DIR."/js/main.js",array('jquery'), ASN_VERSION, true);
    }

  }
  function load_front_assets() {
    //css get_included_files
    wp_enqueue_style('assets-main-css', ASN_NINJA_PUBLIC_DIR."css.main.css",null,ASN_VERSION);
    //js file
    //wp_enqueue_script('assets-main-js',ASN_NINJA_PUBLIC_DIR."/js/main.js", array('jquery','assets-more-js'), ASN_VERSION, true);
   //wp_enqueue_script('assets-another-js',ASN_NINJA_PUBLIC_DIR."/js/another.js", array('jquery','assets-more-js'), ASN_VERSION, true);
   //wp_enqueue_script('assets-more-js',ASN_NINJA_PUBLIC_DIR."/js/more.js", array('jquery'), ASN_VERSION, true);

    $js_file = array(
      'assets-main-js'  =>array('path'=>ASN_NINJA_PUBLIC_DIR."/js/main.js", 'dep'=>array('jquery','assets-more-js')),
      'assets-another-js'  =>array('path'=>ASN_NINJA_PUBLIC_DIR."/js/another.js", 'dep'=>array('jquery','assets-more-js')),
      'assets-more-js'  =>array('path'=>ASN_NINJA_PUBLIC_DIR."/js/more.js", 'dep'=>array('jquery'))
    );
  foreach($js_file as $handle=>$file_info){
    wp_enqueue_script( $handle, $file_info['path'], $file_info['dep'], ASN_VERSION, true);
  }



    $data = array(
      'name'  => 'Mohammad Emran Hossen',
      'url'   => 'https://codent-it.com',
    );
    $translate_string = array(
      'greeting'  => __('Hello world','assets-ninja')
    );

    wp_localize_script('assets-main-js','sitedata',$data);
    wp_localize_script('assets-main-js','translated',$translate_string);

  }

  function load_textdomain() {
    load_plugin_textdomain('assets-ninja', false, plugin_dir_url(__FILE__)."/languages");
  }



}


new AssetsNinja();
