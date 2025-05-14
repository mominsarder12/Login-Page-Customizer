<?php
//plugin require head comments
/*
Plugin Name: Login Page Customizer
Description: Customize your WordPress login page with ease.
Version: 1.0
Author: Momin Sarder
Author URI: Your Website
License: GPL2
*/

//add submenu to general-options page
function lpc_add_submenu_page() {
    add_submenu_page('options-general.php', 'WP Login Page Customizer', 'WP Login Page Customizer', 'manage_options', 'login-page-customizer', 'lpc_settings_page');
}
add_action('admin_menu', 'lpc_add_submenu_page');

//create settings page
function lpc_settings_page() {
?>
    <div class="wrap">
        <h1>Login Page Customizer</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('lpc_settings');
            do_settings_sections('login-page-customizer');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

//register settings
function lpc_register_settings() {
    register_setting('lpc_settings', 'lpc_text_color');
    register_setting('lpc_settings', 'lpc_background_color');
    register_setting('lpc_settings', 'lpc_logo_url');
    register_setting('lpc_settings', 'lpc_background_image');
    register_setting('lpc_settings', 'lpc_form_background_color');

    //add section 
    add_settings_section('lpc_section', 'Login Page Customizer Settings', null, 'login-page-customizer');

    //settings filed
    add_settings_field('lpc_logo_url', 'Logo URL', 'lpc_logo_url_field', 'login-page-customizer', 'lpc_section');
    add_settings_field('lpc_text_color', 'Text Color', 'lpc_text_color_field', 'login-page-customizer', 'lpc_section');
    add_settings_field('lpc_background_color', 'Background Color', 'lpc_background_color_field', 'login-page-customizer', 'lpc_section');
    add_settings_field('lpc_background_image', 'Background Image URL', 'lpc_background_image_field', 'login-page-customizer', 'lpc_section');

    add_settings_field('lpc_form_background_color', 'Form Background Color', 'lpc_form_background_color_field', 'login-page-customizer', 'lpc_section');
}
add_action('admin_init', 'lpc_register_settings');


function lpc_text_color_field() {
    $text_color = get_option('lpc_text_color', '');
    echo '<input type="text" name="lpc_text_color" value="' . esc_attr($text_color) . '" class="regular-text" />';
}
function lpc_logo_url_field() {
    $logo_url = get_option('lpc_logo_url', '');
    echo '<input type="text" name="lpc_logo_url" value="' . esc_attr($logo_url) . '" class="regular-text" />';
}


function lpc_background_color_field() {
    //background color choose field -standard
    $background_color = get_option('lpc_background_color', '');
    echo '<input type="text" id="lpc_background_color" name="lpc_background_color" value="' . esc_attr($background_color) . '" class="regular-text" />';
}

function lpc_background_image_field() {
    //background image choose field -standard
    $background_image = get_option('lpc_background_image', '');
    echo '<input type="text" name="lpc_background_image" value="' . esc_attr($background_image) . '" class="regular-text" />';
}
function lpc_form_background_color_field() {
    //background image choose field -standard
    $form_background_color = get_option('lpc_form_background_color', '');
    echo '<input type="text" name="lpc_form_background_color" value="' . esc_attr($form_background_color) . '" class="regular-text" />';
}

add_action('login_enqueue_scripts', 'lpc_enqueue_scripts_settings_apply');
function lpc_enqueue_scripts_settings_apply() {
    //to apply the setting field to login page
    $background_color = get_option('lpc_background_color', '');
    $text_color = get_option('lpc_text_color', '');
    $logo_url = get_option('lpc_logo_url', '');
    $background_image = get_option('lpc_background_image', '');
    $form_background_color = get_option('lpc_form_background_color', '');
    if (!empty($background_color)) {
    ?>
        <style>
            body.login.login-action-login {
                background-color: <?php echo $background_color; ?>;
            }
        </style>
    <?php
    }
    if (!empty($background_image)) {
    ?>
        <style>
            body.login.login-action-login {


                background: url("<?php echo $background_image; ?>") no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
        </style>
    <?php
    }

    if (!empty($text_color)) {
    ?>
        <style>
            div#login,
            a.wp-login-lost-password,
            p#backtoblog a {
                color: <?php echo $text_color; ?> !important;

            }
        </style>
    <?php
    }
    if (!empty($logo_url)) {
    ?>
        <style>
            #login h1.wp-login-logo a {

                background-image: url(<?php echo $logo_url; ?>) !important;

            }
        </style>
    <?php
    }
    if (!empty($form_background_color)) {
    ?>
        <style>
            body #login #loginform {
                background-color: <?php echo $form_background_color; ?> !important;
            }
        </style>
<?php
    }
} //lpc_enqueue_scripts_settings_apply end here
