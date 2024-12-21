<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Crystal Cleaning Services!</title>
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
            <h1>Welcome to Crystal Cleaning Services!</h1>
        </div>
        <div class="content">
            <p><strong>Hi there,</strong></p>
            <p>Thank you for subscribing to Crystal Clean Sydney! We're thrilled to have you on board.</p>
            <p>As a warm welcome, we're giving you an exclusive <strong>10% discount</strong> on your next booking.
            </p>
            <p>Simply use the coupon code below when you book:</p>
            <p><strong> Coupon Code: {{ $coupon }}</strong></p>
            <p><strong> Discount : 10%</strong></p>

            <p>We look forward to providing you with quality home and office cleaning services!</p>
            <p>If you have any questions or need assistance, feel free to reach out to our team.</p>
            <p>Best regards,</p>
            <p>The Crystal Clean Sydney Team</p>
        </div>
    </div>
</body>

</html>
