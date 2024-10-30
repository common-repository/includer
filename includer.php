<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php
/**
 * @package Includer
 */
/*
Plugin Name: Includer
Description: The easiest way to add Google Analytics, Clicky Analytics, Clickcease and CallRail scripts to your Wordpress site.
Version: 0.1
Author: Sam Creamer
Author URI: http://samcreamer.org/
*/

function includer_register_settings()
{
    // Google Analytics
    register_setting( 'includer_settings', 'includer_ga_enable', null );
    register_setting( 'includer_settings', 'includer_ga_id', null );
    add_settings_section('ga','Google Analytics',null,'includer');
    add_settings_field('includer_ga_enable','Enable','includer_ga_enable_callback','includer','ga');
    add_settings_field('includer_ga_id','Tracking ID','includer_ga_id_callback','includer', 'ga');

    // Clicky
    add_settings_section('clicky','Clicky Analytics',null,'includer');
    register_setting( 'includer_settings', 'includer_clicky_enable', null );
    add_settings_field('includer_clicky_enable','Enable','includer_clicky_enable_callback','includer','clicky');
    register_setting( 'includer_settings', 'includer_clicky_id', null );
    add_settings_field('includer_clicky_id','Site ID','includer_clicky_id_callback','includer', 'clicky');

    // ClickCease
    add_settings_section('clickcease','ClickCease',null,'includer');
    register_setting( 'includer_settings', 'includer_clickcease_enable', null );
    add_settings_field('includer_clickcease_enable','Enable','includer_clickcease_enable_callback','includer','clickcease');

    // CallRail
    add_settings_section('callrail','CallRail',null,'includer');
    register_setting( 'includer_settings', 'includer_callrail_enable', null );
    add_settings_field('includer_callrail_enable','Enable','includer_callrail_enable_callback','includer','callrail');
    register_setting( 'includer_settings', 'includer_callrail_id', null );
    add_settings_field('includer_callrail_id','Tracking ID','includer_callrail_id_callback','includer', 'callrail');
}
add_action( 'admin_init', 'includer_register_settings' );



function includer_ga_enable_callback()
{
    $n = 'includer_ga_enable';
    echo '<input type="checkbox"';
    echo " name='{$n}' ";
    echo " id='{$n}' ";
    echo checked( 1, get_option( $n ), false );
    echo ' value="1" ';
    echo ' />';
}

function includer_ga_id_callback()
{
    $n = 'includer_ga_id';
    echo '<input type="text" ';
    echo " name='{$n}' ";
    echo " id='{$n}' ";
    echo get_option($n) ? ' value="'.get_option($n).'" ' : '';
    echo ' />';
}

function includer_clicky_enable_callback()
{
    $n = 'includer_clicky_enable';
    echo '<input type="checkbox"';
    echo " name='{$n}' ";
    echo " id='{$n}' ";
    echo checked( 1, get_option( $n ), false );
    echo ' value="1" ';
    echo ' />';
}

function includer_clicky_id_callback()
{
    $n = 'includer_clicky_id';
    echo '<input type="text" ';
    echo " name='{$n}' ";
    echo " id='{$n}' ";
    echo get_option($n) ? ' value="'.get_option($n).'" ' : '';
    echo ' />';
}


function includer_clickcease_enable_callback()
{
    $n = 'includer_clickcease_enable';
    echo '<input type="checkbox"';
    echo " name='{$n}' ";
    echo " id='{$n}' ";
    echo checked( 1, get_option( $n ), false );
    echo ' value="1" ';
    echo ' />';
}

function includer_callrail_enable_callback()
{
    $n = 'includer_callrail_enable';
    echo '<input type="checkbox"';
    echo " name='{$n}' ";
    echo " id='{$n}' ";
    echo checked( 1, get_option( $n ), false );
    echo ' value="1" ';
    echo ' />';
}


function includer_callrail_id_callback()
{
    $n = 'includer_callrail_id';
    echo '<input type="text" ';
    echo " name='{$n}' ";
    echo " id='{$n}' ";
    echo get_option($n) ? ' value="'.get_option($n).'" ' : '';
    echo ' />';
}

function includer_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options'))
    {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
         <?php
         settings_fields( 'includer_settings' );
         do_settings_sections('includer');
         submit_button('Save Settings');
         ?>
        </form>
    </div>
    <?php
}

function includer_options_page()
{
    add_submenu_page(
        'options-general.php',
        'Includer Options', // Page Title
        'Includer', // Menu Title
        'manage_options', // Capability
        'includer', // Menu slug
        'includer_options_page_html' // Callback
    );
}
add_action('admin_menu', 'includer_options_page');


function includer_add_code()
{
    // Google Analytics
    if( get_option("includer_ga_enable") )
    {
        include('ga.php');
    }

    // Clicky
    if( get_option("includer_clicky_enable") )
    {
        include('clicky.php');
    }

    // Clickcease
    if( get_option("includer_clickcease_enable") )
    {
        include('clickcease.php');
    }

    // CallRail
    if( get_option("includer_callrail_enable") )
    {
        include('callrail.php');
    }
}
add_action( 'wp_footer', 'includer_add_code' );