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
            <p>Booking Notificatiion</p>
        </div>
        <div class="content">
            <p>Hi Erik,</p>
            <br>
            <p>A New booking has been completed.</p>
            <br>
            <p><strong>Customer Details:</strong></p>
            <ul>
                <li><strong>Customer Name:</strong> {{ $paymentData['firstName'] ?? '' }}&nbsp;{{ $paymentData['lastName'] ?? '' }} </li>
                <li><strong>Customer Email:</strong>{{ $paymentData['email'] ?? '' }}</li> <!-- Updated to the correct merge tag -->
                <li><strong>Customer Phone:</strong> {{ $paymentData['phone'] ?? '' }}</li>
            </ul>
        </div>
    </div>
</body>

</html>
