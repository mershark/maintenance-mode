// Add this to your functions.php
function check_maintenance_mode() {
    // Option to store maintenance mode status
    if (!get_option('site_maintenance_mode')) {
        add_option('site_maintenance_mode', 'off');
    }

    // Check if user is not logged in and maintenance mode is on
    if (!is_user_logged_in() && get_option('site_maintenance_mode') === 'on') {
        // Get current URL path
        $current_path = $_SERVER['REQUEST_URI'];

        // Allow access only to the maintenance page and admin areas
        if ($current_path !== '/maintenance/' && !is_admin()) {
            wp_redirect('https://mershark.com/maintenance/');
            exit;
        }
    }
}
add_action('init', 'check_maintenance_mode');



// Add menu item to admin bar
function add_maintenance_toggle_button($wp_admin_bar) {
    if (current_user_can('manage_options')) {
        $maintenance_status = get_option('site_maintenance_mode');
        $button_text = $maintenance_status === 'on' ? 'Maintenance: ON' : 'Maintenance: OFF';
        $button_class = $maintenance_status === 'on' ? 'maintenance-on' : 'maintenance-off';
        
        $args = array(
            'id' => 'maintenance-toggle',
            'title' => $button_text,
            'href' => admin_url('admin-ajax.php?action=toggle_maintenance_mode'),
            'meta' => array(
                'class' => $button_class
            )
        );
        $wp_admin_bar->add_node($args);
    }
}
add_action('admin_bar_menu', 'add_maintenance_toggle_button', 100);

// Handle the AJAX toggle
function handle_maintenance_toggle() {
    if (current_user_can('manage_options')) {
        $current_status = get_option('site_maintenance_mode');
        $new_status = $current_status === 'on' ? 'off' : 'on';
        update_option('site_maintenance_mode', $new_status);
        
        wp_send_json_success(array(
            'status' => $new_status,
            'message' => 'Maintenance mode ' . ($new_status === 'on' ? 'enabled' : 'disabled')
        ));
    }
    wp_die();
}
add_action('wp_ajax_toggle_maintenance_mode', 'handle_maintenance_toggle');

// Add styles for the admin bar button
function maintenance_mode_admin_styles() {
    if (is_admin_bar_showing()) {
        ?>
        <style>
            #wp-admin-bar-maintenance-toggle .maintenance-on {
                color: #ff6b6b !important;
            }
            #wp-admin-bar-maintenance-toggle .maintenance-off {
                color: #ffffff !important;
            }
        </style>
        <script>
            jQuery(document).ready(function($) {
                $('#wp-admin-bar-maintenance-toggle').on('click', function(e) {
                    e.preventDefault();
                    
                    $.ajax({
                        url: $(this).find('a').attr('href'),
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            }
                        }
                    });
                });
            });
        </script>
        <?php
    }
}
add_action('wp_head', 'maintenance_mode_admin_styles');
add_action('admin_head', 'maintenance_mode_admin_styles');
