jQuery(document).ready(function($) {
    const seasons = cbf_vars.seasons.map(season => ({
        startDate: new Date(season.start_date),
        endDate: new Date(season.end_date),
        rates: season.rates
    }));

    function calculateDeposit( event ) {
        event.preventDefault();

        const arrivalDate = new Date($('#cbf-arrival_date').val());
        const departureDate = new Date($('#cbf-departure_date').val());

        if (!arrivalDate || !departureDate || arrivalDate > departureDate) {
            $('#cbf-deposit').val('');
            return;
        }

        var reservation_fee = 0;
        let totalRate = 0;
        let currentDate = new Date(arrivalDate);

        while (currentDate <= departureDate) {
            const season = seasons.find(season => currentDate >= season.startDate && currentDate <= season.endDate);
            console.log(season);
            if (season) {
                totalRate += season.rates.adults * parseInt($('#cbf-adults').val() || 0);
                totalRate += season.rates.children_2_7 * parseInt($('#cbf-children_2_7').val() || 0);
                totalRate += season.rates.emplacement * parseInt($('#cbf-emplacement').val() || 0);
                totalRate += season.rates.additional_car * parseInt($('#cbf-additional_car').val() || 0);
                totalRate += season.rates.electricity_4amps * (parseInt($('#cbf-electricity').val() === '4' ? 1 : 0));
                totalRate += season.rates.electricity_15amps * (parseInt($('#cbf-electricity').val() === '15' ? 1 : 0));
                totalRate += season.rates.additional_tent * parseInt($('#cbf-additional_tents').val() || 0);
                totalRate += season.rates.dog * (parseInt($('#cbf-dogs').val() === 'yes' ? 1 : 0));
                console.log(season.rates.reservation_fee);
                reservation_fee = season.rates.reservation_fee;
            }

            currentDate.setDate(currentDate.getDate() + 1);
        }

        console.log( totalRate );
        const depositAmount = totalRate * 0.25; // 25% deposit
        console.log( 'DEPOSIT' + depositAmount  );
        const total = depositAmount + parseInt( reservation_fee );
        $('#cbf-deposit').val(total.toFixed(2));
    }

    $('#cbf-calculate').on('click', calculateDeposit);
    //$('#cbf-arrival_date, #cbf-departure_date, #cbf-adults, #cbf-children_2_7, #cbf-emplacement, #cbf-additional_car, #cbf-electricity, #cbf-additional_tents, #cbf-dogs').on('change', calculateDeposit);
});




