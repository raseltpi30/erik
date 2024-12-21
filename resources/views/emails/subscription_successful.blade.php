<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Crystal Cleaning Services!</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700&display=swap');

        body {
            font-family: 'Manrope', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #000000;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .header {
            background-color: rgb(242, 240, 233);
            color: #000000;
            padding: 20px 0;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .header p {
            margin: 0;
            font-size: 18px;
            font-weight: 500;
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
            padding-left: 20px;
        }

        p.last {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Crystal Clean Services! Subscription Successful</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>Thank you for subscribing to Crystal Clean Sydney! We’re excited to have you on board.</p>
            <p>Your email address <strong>{{$email}}</strong> has been successfully added to our list, and you’ll be the first to know about exclusive offers, cleaning tips, and updates on our services.</p>
            <p>If you have any questions or need assistance, please feel free to reach out.</p>
            <p class="last">Best regards,</p>
            <p>The Crystal Clean Sydney Team</p>
        </div>
    </div>
</body>

</html>
