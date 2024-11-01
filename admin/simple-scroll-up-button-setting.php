<?php


class SSUB_Setting
{

    public function __construct()
    { }

    static function ssub_show_about_plugin()
    {
        ?>
        <h1>
            <?php _e('What is this?', SSUB_DOMAIN) ?>
        </h1>
        <p>
            <?php _e('This plugin adds a scroll up button at the bottom right side on your page.', SSUB_DOMAIN) ?>
        </p>
    <?php
        }

        static function ssub_show_config_form()
        {
            $use_flg = esc_html(get_option(SSUB_PLUGIN_DB_PREFIX . '_use_flg')) == "ssub" ? 'checked' : '';
            $color = esc_html(get_option(SSUB_PLUGIN_DB_PREFIX . '_color'));
            ?>
        <div class="wrap">
            <h1><?php _e('Settings', SSUB_DOMAIN) ?></h1>
            <form action="" method='post' id="my-submenu-form">

                <?php
                        wp_nonce_field(SSUB_CREDENTIAL_ACTION, SSUB_CREDENTIAL_NAME) //第２引数は作成される hiddenフィールドのname属性 $_POST[CREDENTIAL_NAME]で参照可能
                        ?>

                <p>
                    <label for="use_flg">
                        <input id="use_flg" type="checkbox" name="use_flg" value="ssub" <?= $use_flg ?> />
                        <?php _e('Show the button', SSUB_DOMAIN) ?>
                    </label>
                </p>
                <p>
                    <label for="color">
                        <?php _e('Color', SSUB_DOMAIN) ?>:
                    </label>
                    <input id="color" type="color" name="color" value="<?= $color ? $color : '#333333' ?>">
                </p>
                <p><input type='submit' value='<?php _e('Save', SSUB_DOMAIN) ?>' class='button button-primary button-large'> <?php echo get_transient('completed'); ?></p>
            </form>
        </div>
<?php
    }

    static function ssub_save_config()
    {
        if (isset($_POST[SSUB_CREDENTIAL_NAME]) && $_POST[SSUB_CREDENTIAL_NAME]) {
            if (check_admin_referer(SSUB_CREDENTIAL_ACTION, SSUB_CREDENTIAL_NAME)) {

                $key_use_flg = '_use_flg';
                $key_color = '_color';
                $use_flg = !empty($_POST['use_flg']) ? sanitize_text_field($_POST['use_flg']) : '';
                $color = sanitize_hex_color($_POST['color']) ? sanitize_hex_color($_POST['color']) : '';

                if ($use_flg == "ssub" || $use_flg == "") {
                    if (preg_match("/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/", $color)) {

                        update_option(SSUB_PLUGIN_DB_PREFIX . $key_use_flg, $use_flg);
                        update_option(SSUB_PLUGIN_DB_PREFIX . $key_color, $color);
                        $completed_text = __('Has been saved!', SSUB_DOMAIN);
                        set_transient('completed', $completed_text, 5);
                        wp_safe_redirect(menu_page_url(SSUB_CONFIG_MENU_SLUG));
                        exit;
                    } else {

                        $completed_text = __('Failed to save!', SSUB_DOMAIN);
                        set_transient('completed', $completed_text, 5);
                        wp_safe_redirect(menu_page_url(SSUB_CONFIG_MENU_SLUG));
                        exit;
                    }
                }
            }
        }
    }
}
