$(document).ready(function () {
    console.log('DOM fully loaded and parsed');
    $('#total-price-3').val(''); // for refresh page coupon when i refresh page coupon input will 0.
    $('#discount-code').val(''); // for refresh page coupon when i refresh page coupon input will 0.

    // Extract query parameters
    const urlParams = new URLSearchParams(window.location.search);
    const firstName = urlParams.get('first-name');
    const lastName = urlParams.get('last-name');
    const email = urlParams.get('email');
    const service = urlParams.get('service');
    const bathroom = urlParams.get('bathroom');
    const frequency = urlParams.get('frequency');

    // Set form values if query parameters are present
    if (firstName) $('#first-name').val(firstName);
    if (lastName) $('#last-name').val(lastName);
    if (email) $('#email').val(email);
    if (bathroom) $('#bathroom').val(bathroom);
    if (frequency) $(`input[name="frequency"][value="${frequency}"]`).prop('checked', true);

    // Prices and extra data
    const servicePrices = {
        "Studio or 1 Bedroom": 0,
        "2 Bedroom": 25,    // 0 + 25
        "3 Bedroom": 60,    // 25 + 35
        "4 Bedroom": 95,
        "5 Bedroom": 130,
        "6 Bedroom": 165,   //
        "7 Bedroom": 200,   //
        "8 Bedroom": 235,   //
        "9 Bedroom": 270,   //
        "10 Bedroom": 305,  //
        "11 Bedroom": 340   //
    };

    const endOfLeaseServicePrices = {
        "Studio or 1 Bedroom": 0,
        "2 Bedroom": 50,
        "3 Bedroom": 100,
        "4 Bedroom": 150,
        "5 Bedroom": 200,
        "6 Bedroom": 250,
        "7 Bedroom": 300,
        "8 Bedroom": 350,
        "9 Bedroom": 400,
        "10 Bedroom": 450,
        "11 Bedroom": 500
    };

    const bathroomPrices = {
        "1 Bathroom": 0,
        "2 Bathroom": 25,
        "3 Bathroom": 50,
        "4 Bathroom": 75,
        "5 Bathroom": 100,
        "6 Bathroom": 125,
        "7 Bathroom": 150
    };

    const storeyPrices = {
        "Single storey home": 0,
        "Double storey home": 35,
        "Triple storey home": 70
    };

    const typeOfServicePrices = {
        "General Cleaning": 130,
        "Deep Cleaning": 220,
        "End of Lease Cleaning": 400,
        "Organisation by the Hour": 0
    };

    const frequencyDiscounts = {
        "week": 0.15,
        "fortnight": 0.10,
        "month": 0.05,
        "One-time": 0
    };

    const freeAddOns = {
        "Deep Cleaning": ["High Dusting", "I Have Pets"],
        "End of Lease Cleaning": ["Oven Cleaning",  "Inside Cupboards Empty", "Refrigerator Cleaning Empty","Window Cleaning", "Blind Cleaning", "High Dusting", "I Have Pets"],
        "Organisation by the Hour": ["Oven Cleaning", "Refrigerator Cleaning Empty", "Refrigerator Cleaning Full", "Dishwasher Cleaning", "Inside Cupboards Empty", "Window Cleaning", "Sliding Door Window", "Blind Cleaning", "High Dusting", "Garage Cleaning", "Balcony Cleaning Small", "Balcony Cleaning Large", "Change Sheets", "Shed/Pool House", "I Have Pets"]
    };

    // this is for

    let discountCode = '';
    let discountAmount = 0;
    const calculateTotal = () => {
        let total = 0;
        let extrasTotal = 0;
        const service = $('#service').val();
        const bathroom = $('#bathroom').val();
        const storey = $('#storey').val();
        const typeOfService = $('#type-of-service').val();

        // this is for new function

        if (typeOfService === "Organisation by the Hour") {
            // Disable the fields
            $('#service').prop('disabled', true).val('Studio or 1 Bedroom');
            $('#bathroom').prop('disabled', true).val('1 Bathroom');
            $('#storey').prop('disabled', true).val('Single storey home');
        } else {
            // Enable the fields
            $('#service').prop('disabled', false);
            $('#bathroom').prop('disabled', false);
            $('#storey').prop('disabled', false);
        }


        // this is new end function

        total += (typeOfService === "End of Lease Cleaning" ? endOfLeaseServicePrices[service] : servicePrices[service]) || 0;
        total += bathroomPrices[bathroom] || 0;
        total += storeyPrices[storey] || 0;
        total += typeOfServicePrices[typeOfService] || 0;

        $('#cleaning-plan-details').text(`${service}, ${bathroom}, ${storey}`);
        $('#selected-service').text(typeOfService);
        $('#service-cost').text(`${typeOfService}: $${typeOfServicePrices[typeOfService]}`);

        console.log('Base total:', total);
        $('#service-cost').text(`$${total.toFixed(2)}`);

        const selectedExtras = $('.extra-item.highlighted');
        const extrasList = $('#selected-extras').empty();
        const extraCounts = {};
        const extrasObject = {}; // Object to store extras details

        selectedExtras.each(function () {
            const $extra = $(this);
            const price = parseFloat($extra.data('price'));
            const label = $extra.find('label').text().split(' $')[0];
            const count = parseInt($extra.find('.counter').text()) || 1;

            if (extraCounts[label]) {
                extraCounts[label].count += count;
            } else {
                extraCounts[label] = { price, count };
            }
        });
        // console.log('Extras before processing free add-ons:', extraCounts);

        $.each(extraCounts, (label, item) => {
            let itemTotal = item.price * item.count;
            if (freeAddOns[typeOfService] && freeAddOns[typeOfService].includes(label)) {
                itemTotal = 0;
            }
            total += itemTotal;
            extrasTotal += itemTotal;
            extrasObject[label] = {
                price: item.price,
            };

            const $listItem = $('<li>').text(item.count > 1 ? `${label} x${item.count}` : `${label}`);
            extrasList.append($listItem);
        });

        $('#extras-total').text(`$${extrasTotal.toFixed(2)}`);
        // console.log('Total after extras:', total);

        const frequencyDiscount = $('input[name="frequency"]:checked').val();
        if (frequencyDiscount) {
            const discount = frequencyDiscounts[frequencyDiscount];
            const frequencyDiscountAmount = total * discount;
            total -= frequencyDiscountAmount;
            $('#frequency-discount').text(`-$${frequencyDiscountAmount.toFixed(2)}`);
            $('#total-price-2').val(frequencyDiscountAmount.toFixed(2));
            // console.log('Total after frequency discount:', total);
        } else {
            $('#frequency-discount').text('');
        }

        if (discountCode === 'WELCOME10%') {
            discountAmount = total * 0.10;
            $('#discount-amount').text(`Discount (10%): -$${discountAmount.toFixed(2)}`);
            $('#total-price-3').val(discountAmount.toFixed(2));
        } else {
            discountAmount = 0;
            $('#discount-amount').text('');
        }
        total -= discountAmount;
        $('#total').text(`$${total.toFixed(2)}`);
        $('#total-price-input').val(total.toFixed(2));
        // console.log('Final total after all discounts:', total);
        window.extrasObject = extrasObject;
    };
    const applyDiscountCode = () => {
        // console.log('Apply Code button clicked');
        const inputCode = $('.discount-code-input').val().trim().toUpperCase();

        // Check if the input code is empty
        if (inputCode === '') {
            alert('Discount code is required');
        } else if (inputCode === 'WELCOME10%') {
            discountCode = inputCode;
            alert('Discount code applied successfully!');
        } else {
            discountCode = '';
            alert('Invalid discount code');
        }

        calculateTotal();

    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    const resetAllAddOns = () => {
        $('.extra-item').removeClass('highlighted always-visible').css('pointer-events', 'auto').find('.counter').text('');
    };

    const handleTypeOfServiceChange = () => {
        const typeOfService = $('#type-of-service').val();
        resetAllAddOns();

        $('.extra-item').each(function () {
            const $extra = $(this);
            const label = $extra.find('label').text().split(' $')[0];
            const $counter = $extra.find('.counter');
            const $increaseButton = $extra.find('.increase');
            const $decreaseButton = $extra.find('.decrease');

            if (typeOfService === "Deep Cleaning" && freeAddOns["Deep Cleaning"].includes(label)) {
                $extra.addClass('highlighted').css('pointer-events', 'none');
            } else if (typeOfService === "End of Lease Cleaning" && freeAddOns["End of Lease Cleaning"].includes(label)) {
                $extra.addClass('highlighted').css('pointer-events', 'none');
            } else if (typeOfService === "Organisation by the Hour") {
                if (label === "Carpet Cleaning $70/room") {
                    $extra.addClass('highlighted always-visible');
                    $counter.text('1');
                    $increaseButton.show();
                    $decreaseButton.show().css('pointer-events', 'none');

                    if (!$('#select-hours-note').length) {
                        $('<div>', {
                            id: 'select-hours-note',
                            text: 'Please Select Hours',
                            css: { color: 'red' }
                        }).appendTo($extra);
                    }
                } else if (freeAddOns["Organisation by the Hour"].includes(label)) {
                    $extra.addClass('highlighted').css('pointer-events', 'none');
                }
            }
        });

        calculateTotal();
    };

    const setupEventListeners = () => {
        $('select, input[name="frequency"]').change(calculateTotal);

        $('.extra-item').each(function () {
            const $extra = $(this);

            if ($extra.hasClass('walls-interior-windows')) {
                const $counter = $extra.find('.counter');
                let count = parseInt($counter.text()) || 0;

                const $increaseButton = $extra.find('.increase');
                const $decreaseButton = $extra.find('.decrease');

                $increaseButton.click(function (event) {
                    event.stopPropagation();
                    count++;
                    $counter.text(count);
                    $extra.addClass('highlighted');
                    $decreaseButton.css('pointer-events', count > 0 ? 'auto' : 'none');
                    calculateTotal();
                });

                $decreaseButton.click(function (event) {
                    event.stopPropagation();
                    if (count > 0) {
                        count--;
                        $counter.text(count);
                        if (count === 0) {
                            $extra.removeClass('highlighted');
                            $counter.text("");
                        }
                        $decreaseButton.css('pointer-events', count > 0 ? 'auto' : 'none');
                        calculateTotal();
                    }
                });
            } else {
                $extra.click(function () {
                    $(this).toggleClass('highlighted');
                    calculateTotal();
                });
            }
        });

        $('#type-of-service').change(handleTypeOfServiceChange);
        $('.apply-discount-button').click(applyDiscountCode);
    };

    setupEventListeners();

    // Set initial values
    $('#service').val(service || "Studio or 1 Bedroom");
    $('#bathroom').val(bathroom || "1 Bathroom");
    $('#storey').val("Single storey home");
    $('#type-of-service').val("General Cleaning");
    calculateTotal();



    // Initialize Stripe
    var stripe = Stripe('pk_test_51PylzqRq0gWoIKN4CJpBWQP5AOiDUYAUZ8V4bsG2vKKRRWYO3j1eD90VYwpGhWstTlz3fJRDPifKUzvSJpIIWF4B00Wl8MLfdK'); // Replace with your Stripe public key
    var elements = stripe.elements();
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    // Create a card element without the ZIP/postal code field
    var card = elements.create('card', {
        style: style,
        hidePostalCode: true
    });
    card.mount('#card-element');

    // Use jQuery to handle the change event
    card.on('change', function (event) {
        var displayError = $('#card-errors');
        if (event.error) {
            displayError.text(event.error.message);
        } else {
            displayError.text('');
        }
    });


    // for blur validate and input valid
    let allFieldsValid = true;
    // Define the validation functions
    function validatePhoneNumber(phoneNumber) {
        // const phoneRegex = /^(\+8801|01)[3-9]\d{8}$/;
        const phoneRegex = /^\d+$/;
        return phoneRegex.test(phoneNumber);
    }

    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }


    function validateFutureDate(dateString) {
        // Assuming dateString is in YYYY-M-D format
        const inputDate = new Date(dateString);
        const today = new Date();

        // Check if the date is valid
        if (isNaN(inputDate.getTime())) {
            console.log("Invalid date format");
            return false; // Invalid date
        }

        // Define the restricted date range (9th Dec 2024 to 15th Dec 2024)
        const startDate = new Date('2024-12-09');
        const endDate = new Date('2024-12-15');

        // Check if the input date is within the restricted range
        if (inputDate >= startDate && inputDate <= endDate) {
            return false; // Invalid date in the restricted range
        }

        // Return false if today or past dates are selected
        if (inputDate <= today) {
            console.log("Today booking not possible");
            return false;
        }

        return true; // Return true only for future dates outside the restricted range
    }


    // function validateFutureDate(dateString) {
    //     // Assuming dateString is in YYYY-M-D format
    //     const inputDate = new Date(dateString);
    //     const today = new Date();
    //     // Check if the date is valid
    //     if (isNaN(inputDate.getTime())) {
    //         console.log("Invalid date format");
    //         return false; // Invalid date
    //     }

    //     // Return false if today or past dates are selected
    //     if (inputDate <= today) {
    //         console.log("Today booking not possible");
    //         return false;
    //     }
    //     return true; // Return true only for future dates
    // }

    // Define fields and their validations
    const fields = [
        { id: '#first-name', name: 'firstName' },
        { id: '#last-name', name: 'lastName' },
        { id: '#email', name: 'email', validate: validateEmail },
        { id: '#phone', name: 'phone', validate: validatePhoneNumber },
        { id: '#street', name: 'street' },
        { id: '#city', name: 'city' },
        { id: '#postal-code', name: 'postal-code' },
        { id: '#day', name: 'day', validate: validateFutureDate },
        { id: '#time', name: 'time' },
    ];
    function validateField(field) {
        const value = $(field.id).val().trim();
        const errorElement = $(`${field.id}-error`);

        if (!value) {
            allFieldsValid = false;
            errorElement.text(`The ${field.name} field is required.`);
            errorElement.stop(true, true).slideDown(); // Show the error message with sliding effect
        } else if (field.validate) {
            // Perform specific validation if provided
            const isValid = field.validate(value);
            if (!isValid) {
                allFieldsValid = false;
                if (field.name === 'day') { // Adjust 'date' to match your specific field name
                    errorElement.text(`Fully Booked: December 9th to 15th. Please select a future date.`);
                    // errorElement.text(`Select a future date for your booking.`);
                } else {
                    errorElement.text(`The ${field.name} is not valid.`);
                }
                errorElement.stop(true, true).slideDown(); // Show the error message with sliding effect
            } else {
                errorElement.stop(true, true).slideUp(); // Hide the error message with sliding effect
            }
        } else {
            errorElement.stop(true, true).slideUp(); // Hide the error message with sliding effect
        }
    }

    // Add event listeners for each field
    fields.forEach(field => {
        $(field.id).on('input blur change', function () {
            validateField(field);
        });
    });
    $('input[name="frequency"]').on('change', function () {
        // Hide the error message when an option is selected
        $('#error-message').hide();
    });

    // this is for organization

    let count = 0; // Initialize the counter

    // Increase counter
    $("#organisation-addon .increase").click(function () {
        count++;
        $("#organisation-counter").text(count);
    });

    // Decrease counter
    $("#organisation-addon .decrease").click(function () {
        if (count > 0) {
            count--;
            $("#organisation-counter").text(count);
        }
    });
    // end orga
    $('#complete-booking-button').click(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Initial log for count
        let couponDiscountCode = $('#discount-code').val();
        console.log(couponDiscountCode);
        console.log('final', count);
        // Clear previous error messages
        $('.error-message').text('');

        // Initialize a flag to check if all fields are valid
        allFieldsValid = true; // Reset validation status
        fields.forEach(field => {
            validateField(field);
        });
        if ($('input[name="frequency"]:checked').length === 0) {
            // Show error message if none is selected
            $('#error-message').show();
        };
        let typeOfService = $('#type-of-service').val();
        if (typeOfService === 'Organisation by the Hour') {
            if (count === 0) {
                alert('Please select "Organisation by the Hour $80/2 hours" quantity.');
                allFieldsValid = false; // No hours selected
            }
            else {
                allFieldsValid = true;
            }
        }
        // for card
        if (allFieldsValid) {
            $('.loader').show();
            // Recalculate the total to ensure it's up to date
            // Calculate the total extras amount

            $('.card-error-new').hide();
            let extrasTotal = 0;
            $('.extra-item.highlighted').each(function () {
                const price = parseFloat($(this).data('price'));
                const count = parseInt($(this).find('.counter').text()) || 1; // Default to 1 if no counter text
                extrasTotal += price * count;
            });

            // Get the final total value from the input or text element
            let discountAmount = parseFloat($('#total-price-2').val());
            let couponDiscountAmount = parseFloat($('#total-price-3').val());
            console.log(couponDiscountAmount);
            let finalTotal = parseFloat($('#total-price-input').val());
            const frequency = $('input[name="frequency"]:checked').val();

            // Define frequency discounts
            const frequencyDiscounts = {
                "week": 0.15,
                "fortnight": 0.10,
                "month": 0.05,
                "One-time": 0,
            };
            // Calculate discount based on frequency
            const discountPercentage = frequencyDiscounts[frequency] || 0;
            // Update the frequency discount display
            if (discountPercentage > 0) {
                $('#frequency-discount').text(`-$${discountAmount.toFixed(2)}`);
            } else {
                $('#frequency-discount').text('');
            }
            stripe.createPaymentMethod({
                type: 'card',
                card: card
            }).then(result => {
                if (result.error) {
                    $('.loader').hide();
                } else {

                    $('.loader').show();
                    // Send the token and booking data to the server
                    if (typeOfService === 'Organisation by the Hour') {
                        // Initial log for count
                        let extrasTotal2 = $('.extras-total').text();

                        // Remove the dollar sign and convert to a number
                        extrasTotal2 = parseFloat(extrasTotal2.replace(/[$,]/g, ''));
                        const bookingData = {
                            firstName: $('#first-name').val(),
                            lastName: $('#last-name').val(),
                            email: $('#email').val(),
                            phone: $('#phone').val(),
                            street: $('#street').val(),
                            apt: $('#apt').val(),
                            city: $('#city').val(),
                            postalCode: $('#postal-code').val(),
                            service: $('#service').val(),
                            bathroom: $('#bathroom').val(),
                            typeOfService: $('#type-of-service').val(),
                            storey: $('#storey').val(),
                            frequency: frequency,
                            day: $('#day').val(),
                            time: $('#time').val(),
                            discountPercentage: discountPercentage * 100, // Convert to percentage
                            ...(discountAmount ? { discountAmount: discountAmount } : {}), // Include discount amount
                            ...(couponDiscountAmount ? { couponDiscountAmount: couponDiscountAmount } : {}), // Include discount amount
                            ...(couponDiscountCode ? { couponDiscountCode: couponDiscountCode } : {}),
                            extras: window.extrasObject = {
                                "Organisation By the Hour": { "price": count }, // Ensure 'count' is defined
                                "Oven Cleaning": { "price": 0 },
                                "Refrigerator Cleaning Empty": { "price": 0 },
                                "Refrigerator Cleaning Full": { "price": 0 },
                                "Dishwasher Cleaning": { "price": 0 },
                                "Inside Cupboards Empty": { "price": 0 },
                                "Window Cleaning": { "price": 0 },
                                "Sliding Door Window": { "price": 0 },
                                "Blind Cleaning": { "price": 0 },
                                "High Dusting": { "price": 0 },
                                "Garage Cleaning": { "price": 0 },
                                "Balcony Cleaning Small": { "price": 0 },
                                "Balcony Cleaning Large": { "price": 0 },
                                "Change Sheets": { "price": 0 },
                                "Shed/Pool House": { "price": 0 },
                                "I Have Pets": { "price": 0 },
                                "This is a hourly service show extra Price": { "price": 0 },
                            },
                            totalExtras: extrasTotal2, // Include total extras in the data
                            finalTotal: finalTotal,
                            paymentMethodId: result.paymentMethod.id // Include the Stripe token
                        };
                        console.log(bookingData);
                        $.ajax({
                            url: '/booking/store',
                            method: 'POST',
                            data: bookingData,
                            success: function (response) {
                                console.log('Booking successful:', response);
                                $('.loader').hide();
                                $('#payment-form')[0].reset();
                                card.clear();
                                $('.booking-page.extra-item').removeClass('highlighted');
                                toastr.success('booking success!');
                                const loader = document.createElement('div');
                                loader.textContent = "Loading...";
                                loader.style.fontSize = '18px';
                                loader.style.textAlign = 'center';
                                loader.style.marginTop = '20px';
                                loader.style.position = 'fixed';
                                loader.style.top = '50%';
                                loader.style.left = '50%';
                                loader.style.transform = 'translate(-50%, -50%)';
                                loader.style.zIndex = '3000'; // Ensure it's above other content
                                document.body.appendChild(loader);

                                // Create and style the message element
                                const messageContainer = document.createElement('div');
                                messageContainer.textContent = "Thank you for your booking! You will be redirected shortly.";
                                messageContainer.style.fontSize = '18px';
                                messageContainer.style.textAlign = 'center';
                                messageContainer.style.marginTop = '20px';
                                document.body.appendChild(messageContainer);

                                // Redirect after 5 seconds
                                setTimeout(() => {
                                    loader.remove(); // Remove loader before redirecting
                                    $('#discount-code').val('');
                                    window.location.reload();
                                    window.location.href = '/booking-confirmation';
                                }, 2000);
                            },
                            error: function (xhr) {
                                $('.loader').hide();
                                discountCode = '';
                                $('#discount-amount').text('');
                                $('#total-price-3').val('0');
                                $('#discount-code').val('');

                                // Recalculate the total without the discount
                                calculateTotal();
                                let errorMessage = '';

                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message; // Get the message from the JSON response
                                } else {
                                    errorMessage = 'An unexpected error occurred. Please try again later.'; // Fallback error message
                                }
                                toastr.error(errorMessage);
                            }
                        });
                    }
                    else {
                        const bookingData = {
                            firstName: $('#first-name').val(),
                            lastName: $('#last-name').val(),
                            email: $('#email').val(),
                            phone: $('#phone').val(),
                            street: $('#street').val(),
                            apt: $('#apt').val(),
                            city: $('#city').val(),
                            postalCode: $('#postal-code').val(),
                            service: $('#service').val(),
                            bathroom: $('#bathroom').val(),
                            typeOfService: $('#type-of-service').val(),
                            storey: $('#storey').val(),
                            frequency: frequency,
                            day: $('#day').val(),
                            time: $('#time').val(),
                            discountPercentage: discountPercentage * 100, // Convert to percentage
                            ...(discountAmount ? { discountAmount: discountAmount } : {}), // Include discount amount
                            ...(couponDiscountAmount ? { couponDiscountAmount: couponDiscountAmount } : {}), // Include discount amount
                            ...(couponDiscountCode ? { couponDiscountCode: couponDiscountCode } : {}),
                            extras: window.extrasObject,
                            totalExtras: extrasTotal.toFixed(2), // Include total extras in the data
                            finalTotal: finalTotal,
                            // stripeToken: result.token.id, // Include the Stripe token
                            paymentMethodId: result.paymentMethod.id // Include the Stripe token
                        };
                        console.log(bookingData);
                        $.ajax({
                            url: '/booking/store',
                            method: 'POST',
                            data: bookingData,
                            success: function (response) {
                                console.log('Booking successful:', response);
                                $('.loader').hide();
                                $('#payment-form')[0].reset();
                                card.clear();
                                $('.booking-page.extra-item').removeClass('highlighted');
                                toastr.success('booking success!');
                                const loader = document.createElement('div');
                                loader.textContent = "Loading...";
                                loader.style.fontSize = '18px';
                                loader.style.textAlign = 'center';
                                loader.style.marginTop = '20px';
                                loader.style.position = 'fixed';
                                loader.style.top = '50%';
                                loader.style.left = '50%';
                                loader.style.transform = 'translate(-50%, -50%)';
                                loader.style.zIndex = '3000'; // Ensure it's above other content
                                document.body.appendChild(loader);

                                // Create and style the message element
                                const messageContainer = document.createElement('div');
                                messageContainer.textContent = "Thank you for your booking! You will be redirected shortly.";
                                messageContainer.style.fontSize = '18px';
                                messageContainer.style.textAlign = 'center';
                                messageContainer.style.marginTop = '20px';
                                document.body.appendChild(messageContainer);

                                // Redirect after 5 seconds
                                setTimeout(() => {
                                    loader.remove(); // Remove loader before redirecting
                                    $('#discount-code').val('');
                                    window.location.reload();
                                    window.location.href = '/booking-confirmation';
                                }, 2000);
                            },
                            error: function (xhr) {
                                $('.loader').hide();
                                discountCode = '';
                                $('#discount-amount').text('');
                                $('#total-price-3').val('0');
                                $('#discount-code').val('');

                                // Recalculate the total without the discount
                                calculateTotal();
                                let errorMessage = '';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message; // Get the message from the JSON response
                                } else {
                                    errorMessage = 'An unexpected error occurred. Please try again later.'; // Fallback error message
                                }
                                toastr.error(errorMessage);
                            }
                        });

                    }
                }
            });
            // Prepare the data to be sent to the server
        } else {
            console.log("Please fill all the field");
            const scrollPosition = document.documentElement.scrollHeight * 0;
            $('.card-error-new').show();
            window.scrollTo({
                top: scrollPosition,
                behavior: 'smooth'
            });
        }
        $('.card-close').click(function () {
            $('.card-error-new').hide();
        })
    });
    // for question look
    $('.question-item h3').on('click', function () {
        var $icon = $(this).find('.toggle-icon');
        var $content = $(this).next();

        if ($content.is(':visible')) {
            // Hide the content and change the icon to '+'
            $content.slideUp(300); // Optional: for smooth transition
            $icon.text('+');
        } else {
            // Show the content and change the icon to '-'
            $content.slideDown(300); // Optional: for smooth transition
            $icon.text('-');
        }
    });

});

