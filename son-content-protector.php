<?php
/*
Plugin Name: Son Secure Content Guard
Author: tsquare07
Version: 1.0.0
Description: You can stop copycats from easily taking away your hard work. Protect your text, images, and other media with this lightweight plugin. Keep your content safe by deactivating right click, copying and text highlighting even when JavaScript is disabled.
Author URI: https://www.iamtsquare07.com
License: GPLv3 or later
Text Domain: son-secure-content-guard
*/

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function son_cp_plugin_menu() {
    add_options_page(
        'Son Content Protector Settings',
        'Son Content Protector',
        'manage_options',
        'son-content-protector-settings',
        'son_cp_settings_page'
    );
}
add_action('admin_menu', 'son_cp_plugin_menu');

function son_cp_settings_page() {
    ?>
    <div class="wrap">
        <h2>Son Content Protector Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('son-cp-settings-group'); ?>
            <?php do_settings_sections('son-content-protector-settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Copy Protection:</th>
                    <td>
                        <label>
                            <input type="radio" id="enableCopy" name="son_cp_enable_copy_protection" value="1" <?php checked(get_option('son_cp_enable_copy_protection'), 1); ?>/> Enable
                        </label>
                        <label>
                            <input type="radio" id="disableCopy" name="son_cp_enable_copy_protection" value="0" <?php checked(get_option('son_cp_enable_copy_protection'), 0); ?> /> Disable
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Right-Click Protection:</th>
                    <td>
                        <label>
                            <input type="radio" id="enableRightClick" name="son_cp_enable_right_click_protection" value="1" <?php checked(get_option('son_cp_enable_right_click_protection'), 1); ?>/> Enable
                        </label>
                        <label>
                            <input type="radio" id="disableRightClick" name="son_cp_enable_right_click_protection" value="0" <?php checked(get_option('son_cp_enable_right_click_protection'), 0); ?> /> Disable
                        </label>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Edit Copy Protection Alert:</th>
                    <td>
                        <textarea rows="5" cols="30" name="son_cp_copy_message" value="<?php echo esc_attr(get_option('son_cp_copy_message', 'Gotcha!😜 Content is protected. Copying is not allowed.')); ?>"><?php echo esc_attr(get_option('son_cp_copy_message', 'Gotcha!😜 Content is protected. Copying is not allowed.')); ?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Edit Right-Click Protection Alert:</th>
                    <td>
                        <textarea rows="5" cols="30" name="son_cp_right_click_message" value=""><?php echo esc_attr(get_option('son_cp_right_click_message', 'For copyright protection, right-clicking is currently disabled on this website. Sorry for the inconvenience.')); ?></textarea>
                    </td>
                </tr>
            </table>
            <script>
    function handleRadioButtonChange(event) {
        const target = event.target;
        if (target.name === 'son_cp_enable_copy_protection' || target.name === 'son_cp_enable_right_click_protection') {
            localStorage.setItem(target.name, target.value);
        }
    }

    // Load the initial button values from localStorage
    function loadRadioButtonsFromLocalStorage() {
        const enableCopy = document.getElementById('enableCopy');
        const disableCopy = document.getElementById('disableCopy');
        const enableRightClick = document.getElementById('enableRightClick');
        const disableRightClick = document.getElementById('disableRightClick');

        const copyProtectionValue = localStorage.getItem('son_cp_enable_copy_protection');
        const rightClickProtectionValue = localStorage.getItem('son_cp_enable_right_click_protection');

        if (copyProtectionValue === '1') {
            enableCopy.checked = true;
        } else {
            disableCopy.checked = true;
        }

        if (rightClickProtectionValue === '1') {
            enableRightClick.checked = true;
        } else {
            disableRightClick.checked = true;
        }
    }

    // Attach event listeners
    const enableCopy = document.getElementById('enableCopy');
    const disableCopy = document.getElementById('disableCopy');
    const enableRightClick = document.getElementById('enableRightClick');
    const disableRightClick = document.getElementById('disableRightClick');

    enableCopy.addEventListener('change', handleRadioButtonChange);
    disableCopy.addEventListener('change', handleRadioButtonChange);
    enableRightClick.addEventListener('change', handleRadioButtonChange);
    disableRightClick.addEventListener('change', handleRadioButtonChange);

    // Load the initial values from localStorage
    loadRadioButtonsFromLocalStorage();
</script>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Add a settings link to the plugin actions
function son_cp_add_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=son-content-protector-settings">Settings</a>';
    array_push($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'son_cp_add_settings_link');

function son_cp_register_settings() {
    register_setting('son-cp-settings-group', 'son_cp_enable_copy_protection', 'sanitize_text_field');
    register_setting('son-cp-settings-group', 'son_cp_enable_right_click_protection', 'sanitize_text_field');
    register_setting('son-cp-settings-group', 'son_cp_copy_message', 'sanitize_text_field');
    register_setting('son-cp-settings-group', 'son_cp_right_click_message', 'sanitize_text_field');
}
add_action('admin_init', 'son_cp_register_settings');



// Enqueue JavaScript
function son_cp_enqueue_scripts() {
    // Add JavaScript to detect whether JavaScript is enabled or disabled
    echo '<noscript>
        document.addEventListener("DOMContentLoaded", function() {
            var body = document.body;
            body.classList.add("js-enabled");
        });
    </noscript>';
    wp_enqueue_script('content-protector', plugin_dir_url(__FILE__) . 'includes/content-protector.js', array(), '1.0', true);

    
    // Retrieve custom messages from options
    $custom_admin_message = get_option('son_cp_admin_message');
    $custom_right_click_message = get_option('son_cp_right_click_message');

    // Pass custom messages to JavaScript
    wp_localize_script('content-protector', 'cp_custom_messages', array(
        'adminMessage' => $custom_admin_message,
        'rightClickMessage' => $custom_right_click_message,
    ));
}
add_action('wp_enqueue_scripts', 'son_cp_enqueue_scripts');


// Add CSS to prevent right-clicking and copying when JavaScript is disabled
function scp_add_css() {
    echo '<noscript>
        <style>
            /* Prevent text selection when JavaScript is disabled */
            body {
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
        </style>
    </noscript>';
}
add_action('wp_head', 'scp_add_css');

// Cleaning up the plugin data on plugin deactivation
function son_cp_uninstall() {
    // Delete the plugin options when the plugin is uninstalled
    delete_option('son_cp_enable_copy_protection');
    delete_option('son_cp_enable_right_click_protection');
    delete_option('son_cp_copy_message');
    delete_option('son_cp_right_click_message');
}

// Register the uninstall hook
register_uninstall_hook(__FILE__, 'son_cp_uninstall');
?>