<?php
/*
 *Plugin Name: Simple Scroll Up Button
 *Plugin URI: https://developer.wordpress.org/plugins/simple-scroll-up-button/
 *Description: Scroll up to the top of the page or the post
 *Version: 1.0.3
 *Author: WordPress Forest
 *Author URI: https://wp-forest.com
 *License: GPLv2
 *Text Domain: Simple Scroll Up Button
 *Domain Path: /languages

 * Copyright (C) 2020 WordPress Forest, (info@wp-forest.com)
 *
 * Simple Scroll Up Button Plugin is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once plugin_dir_path((__FILE__)) . 'admin/simple-scroll-up-button.php';

define('SSUB_DOMAIN', 'simple-scroll-up-button');
define('SSUB_PLUGIN_ID', 'simple-scroll-up-button');
define('SSUB_PLUGIN_DB_PREFIX', SSUB_PLUGIN_ID . '_');
define('SSUB_VERSION', '1.0.1');
define('SSUB_CREDENTIAL_ACTION', SSUB_PLUGIN_ID . '-nonce-action');
define('SSUB_CREDENTIAL_NAME', SSUB_PLUGIN_ID . '-nonce-key');
define('SSUB_CONFIG_MENU_SLUG', SSUB_PLUGIN_ID . '-config');

use SimpleScrollUpButton\SSUB_Admin;

new SSUB_Button;

class SSUB_Button
{
    function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'ssub_wp_enqueue_scripts']);

        load_plugin_textdomain(SSUB_DOMAIN, false, basename(dirname(__FILE__)) . '/languages');

        if (is_admin()) {
            new SSUB_Admin;
        }

        add_action('wp_body_open', [$this, 'ssub_show']);
    }

    function ssub_show()
    {
        if (!is_admin()) {
            $ssub_use_flg = esc_html(get_option(SSUB_PLUGIN_DB_PREFIX . '_use_flg'));
            $ssub_color = esc_html(get_option(SSUB_PLUGIN_DB_PREFIX . '_color'));
            $ssub_red = hexdec(substr($ssub_color, 1, 2));
            $ssub_green = hexdec(substr($ssub_color, 3, 2));
            $ssub_blue = hexdec(substr($ssub_color, 5, 2));
            $ssub_bg_color = "rgba(" . $ssub_red . "," . $ssub_green . "," . $ssub_blue . ",0.8)";
            if ($ssub_use_flg) {
                $ssub_btn = "<div id='ssub_btn-js' class='simple-scroll-up-btn' style='background-color:" . $ssub_bg_color . "; display:none;'>
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'>
                            <path d='M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z'/>
                        </svg>
                        </div>";
                echo $ssub_btn;
            }
        }
    }

    function ssub_wp_enqueue_scripts()
    {
        wp_register_style('simple-scroll-up-btn-style', plugins_url('public/style.css', __FILE__), array(), false, 'all');
        wp_enqueue_style('simple-scroll-up-btn-style');
        wp_enqueue_script('simple-scroll-up-btn-js', plugins_url('public/app.js', __FILE__), array(), '', true);
    }
}
