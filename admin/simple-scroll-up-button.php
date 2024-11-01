<?php

namespace SimpleScrollUpButton;

require_once plugin_dir_path(dirname(__FILE__)) . 'admin/simple-scroll-up-button-setting.php';

use SSUB_Setting;

class SSUB_Admin
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'ssub_set_plugin_menu']);
        add_action('admin_menu', [$this, 'ssub_set_plugin_sub_menu']);
        add_action('admin_init', [$this, 'ssub_save_config']);
    }

    static function ssub_set_plugin_menu()
    {
        $class = new SSUB_Admin;
        add_menu_page(
            'Simple Scroll Up Button',
            'Simple Scroll Up Button',
            'manage_options',
            'simple-scroll-up-button',   // slug
            [$class, 'ssub_show_about_plugin'],
            'dashicons-arrow-up-alt',
            '65.1'
        );
    }

    static function ssub_set_plugin_sub_menu()
    {
        $class = new SSUB_Admin;
        add_submenu_page(
            'simple-scroll-up-button',  //parent
            __('Settings', SSUB_DOMAIN),
            __('Settings', SSUB_DOMAIN),
            'manage_options',
            'simple-scroll-up-button-config',
            [$class, 'ssub_show_config_form']
        );
    }

    static function ssub_show_about_plugin()
    {
        SSUB_Setting::ssub_show_about_plugin();
    }

    static function ssub_show_config_form()
    {
        SSUB_Setting::ssub_show_config_form();
    }

    static function ssub_save_config()
    {
        SSUB_Setting::ssub_save_config();
    }
}
