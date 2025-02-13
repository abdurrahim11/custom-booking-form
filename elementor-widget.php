<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;

class CBF_Booking_Form_Widget extends Widget_Base {

    public function get_name() {
        return 'cbf_booking_form';
    }

    public function get_title() {
        return __( 'Booking Form', 'cbf' );
    }

    public function get_icon() {
        return 'eicon-calendar';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {
        // No controls needed for this widget
    }

    protected function render() {
        ?>
        <form id="cbf-booking-form">
            <h2>CONTACT DETAILS:</h2>
            <div class="cbf-form-group">
                <label for="cbf-name">Name - First name:</label>
                <input type="text" id="cbf-name" name="name" required>
            </div>
            <div class="cbf-form-group">
                <label for="cbf-address1">Address 1:</label>
                <input type="text" id="cbf-address1" name="address1" required>
            </div>
            <div class="cbf-form-group">
                <label for="cbf-address2">Address 2:</label>
                <input type="text" id="cbf-address2" name="address2">
            </div>
            <div class="cbf-form-group">
                <label for="cbf-postal_city">Postal Code - City:</label>
                <input type="text" id="cbf-postal_city" name="postal_city" required>
            </div>
            <div class="cbf-form-group">
                <label for="cbf-country">Country:</label>
                <input type="text" id="cbf-country" name="country" required>
            </div>
            <div class="cbf-form-group">
                <label for="cbf-telephone">Telephone - Fax:</label>
                <input type="text" id="cbf-telephone" name="telephone">
            </div>
            <div class="cbf-form-group">
                <label for="cbf-email">E-mail:</label>
                <input type="email" id="cbf-email" name="email" required>
            </div>

            <h2>RESERVATION:</h2>
            <div class="cbf-form-group">
                <label for="cbf-arrival_date">Arrival date:</label>
                <input id="cbf-arrival_date" name="arrival_date" required>
            </div>
            <div class="cbf-form-group">
                <label for="cbf-departure_date">Departure date:</label>
                <input id="cbf-departure_date" name="departure_date" required>
            </div>
            <div class="cbf-form-group">
                <label for="cbf-adults">Number of adults:</label>
                <input type="number" id="cbf-adults" name="adults" value="0" min="0">
            </div>
            <div class="cbf-form-group">
                <label for="cbf-children_7_18">Number of children 7 - 18 years - Ages:</label>
                <input type="number" id="cbf-children_7_18" name="children_7_18" value="0" min="0">
            </div>
            <div class="cbf-form-group">
                <label for="cbf-children_2_7">Number of children 2 - 7 years - Ages:</label>
                <input type="number" id="cbf-children_2_7" name="children_2_7" value="0" min="0">
            </div>
            <div class="cbf-form-group">
                <label for="cbf-children_under_2">Number of children - 2 years - Ages:</label>
                <input type="number" id="cbf-children_under_2" name="children_under_2" value="0" min="0">
            </div>
            <div class="cbf-form-group">
                <label for="cbf-surface">Surface:</label>
                <select id="cbf-surface" name="surface">
                    <option value="90m²">90m²</option>
                    <option value="90-120m²">90 to 120m²</option>
                </select>
            </div>
            <div class="cbf-form-group">
                <label for="cbf-location_for">Location for:</label>
                <input type="number" id="cbf-tents" name="tents" value="0" min="0"> tent(s)
                <input type="number" id="cbf-caravan" name="caravan" value="0" min="0"> caravan
                <input type="number" id="cbf-folding_caravan" name="folding_caravan" value="0" min="0"> folding caravan
                <input type="number" id="cbf-motorhome" name="motorhome" value="0" min="0"> Motorhome/Motorhome/Camper - Dimensions: <input type="text" id="cbf-motorhome_dimensions" name="motorhome_dimensions">
            </div>
            <div class="cbf-form-group">
                <label for="cbf-additional_tents">Additional tent(s):</label>
                <input type="number" id="cbf-additional_tents" name="additional_tents" value="0" min="0">
            </div>
            <div class="cbf-form-group">
                <label for="cbf-additional_cars">Additional car(s):</label>
                <input type="number" id="cbf-additional_cars" name="additional_cars" value="0" min="0">
            </div>
            <div class="cbf-form-group">
                <label for="cbf-electricity">Electricity:</label>
                <select id="cbf-electricity" name="electricity">
                    <option value="no">No</option>
                    <option value="4">4 amps</option>
                    <option value="10">10 amps</option>
                </select>
            </div>
            <div class="cbf-form-group">
                <label for="cbf-dogs">Dog(s):</label>
                <select id="cbf-dogs" name="dogs">
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                </select>
            </div>
            <div class="cbf-form-group">
                <label for="cbf-comments">Comments:</label>
                <textarea id="cbf-comments" name="comments"></textarea>
            </div>

            <h2>DEPOSIT:</h2>
            <div class="cbf-form-group">
                <label for="cbf-deposit">Payment (25% of the amount of the stay*):</label>
                <input type="text" id="cbf-deposit" name="deposit" readonly>
            </div>
            <p>* No refund in case of cancellation</p>

            <div class="cbf-form-group">
                <input type="checkbox" id="cbf-accept_conditions" name="accept_conditions" required> I have read and accept the general rental conditions
            </div>
            <div class="cbf-form-group">
                <button id="cbf-calculate" type="submit">Calculate</button>
                <button id="cbf-reserve" type="submit">Reserve</button>
            </div>
        </form>


        <?php
        if ( isset($_POST['arrival_date'] ) && isset($_POST['departure_date'] ) ) {
            $admin_email = 'admin@example.com'; // Replace with admin email
            $user_email = sanitize_email($_POST['email']);
            $subject = 'Booking Form Submission';
            $headers = array('Content-Type: text/html; charset=UTF-8');

            // Admin email template
            ob_start();
            ?>
            <h1>New Booking Details</h1>
            <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
                <tr><td><strong>Name:</strong></td><td><?php echo sanitize_text_field($_POST['name']); ?></td></tr>
                <tr><td><strong>Address 1:</strong></td><td><?php echo sanitize_text_field($_POST['address1']); ?></td></tr>
                <tr><td><strong>Address 2:</strong></td><td><?php echo sanitize_text_field($_POST['address2']); ?></td></tr>
                <tr><td><strong>Postal Code - City:</strong></td><td><?php echo sanitize_text_field($_POST['postal_city']); ?></td></tr>
                <tr><td><strong>Country:</strong></td><td><?php echo sanitize_text_field($_POST['country']); ?></td></tr>
                <tr><td><strong>Telephone:</strong></td><td><?php echo sanitize_text_field($_POST['telephone']); ?></td></tr>
                <tr><td><strong>Email:</strong></td><td><?php echo sanitize_email($_POST['email']); ?></td></tr>
                <tr><td><strong>Arrival Date:</strong></td><td><?php echo sanitize_text_field($_POST['arrival_date']); ?></td></tr>
                <tr><td><strong>Departure Date:</strong></td><td><?php echo sanitize_text_field($_POST['departure_date']); ?></td></tr>
                <tr><td><strong>Number of Adults:</strong></td><td><?php echo intval($_POST['adults']); ?></td></tr>
                <tr><td><strong>Number of Children 7-18:</strong></td><td><?php echo intval($_POST['children_7_18']); ?></td></tr>
                <tr><td><strong>Number of Children 2-7:</strong></td><td><?php echo intval($_POST['children_2_7']); ?></td></tr>
                <tr><td><strong>Number of Children under 2:</strong></td><td><?php echo intval($_POST['children_under_2']); ?></td></tr>
                <tr><td><strong>Surface:</strong></td><td><?php echo sanitize_text_field($_POST['surface']); ?></td></tr>
                <tr><td><strong>Tents:</strong></td><td><?php echo intval($_POST['tents']); ?></td></tr>
                <tr><td><strong>Caravan:</strong></td><td><?php echo intval($_POST['caravan']); ?></td></tr>
                <tr><td><strong>Folding Caravan:</strong></td><td><?php echo intval($_POST['folding_caravan']); ?></td></tr>
                <tr><td><strong>Motorhome:</strong></td><td><?php echo intval($_POST['motorhome']); ?></td></tr>
                <tr><td><strong>Motorhome Dimensions:</strong></td><td><?php echo sanitize_text_field($_POST['motorhome_dimensions']); ?></td></tr>
                <tr><td><strong>Additional Tents:</strong></td><td><?php echo intval($_POST['additional_tents']); ?></td></tr>
                <tr><td><strong>Additional Cars:</strong></td><td><?php echo intval($_POST['additional_cars']); ?></td></tr>
                <tr><td><strong>Electricity:</strong></td><td><?php echo sanitize_text_field($_POST['electricity']); ?></td></tr>
                <tr><td><strong>Dogs:</strong></td><td><?php echo sanitize_text_field($_POST['dogs']); ?></td></tr>
                <tr><td><strong>Comments:</strong></td><td><?php echo sanitize_textarea_field($_POST['comments']); ?></td></tr>
                <tr><td><strong>DEPOSIT:</strong></td><td><?php echo sanitize_textarea_field($_POST['deposit']); ?></td></tr>
            </table>
            <?php
            $admin_message = ob_get_clean();

            // User email template
            ob_start();
            ?>
            <h1>Booking Confirmation</h1>
            <p>Thank you for your booking. Here are the details:</p>
            <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
                <tr><td><strong>Name:</strong></td><td><?php echo sanitize_text_field($_POST['name']); ?></td></tr>
                <tr><td><strong>Address 1:</strong></td><td><?php echo sanitize_text_field($_POST['address1']); ?></td></tr>
                <tr><td><strong>Address 2:</strong></td><td><?php echo sanitize_text_field($_POST['address2']); ?></td></tr>
                <tr><td><strong>Postal Code - City:</strong></td><td><?php echo sanitize_text_field($_POST['postal_city']); ?></td></tr>
                <tr><td><strong>Country:</strong></td><td><?php echo sanitize_text_field($_POST['country']); ?></td></tr>
                <tr><td><strong>Telephone:</strong></td><td><?php echo sanitize_text_field($_POST['telephone']); ?></td></tr>
                <tr><td><strong>Email:</strong></td><td><?php echo sanitize_email($_POST['email']); ?></td></tr>
                <tr><td><strong>Arrival Date:</strong></td><td><?php echo sanitize_text_field($_POST['arrival_date']); ?></td></tr>
                <tr><td><strong>Departure Date:</strong></td><td><?php echo sanitize_text_field($_POST['departure_date']); ?></td></tr>
                <tr><td><strong>Number of Adults:</strong></td><td><?php echo intval($_POST['adults']); ?></td></tr>
                <tr><td><strong>Number of Children 7-18:</strong></td><td><?php echo intval($_POST['children_7_18']); ?></td></tr>
                <tr><td><strong>Number of Children 2-7:</strong></td><td><?php echo intval($_POST['children_2_7']); ?></td></tr>
                <tr><td><strong>Number of Children under 2:</strong></td><td><?php echo intval($_POST['children_under_2']); ?></td></tr>
                <tr><td><strong>Surface:</strong></td><td><?php echo sanitize_text_field($_POST['surface']); ?></td></tr>
                <tr><td><strong>Tents:</strong></td><td><?php echo intval($_POST['tents']); ?></td></tr>
                <tr><td><strong>Caravan:</strong></td><td><?php echo intval($_POST['caravan']); ?></td></tr>
                <tr><td><strong>Folding Caravan:</strong></td><td><?php echo intval($_POST['folding_caravan']); ?></td></tr>
                <tr><td><strong>Motorhome:</strong></td><td><?php echo intval($_POST['motorhome']); ?></td></tr>
                <tr><td><strong>Motorhome Dimensions:</strong></td><td><?php echo sanitize_text_field($_POST['motorhome_dimensions']); ?></td></tr>
                <tr><td><strong>Additional Tents:</strong></td><td><?php echo intval($_POST['additional_tents']); ?></td></tr>
                <tr><td><strong>Additional Cars:</strong></td><td><?php echo intval($_POST['additional_cars']); ?></td></tr>
                <tr><td><strong>Electricity:</strong></td><td><?php echo sanitize_text_field($_POST['electricity']); ?></td></tr>
                <tr><td><strong>Dogs:</strong></td><td><?php echo sanitize_text_field($_POST['dogs']); ?></td></tr>
                <tr><td><strong>Comments:</strong></td><td><?php echo sanitize_textarea_field($_POST['comments']); ?></td></tr>
                <tr><td><strong>DEPOSIT:</strong></td><td><?php echo sanitize_textarea_field($_POST['deposit']); ?></td></tr>
            </table>
            <?php
            $user_message = ob_get_clean();

            // Send email to admin
            wp_mail($admin_email, $subject, $admin_message, $headers);

            // Send confirmation email to user
            wp_mail($user_email, $subject, $user_message, $headers);

            echo '<p>Thank you for your submission. A confirmation email has been sent to you.</p>';
        }
    }

    protected function _content_template() {}
}
