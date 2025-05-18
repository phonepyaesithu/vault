<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - HYPELOKAL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/png" href="pictures/hlogo.png">
    <style>
        @font-face {
            font-family: SFBold;
            src: url(fonts/SFPRODISPLAYBOLD.OTF);
        }

        h1 {
            font-family: SFBold;
        }

        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            text-align: justify;
        }

        .contact-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 50px 20px;
        }

        .contact-info, .contact-form {
            flex: 1;
            min-width: 300px;
            max-width: 500px;
            padding: 20px;
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .contact-info h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .contact-info h3 {
            font-size: 1.5rem;
            margin-top: 20px;
        }

        .contact-form h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .contact-info h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <div id="spacer-div" style="height: 70px; background-color: white;"></div>

    <div class="contact-section">
        <div class="contact-info">
            <h1>Contact Us</h1>
            <p>If you have any questions, concerns, or feedback, feel free to reach out to us through the following methods:</p>

            <h3>Email</h3>
            <p><strong>General Inquiries:</strong> <a href="mailto:info@vault.com">info@hypelokal.com</a><br>
            <strong>Support:</strong> <a href="mailto:support@vault.com">support@hypelokal.com</a></p>

            <h3>Phone</h3>
            <p><strong>Customer Service:</strong> +95 1234 567 890<br>
            <strong>Business Inquiries:</strong> +95 1234 567 891</p>

            <h3>Address</h3>
            <p>HYPELOKAL Headquarters<br>1234 Fashion Street, Suite 101<br>RANGOON, BURMA</p>

            <h3>Social Media</h3>
            <p>
                <a href="https://www.instagram.com/vault" target="_blank"><i class="fab fa-instagram"></i> Instagram</a><br>
                <a href="https://www.twitter.com/vault" target="_blank"><i class="fab fa-twitter"></i> Twitter</a><br>
                <a href="https://www.facebook.com/vault" target="_blank"><i class="fab fa-facebook"></i> Facebook</a>
            </p>

            <h3>Business Hours</h3>
            <p>Monday - Friday: 9:00 AM - 6:00 PM (MMT)<br>Saturday: 10:00 AM - 4:00 PM (MMT)<br>Sunday: Closed</p>
        </div>

        <div class="contact-form">
            <h3>Contact Form</h3>
            <form action="submit_contact.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first-name" name="firstname" required>
                </div>
                <div class="mb-3">
                    <label for="last-name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last-name" name="lastname" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Your Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>

    <?php include('burger_slider.php') ?>
    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