document.addEventListener('DOMContentLoaded', function () {
    const tooltip = document.querySelector('.tooltip');
    const tooltiptext2 = document.querySelector('.tooltiptext2');

    const tooltipContent = `
        <ul>
            <li><strong>Included:</strong> Cleaning of one living room and all kitchen/dining areas (appliances not included).</li>
            <li><strong>Extra Rooms:</strong> Additional living rooms, offices, movie rooms count as extra rooms.</li>
            <li><strong>Need Help?</strong> Unsure about your room count? Please call us at
                <a href="tel:+0426280899" class="phone">0426 280 899</a> for assistance.
            </li>
        </ul>
    `;

    // Toggle the tooltip content on click
    tooltip.addEventListener('click', function (event) {
        event.stopPropagation(); // Prevents the click event from propagating

        if (tooltiptext2.style.visibility === 'visible') {
            tooltiptext2.style.visibility = 'hidden';
            tooltiptext2.style.opacity = 0;
            tooltiptext2.innerHTML = ''; // Clear content when hiding
        } else {
            tooltiptext2.innerHTML = tooltipContent;
            tooltiptext2.style.visibility = 'visible';
            tooltiptext2.style.opacity = 1;
        }
    });

    // Close the tooltip if clicked outside
    document.body.addEventListener('click', function () {
        tooltiptext2.style.visibility = 'hidden';
        tooltiptext2.style.opacity = 0;
        tooltiptext2.innerHTML = ''; // Clear content when hiding
    });

    // Prevent click inside the tooltip from closing it
    tooltip.addEventListener('click', function (event) {
        event.stopPropagation(); // Prevent the event from propagating and closing the tooltip
    });
});

