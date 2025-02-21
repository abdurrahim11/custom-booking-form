<?php
/**
 * Plugin Name: Custom Booking Form
 * Description: A custom booking form with seasonal rates and deposit calculation.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


function cbf_enqueue_scripts() {
    // Enqueue jQuery UI CSS
    wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    wp_enqueue_style('cbf-styles', plugins_url('style.css', __FILE__));
    wp_enqueue_script('jquery');
    wp_enqueue_script('cbf-scripts', plugins_url('script.js', __FILE__), array('jquery'), null, true);

    // Get seasons data
    $seasons = get_posts(array(
        'post_type' => 'season',
        'numberposts' => -1
    ));

    $seasons_data = array();
    foreach ($seasons as $season) {
        $seasons_data[] = array(
            'start_date' => get_post_meta($season->ID, 'cbf_start_date', true),
            'end_date' => get_post_meta($season->ID, 'cbf_end_date', true),
            'rates' => array(
                'adults' => get_post_meta($season->ID, 'cbf_adults_rate', true),
                'children_7_18' => get_post_meta($season->ID, 'cbf_children_7_18_rate', true),
                'children_2_7' => get_post_meta($season->ID, 'cbf_children_2_7_rate', true),
                'children_2_years' => get_post_meta($season->ID, 'cbf_children_2_years_rate', true),

                'surface_location_for' => get_post_meta($season->ID, 'cbf_surface_location_for', true),
                'surface_tent' => get_post_meta($season->ID, 'cbf_surface_tent', true),

                'additional_car' => get_post_meta($season->ID, 'cbf_additional_car_rate', true),
                'electricity_4amps' => get_post_meta($season->ID, 'cbf_electricity_4amps_rate', true),
                'electricity_15amps' => get_post_meta($season->ID, 'cbf_electricity_15amps_rate', true),
                'additional_tent' => get_post_meta($season->ID, 'cbf_additional_tent_rate', true),
                'dog' => get_post_meta($season->ID, 'cbf_dog_rate', true),
                'reservation_fee' => get_post_meta($season->ID, 'cbf_reservation_fee', true),
            ),
        );
    }

    // Localize script to pass PHP variables to JavaScript
    wp_localize_script('cbf-scripts', 'cbf_vars', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'cbf_booking_form_nonce' ),
        'seasons' => $seasons_data
    ));

}
add_action('wp_enqueue_scripts', 'cbf_enqueue_scripts');





// Register the custom post type for Seasons
function cbf_register_season_post_type() {
    $labels = array(
        'name'               => 'Seasons',
        'singular_name'      => 'Season',
        'menu_name'          => 'Seasons',
        'name_admin_bar'     => 'Season',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Season',
        'new_item'           => 'New Season',
        'edit_item'          => 'Edit Season',
        'view_item'          => 'View Season',
        'all_items'          => 'All Seasons',
        'search_items'       => 'Search Seasons',
        'parent_item_colon'  => 'Parent Seasons:',
        'not_found'          => 'No seasons found.',
        'not_found_in_trash' => 'No seasons found in Trash.'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'season'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title')
    );

    register_post_type('season', $args);
}
add_action('init', 'cbf_register_season_post_type');


// Add meta boxes for season custom fields
function cbf_add_season_meta_boxes() {
    add_meta_box(
        'cbf_season_details',
        'Season Details',
        'cbf_season_details_callback',
        'season',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'cbf_add_season_meta_boxes');

// Callback function to display meta box content
function cbf_season_details_callback($post) {
    wp_nonce_field('cbf_save_season_details', 'cbf_season_details_nonce');

    $fields = [
        'cbf_season_type' => 'Season Type:',
        'cbf_start_date' => 'Start Date:',
        'cbf_end_date' => 'End Date:',
        'cbf_adults_rate' => 'Adults Rate (€):',
        'cbf_children_7_18_rate' => 'Children 7-18 Rate (€):',
        'cbf_children_2_7_rate' => 'Children 2-7 Rate (€):',
        'cbf_children_2_years_rate' => 'Children - 2 years Rate (€):',

        'cbf_surface_location_for' => 'Location for Rate (€):',
        'cbf_surface_tent' => 'Tent(s) Rate (€):',

        'cbf_additional_car_rate' => 'Additional Car Rate (€):',
        'cbf_electricity_4amps_rate' => 'Electricity 4 Amps Rate (€):',
        'cbf_electricity_15amps_rate' => 'Electricity 15 Amps Rate (€):',
        'cbf_additional_tent_rate' => 'Additional Tent Rate (€):',
        'cbf_dog_rate' => 'Dog Rate (€):',
        'cbf_reservation_fee' => 'Reservation Fee Optional (€) :',
    ];

    foreach ($fields as $field => $label) {
        $value = get_post_meta($post->ID, $field, true);
        echo '<p>';
        echo '<label for="' . $field . '">' . $label . '</label>';
        // Determine the input type and step attribute
        if ($field == 'cbf_start_date' || $field == 'cbf_end_date') {
            $input_type = 'date';
            $step = '';
            echo '<input type="' . $input_type . '" id="' . $field . '" name="' . $field . '" value="' . esc_attr($value) . '" class="widefat"' . $step . '>';
            echo '</p>';
        }
        elseif( 'cbf_season_type' == $field ) {
            ?>
            <br>
            <select class="" name="<?php echo $field; ?>">
                <option value="High season">High season</option>
                <option value="Low season">Low season</option>
            </select>
            <?php
        } else {
            $input_type = 'number';
            $step = ' step="0.01"'; // Support decimal numbers
            echo '<input type="' . $input_type . '" id="' . $field . '" name="' . $field . '" value="' . esc_attr($value) . '" class="widefat"' . $step . '>';
            echo '</p>';
        }

    }
}

// Save the season custom fields
function cbf_save_season_details($post_id) {
    if (!isset($_POST['cbf_season_details_nonce']) || !wp_verify_nonce($_POST['cbf_season_details_nonce'], 'cbf_save_season_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = [
        'cbf_season_type',
        'cbf_start_date',
        'cbf_end_date',
        'cbf_adults_rate',
        'cbf_children_7_18_rate',
        'cbf_children_2_7_rate',
        'cbf_children_2_years_rate',
        'cbf_surface_location_for',
        'cbf_surface_tent',
        'cbf_additional_car_rate',
        'cbf_electricity_4amps_rate',
        'cbf_electricity_15amps_rate',
        'cbf_additional_tent_rate',
        'cbf_dog_rate',
        'cbf_reservation_fee',
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'cbf_save_season_details');



// Register the widget
function register_cbf_booking_form_widget( $widgets_manager ) {
    require_once __DIR__ . '/elementor-widget.php';
    $widgets_manager->register( new \CBF_Booking_Form_Widget() );
}
add_action( 'elementor/widgets/register', 'register_cbf_booking_form_widget' );


function enqueue_datepicker_assets() {
    wp_enqueue_style('jquery-ui-datepicker');
    wp_enqueue_script('jquery-ui-datepicker');
    wp_add_inline_script('jquery-ui-datepicker', '
         jQuery(function($) {
            var currentDate = new Date();
            var tomorrow = new Date();
            tomorrow.setDate(currentDate.getDate() + 1);

            $("#cbf-arrival_date").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: currentDate,
                onSelect: function(selectedDate) {
                    var arrivalDate = new Date(selectedDate);
                    arrivalDate.setDate(arrivalDate.getDate() + 1);
                    $("#cbf-departure_date").datepicker("option", "minDate", arrivalDate);
                }
            }).datepicker("setDate", currentDate);

            $("#cbf-departure_date").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: tomorrow
            }).datepicker("setDate", tomorrow);
        });
    ');
}
add_action('wp_enqueue_scripts', 'enqueue_datepicker_assets');











// Handle form submission
function cbf_booking_form_submit() {
    check_ajax_referer( 'cbf_booking_form_nonce', 'nonce' );

    $data = array(
        'name' => sanitize_text_field( $_POST['name'] ),
        'address1' => sanitize_text_field( $_POST['address1'] ),
        'address2' => sanitize_text_field( $_POST['address2'] ),
        'postal_city' => sanitize_text_field( $_POST['postal_city'] ),
        'country' => sanitize_text_field( $_POST['country'] ),
        'telephone' => sanitize_text_field( $_POST['telephone'] ),
        'email' => sanitize_email( $_POST['email'] ),
        'arrival_date' => sanitize_text_field( $_POST['arrival_date'] ),
        'departure_date' => sanitize_text_field( $_POST['departure_date'] ),
        'adults' => intval( $_POST['adults'] ),
        'children_7_18' => intval( $_POST['children_7_18'] ),
        'children_2_7' => intval( $_POST['children_2_7'] ),
        'children_under_2' => intval( $_POST['children_under_2'] ),
        'surface' => sanitize_text_field( $_POST['surface'] ),
        'location_for' => intval( $_POST['location_for'] ),
        'tents' => intval( $_POST['tents'] ),
        'caravan' => intval( $_POST['caravan'] ),
        'folding_caravan' => intval( $_POST['folding_caravan'] ),
        'motorhome' => intval( $_POST['motorhome'] ),
        'motorhome_dimensions' => sanitize_text_field( $_POST['motorhome_dimensions'] ),
        'additional_tents' => intval( $_POST['additional_tents'] ),
        'additional_cars' => intval( $_POST['additional_cars'] ),
        'electricity' => sanitize_text_field( $_POST['electricity'] ),
        'dogs' => sanitize_text_field( $_POST['dogs'] ),
        'comments' => sanitize_textarea_field( $_POST['comments'] ),
        'deposit' => sanitize_text_field( $_POST['deposit'] ),
        'accept_conditions' => isset( $_POST['accept_conditions'] ) ? 'yes' : 'no',
    );

    $to = get_option( 'admin_email' );
    $subject = 'New Booking Form Submission';
    $message = '';

    foreach ( $data as $key => $value ) {
        $message .= ucfirst( str_replace( '_', ' ', $key ) ) . ': ' . $value . "\r\n";
    }

    // Send email to admin
    wp_mail( $to, $subject, $message );

    // Send confirmation email to the user
    $user_email = $data['email'];
    $user_subject = 'Booking Form Confirmation';
    $user_message = 'Dear ' . $data['name'] . ",\r\n\r\n";
    $user_message .= "Thank you for your booking. Here are the details you submitted:\r\n\r\n";
    foreach ( $data as $key => $value ) {
        $user_message .= ucfirst( str_replace( '_', ' ', $key ) ) . ': ' . $value . "\r\n";
    }
    $user_message .= "\r\nWe will review your booking and get back to you shortly.\r\n";
    $user_message .= "Best regards,\r\n";
    $user_message .= "The Booking Team";

    wp_mail( $user_email, $user_subject, $user_message );

    wp_send_json_success( 'Form submitted successfully!' );
}
add_action( 'wp_ajax_cbf_booking_form_submit', 'cbf_booking_form_submit' );
add_action( 'wp_ajax_nopriv_cbf_booking_form_submit', 'cbf_booking_form_submit' );



