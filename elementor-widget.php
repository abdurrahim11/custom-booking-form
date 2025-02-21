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
                <input type="number" id="cbf-location_for" name="location_for" value="0" min="0">
                <label for="cbf-tents">Tent(s):</label>
                <input type="number" id="cbf-tents" name="tents" value="0" min="0">
                <label for="cbf-caravan">Caravan:</label>
                <input type="number" id="cbf-caravan" name="caravan" value="0" min="0">
                <label for="cbf-folding_caravan">Folding caravan:</label>
                <input type="number" id="cbf-folding_caravan" name="folding_caravan" value="0" min="0">
                <label for="cbf-motorhome">Motorhome/Motorhome/Camper:</label>
                <input type="number" id="cbf-motorhome" name="motorhome" value="0" min="0">
                <label for="cbf-motorhome_dimensions">Dimensions:</label>
                <input type="text" id="cbf-motorhome_dimensions" name="motorhome_dimensions">
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
                <button id="cbf-reserve" type="submit">
                    <div class="cbf-reserve-text">Reserve</div>
                    <span class="cbf-loader" style="display: none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" width="40" height="40" style="shape-rendering: auto; display: block; background: rgb(255, 255, 255);" xmlns:xlink="http://www.w3.org/1999/xlink"><g><g transform="rotate(0 50 50)">
  <rect fill="#777777" height="12" width="6" ry="6" rx="3" y="24" x="47">
    <animate repeatCount="indefinite" begin="-0.9166666666666666s" dur="1s" keyTimes="0;1" values="1;0" attributeName="opacity"></animate>
  </rect>
</g><g transform="rotate(30 50 50)">
  <rect fill="#777777" height="12" width="6" ry="6" rx="3" y="24" x="47">
    <animate repeatCount="indefinite" begin="-0.8333333333333334s" dur="1s" keyTimes="0;1" values="1;0" attributeName="opacity"></animate>
  </rect>
</g><g transform="rotate(60 50 50)">
  <rect fill="#777777" height="12" width="6" ry="6" rx="3" y="24" x="47">
    <animate repeatCount="indefinite" begin="-0.75s" dur="1s" keyTimes="0;1" values="1;0" attributeName="opacity"></animate>
  </rect>
</g><g transform="rotate(90 50 50)">
  <rect fill="#777777" height="12" width="6" ry="6" rx="3" y="24" x="47">
    <animate repeatCount="indefinite" begin="-0.6666666666666666s" dur="1s" keyTimes="0;1" values="1;0" attributeName="opacity"></animate>
  </rect>
</g><g transform="rotate(120 50 50)">
  <rect fill="#777777" height="12" width="6" ry="6" rx="3" y="24" x="47">
    <animate repeatCount="indefinite" begin="-0.5833333333333334s" dur="1s" keyTimes="0;1" values="1;0" attributeName="opacity"></animate>
  </rect>
</g><g transform="rotate(150 50 50)">
  <rect fill="#777777" height="12" width="6" ry="6" rx="3" y="24" x="47">
    <animate repeatCount="indefinite" begin="-0.5s" dur="1s" keyTimes="0;1" values="1;0" attributeName="opacity"></animate>
  </rect>
</g><g transform="rotate(180 50 50)">
  <rect fill="#777777" height="12" width="6" ry="6" rx="3" y="24" x="47">
    <animate repeatCount="indefinite" begin="-0.4166666666666667s" dur="1s" keyTimes="0;1" values="1;0" attributeName="opacity"></animate>
  </rect>
</g><g transform="rotate(210 50 50)">
  <rect fill="#777777" height="12" width="6" ry="6" rx="3" y="24" x="47">
    <animate repeatCount="indefinite" begin="-0.3333333333333333s" dur="1s" keyTimes="0;1" values="1;0" attributeName="opacity"></animate>
  </rect>
</g><g transform="rotate(240 50 50)">
  <rect fill="#777777" height="12" width="6" ry="6" rx="3" y="24" x="47">
    <animate repeatCount="indefinite" begin="-0.25s" dur="1s" keyTimes="0;1" values="1;0" attributeName="opacity"></animate>
  </rect>
</g><g transform="rotate(270 50 50)">
  <rect fill="#777777" height="12" width="6" ry="6" rx="3" y="24" x="47">
    <animate repeatCount="indefinite" begin="-0.16666666666666666s" dur="1s" keyTimes="0;1" values="1;0" attributeName="opacity"></animate>
  </rect>
</g><g transform="rotate(300 50 50)">
  <rect fill="#777777" height="12" width="6" ry="6" rx="3" y="24" x="47">
    <animate repeatCount="indefinite" begin="-0.08333333333333333s" dur="1s" keyTimes="0;1" values="1;0" attributeName="opacity"></animate>
  </rect>
</g><g transform="rotate(330 50 50)">
  <rect fill="#777777" height="12" width="6" ry="6" rx="3" y="24" x="47">
    <animate repeatCount="indefinite" begin="0s" dur="1s" keyTimes="0;1" values="1;0" attributeName="opacity"></animate>
  </rect>
</g><g></g></g><!-- [ldio] generated by https://loading.io --></svg>
                    </span>
                </button>
            </div>
            <div id="cbf-form-message"></div>
        </form>
        <?php
    }
}
