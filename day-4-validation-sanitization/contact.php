<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contact Us</title>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">
</head>
<body>
        <div class="contact-form">
                <h1>Contact Us</h1>


                <form action="contact.php" method="post">
                        <label>Your Name</label>
                        <input type="text" name="name">


                        <label>Email Address</label>
                        <input type="email" name="email">


                        <label>Phone Number</label>
                        <input type="tel" name="phone">


                        <label>How can we help you?</label>
                        <select name="reason">
                                <option value="support">I need customer support.</option>
                                <option value="bug report">I'm reporting a bug.</option>
                                <option value="hi">I just wanted to say Hi!</option>
                        </select>


                        <label>Message</label>
                        <textarea name="message"></textarea>


                        <input type="submit" value="Send Message">
                        <input type="hidden" name="did_submit" value="1">
                </form>
        </div>
</body>
</html>