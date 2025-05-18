<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <footer>
        <div class="container">
            <div class="row" id="footer-row">

                <!-- Feedback Form -->
                <div class="col-md-4 mb-3">
                    <p>Give us a feedback</p>
                    <form method="post" action="feedbackupload.php">
                        <!-- <div class="form-group mb-2">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                required>
                        </div>
                        <div class="form-group mb-2">
                            <textarea class="form-control" id="feedback" name="feedback" rows="3"
                                placeholder="Your Feedback" required></textarea>
                        </div> -->
                        <div class="form-floating form-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                required>
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating form-group">
                            <textarea class="form-control" id="feedback" name="feedback" placeholder="Your Feedback"
                                required></textarea>
                            <label for="feedback">Feedback</label>
                        </div>
                        <button type="submit" class="btn btn-primary" id="feedback-button"
                            name="submit-btn">Send</button>

                    </form>
                </div>

                <!-- feedback upload php code -->
                <?php
                include('feedbackupload.php');
                ?>

            </div>
            <!-- Footer Bottom -->
            <div class="row mt-3">
                <div class="col text-center" id="footer-bottom">

                    <div class="footer__content-bottom-wrapper page-width footer__content-bottom-wrapper--center">
                        <div class="footer__copyright caption">
                            <small class="copyright__content">
                                &copy; 2025, <a href="/" title="VAULT">HYPELOKAL</a>
                            </small>
                            <ul class="policies list-unstyled">
                                <li>
                                    <small class="copyright__content">
                                        <a href="../refundpolicy.php">Refund policy</a>
                                    </small>
                                </li>
                                <li>
                                    <small class="copyright__content">
                                        <a href="../privacypolicy.php">Privacy policy</a>
                                    </small>
                                </li>
                                <li>
                                    <small class="copyright__content">
                                        <a href="../termsofservice.php">Terms of service</a>
                                    </small>
                                </li>
                                <li>
                                    <small class="copyright__content">
                                        <a href="../contact.php">Contact information</a>
                                    </small>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </footer>

</body>

</html>