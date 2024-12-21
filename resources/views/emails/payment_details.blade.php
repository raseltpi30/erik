<!DOCTYPE html>
<html>

<head>
    <title>Order Confirmation</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700&display=swap');

        body {
            font-family: 'Manrope', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #000000;
            /* Set all text to black */
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 0;
            /* Ensuring square edges */
        }

        .header {
            background-color: rgb(242, 240, 233);
            /* Same Brown color as the button */
            color: #000000;
            /* Black text */
            padding: 20px 0;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            /* Adjusted font size to match */
            font-weight: 700;
            /* Make it bold */
        }

        .header p {
            margin: 0;
            font-size: 18px;
            /* Adjust font size to match */
            font-weight: 500;
            /* Slightly less bold */
        }

        .content {
            padding: 20px;
        }

        .footer {
            text-align: center;
            padding: 10px 0;
            font-size: 12px;
            color: #666666;
        }

        .additional-services {
            list-style-type: disc;
            /* Bullet points */
            padding-left: 20px;
            /* Indent for bullet points */
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Crystal Clean Sydney</h1>
            <p>Order Confirmation</p>
        </div>
        <div class="content">
            <p>Hi {{ $newData['firstName'] ?? '' }}&nbsp;{{ $newData['lastName'] ?? '' }}</p>
            <br>
            <p>Thank you for choosing Crystal Clean Sydney! We have received your order and it is now being processed.
                Here are the details of your order:</p>
            <br>
            <p><strong>Order Summary:</strong></p>
            <ul>
                <li><strong>Service Type:</strong> {{ $newData['typeOfService'] ?? '' }}</li>
                <li><strong>Number of Rooms:</strong> {{ $newData['service'] ?? '' }}</li>
                <li><strong>Bathrooms:</strong> {{ $newData['bathroom'] ?? '' }}</li>
                <li><strong>Storey:</strong> {{ $newData['storey'] ?? '' }}</li>
                <li><strong>Additional Services:</strong></li>
                <ul class="additional-services">
                    @php
                    $extras = $newData['extras'] ?? [];
                    @endphp

                    @if (!empty($extras) && is_array($extras))
                    @foreach ($extras as $item => $details)
                    <li>
                        {{ htmlspecialchars($item) }}
                    </li>
                    @endforeach
                    @else
                    <li>No additional services available.</li>
                    @endif
                </ul>
                <li><strong>Service Date:</strong> {{ $newData['day'] ?? '' }}</li>
                <li><strong>Service Time:</strong> {{ $newData['time'] ?? '' }}</li>
                <li><strong>Frequency :</strong>
                    @if ($newData['frequency'] == 'week')
                    Weekly 15%
                    @elseif ($newData['frequency'] == 'month')
                    Monthly 5%
                    @elseif ($newData['frequency'] == 'fortnight')
                    Fortnightly 10%
                    @else
                    One time
                    @endif
                </li>
            </ul>

            <p><strong>Your Contact Details:</strong></p>
            <ul>
                <li><strong>Name:</strong> {{ $newData['firstName'] ?? '' }}&nbsp;{{ $newData['lastName'] ?? '' }} </li>
                <li><strong>Email:</strong>{{ $newData['email'] ?? '' }}</li> <!-- Updated to the correct merge tag -->
                <li><strong>Phone:</strong> {{ $newData['phone'] ?? '' }}</li>
                <li><strong>Service Address:</strong> {{ $newData['street'] ?? '' }}, {{ $newData['apt'] ?? ''
                    }}&nbsp;{{ $newData['city'] ?? '' }}, {{ $newData['postalCode'] ?? '' }}</li>
            </ul>

            <p><strong>What's Next?</strong></p>
            <br>
            <p>Our team will contact you shortly to confirm your appointment details. If you have any questions or need
                to make changes to your order, please contact us at info.crystalcleansyd@gmail.com or call us at 0426
                280 899.</p>
            <br>

            <p>Thank you for choosing Crystal Clean Sydney!</p>
            <p><br>Best regards,</p>
            <p>The Crystal Clean Sydney Team</p>
        </div>
    </div>
</body>

</html>

{{--
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <p>{{$newData}}</p>
</body>

</html> --}}
