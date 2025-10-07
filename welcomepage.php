<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Registering with JIFFY</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            text-align: center;
            padding: 50px;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
            font-size: 18px;
            line-height: 1.6;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Decode URL parameters and store in variables
        $email = isset($_GET['name']) ? urldecode($_GET['name']) : '';
        $companyname = isset($_GET['companyname']) ? urldecode($_GET['companyname']) : '';
        ?>
        
        <h1>Thank You <?php echo htmlspecialchars($email) ?> for Registering with JIFFY!</h1>
        <img src="./assets/Welcome.gif" alt="Welcome GIF" style="max-width: 100%; height: auto;">
        <p>We are excited to welcome you and <?php echo htmlspecialchars($companyname) ?> to JIFFY, your go-to platform for Digital Office. Your registration is complete and you are now part of our community.</p>
        
        <p>To get started, explore the many features we offer:</p>
        <ul style="text-align: left;">
            <li>Access exclusive content tailored just for you.</li>
            <li>Connect with like-minded individuals and share your experiences.</li>
            <li>Stay updated with the latest news and trends.</li>
            <li>Join upcoming events and workshops.</li>
        </ul>

        <p>Feel free to <a href="mailto:info@jiffy.mineit.tech">contact us</a> if you have any questions or need assistance.</p>
        <p>Visit our <a href="https://jiffy.mineit.tech">website</a> to explore more.</p>
    </div>
</body>
</html>
