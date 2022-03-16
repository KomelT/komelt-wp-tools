<?php
/*
Komelt WordPress Tools
@package           komelt-wp-tools
@author            Tilen Komel
@copyright         2022 Komelt.dev
@license           MIT
@wordpress-plugin
Plugin Name:       Komelt WP Tools
Plugin URI:        https://github.com/KomelT/komelt-wp-tools
Description:       Plugin with simple tools, designed by Tilen Komel from Komelt.dev.
Version:           1.0.0
Requires at least: 5.2
Requires PHP:      7.2
Author:            Tilen Komel
Author URI:        https://www.komelt.dev
Text Domain:       komelt-wp-tools
License:           MIT
License URI:       https://raw.githubusercontent.com/KomelT/komelt-wp-tools/main/LICENSE
*/

/*
MIT License

Copyright (c) 2022 Tilen Komel

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

if (!defined("ABSPATH") or !function_exists("add_action")) {
    die("Hey, you cant access this file, you silly little human!");
}

class KomeltWpTools
{
    // Function runs on every refresh
    function __construct()
    {
        // Includin plugin page
        add_action('admin_menu', function () {
            add_menu_page('Komelt Tools Plugin', 'Komelt Tools', 'manage_options', 'komelt-tools', 'komelt_init_plugin_page', "dashicons-admin-tools");
        });
    }

    function activate()
    {
    }

    function deactivate()
    {
        echo "The plugin  was activated!";
    }

    function index_page()
    {
    }
}

if (class_exists("KomeltWpTools")) {
    $komeltWpTools = new KomeltWpTools();
}

// activation
register_activation_hook(__FILE__, array($komeltWpTools, "activate"));

// deactivation
register_deactivation_hook(__FILE__, array($komeltWpTools, "deactivate"));

function komelt_init_plugin_page()
{
    echo "<h1>Welcome to Komelt Tools Plugin!</h1>";

    global $wpdb;
    $wpdb->hide_errors();

    //$wpdb->get_results("drop table komelt_tools_data");

    $results = $wpdb->get_results("SELECT * FROM komelt_tools_data");

    // Check if table 'wordpress.komelt_tools_data' exists
    if (!($wpdb->last_error == "")) {
        $error = $wpdb->last_error;
        print "<strong>Error: " . $error . "</strong><br>";

        if ($error == "Table 'wordpress.komelt_tools_data' doesn't exist") {
            echo "Solving problem...<br>";

            $wpdb->get_results(
                "create table komelt_tools_data 
                    (tool_slug varchar(255), 
                    tool_name varchar(255), 
                    enabled boolean)"
            );
            $wpdb->get_results("SELECT * FROM komelt_tools_data");
            $error = $wpdb->last_error;
            if ($error == "") {
                echo "<strong>Problem fixed!</strong>";
            }
        }
    }


    //$wpdb->get_results("drop table komelt_tools_data");
}
