<?php
/*
Plugin Name: Son Secure Content Guard
Description:Son Secure Content Guard is a powerful yet user-friendly plugin designed to safeguard your valuable website content from unauthorized copying and plagiarism. With this plugin, you can easily protect your texts, images, and other media elements from being copied, ensuring the integrity of your intellectual property. Use settings to turn features on or off.

The plugin employs advanced JavaScript-based protection techniques that deter casual content theft. Whenever a user attempts to copy any protected content, Son Secure Content Guard promptly triggers an alert, notifying them that copying is strictly prohibited. This not only discourages potential content thieves but also raises awareness about the importance of respecting copyright and intellectual property rights.

Key Features:

Effortless Protection: Son Secure Content Guard offers a seamless experience for website owners with its simple setup and activation process. You can quickly enable content protection across your entire website with just a few clicks.

Customizable Alert: Tailor the alert message displayed to users attempting to copy your content. You have the flexibility to use a personalized message that best suits your website's tone and style.

Selective Protection: Choose which specific parts of your content you want to protect. You can apply content protection to entire posts, pages, or individual sections, ensuring full control over your content's security.

Compatibility & Performance: The plugin is designed to be lightweight and optimized for performance, ensuring that it does not affect your website's loading speed or user experience.

Responsive Design: Son Secure Content Guard works seamlessly across various devices and screen sizes, providing consistent content protection for all your visitors.

User-Friendly Settings: The plugin's intuitive settings panel allows you to manage and customize the protection options effortlessly, even for users with limited technical expertise.

Regular Updates & Support: You can trust Son Secure Content Guard to stay up-to-date with the latest WordPress versions and security standards. Our dedicated support team is always ready to assist you with any inquiries or issues.

Protect your hard work and creativity with Son Secure Content Guard, fortifying your WordPress website against content theft and preserving the value of your digital assets. Safeguard your intellectual property and maintain your content's exclusivity with ease, using the comprehensive and robust content protection features offered by Son Secure Content Guard plugin.

This plugin is open source and you can contribute by going to iamtsquare07.com/content-protector-plugin
You can also contribute by donating to us on iamtsquare07.com/content-protector-plugin-heroes

Version: 1.0.0
Author: Tyavbee Victor
Author URI: https://www.iamtsquare07.com
Text Domain: son-content-protector
*/
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function son_cp_plugin_menu() {
    add_options_page(
        'Content Protector Settings',
        'Content Protector',
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
                console.log("This is from son content protector")
    // Function to handle radio button changes and store settings in localStorage
    function handleRadioButtonChange(event) {
        const target = event.target;
        if (target.name === 'son_cp_enable_copy_protection' || target.name === 'son_cp_enable_right_click_protection') {
            localStorage.setItem(target.name, target.value);
        }
    }

    // Function to load the initial radio button values from localStorage
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

    // Attach event listeners to radio buttons
    const enableCopy = document.getElementById('enableCopy');
    const disableCopy = document.getElementById('disableCopy');
    const enableRightClick = document.getElementById('enableRightClick');
    const disableRightClick = document.getElementById('disableRightClick');

    enableCopy.addEventListener('change', handleRadioButtonChange);
    disableCopy.addEventListener('change', handleRadioButtonChange);
    enableRightClick.addEventListener('change', handleRadioButtonChange);
    disableRightClick.addEventListener('change', handleRadioButtonChange);

    // Load the initial radio button values from localStorage
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

// Cleanup the plugin data on plugin deactivation (optional)
function son_cp_deactivation() {
    // Cleanup tasks specific to your plugin
    // Remove custom database tables, options, or files

    // Notify the user about the deactivation process
    add_action('admin_notices', 'son_cp_deactivation_notice');
}

function son_cp_deactivation_notice() {
    echo '<div class="notice notice-success is-dismissible">';
    echo '<p>Your plugin has been deactivated, and cleanup tasks have been performed.</p>';
    echo '</div>';
}

// Register the uninstall hook
register_uninstall_hook(__FILE__, 'son_cp_uninstall');

// Define the uninstallation function
function son_cp_uninstall() {
    // Delete the plugin options when the plugin is uninstalled
    delete_option('son_cp_enable_copy_protection');
    delete_option('son_cp_enable_right_click_protection');
    delete_option('son_cp_copy_message');
    delete_option('son_cp_right_click_message');
}

// Cleanup the plugin files on plugin deletion
function son_cp_delete_plugin() {
    // Check if the deletion is being triggered by WordPress, not directly
    if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'delete-selected') {
        // Get the plugin directory path
        $plugin_dir = plugin_dir_path(__FILE__);

        // List of allowed files within the plugin directory
        $allowed_files = array(
            'son-content-protector.php', 
            'includes/content-protector.js', 
            // Add other plugin files if needed
        );

        // Get the file path to be deleted
        $file_to_delete = sanitize_text_field($_REQUEST['plugin']);

        // Ensure the file path is valid and allowed
        if (in_array($file_to_delete, $allowed_files) && strpos($file_to_delete, $plugin_dir) === 0) {
            // Log the file deletion for auditing
            error_log("Plugin file deleted: $file_to_delete");

            // Delete the file
            if (file_exists($file_to_delete)) {
                unlink($file_to_delete);
            }
        } else {
            // Log unauthorized file deletion attempt for auditing
            error_log("Unauthorized file deletion attempt: $file_to_delete");
        }
    }
}
add_action('delete_plugin', 'son_cp_delete_plugin');

?>