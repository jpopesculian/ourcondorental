<?php

require_once("../../../wp-blog-header.php");

error_reporting(E_ERROR);

function send ($error, $message) {
    if (!$error) {
        $to = get_option("contact_email");
        $subject = "New Email from OurCondoRental.com";
        $content = "
            Name: ".$_POST['name']."<br/>
            Email: ".$_POST['email']."<br/>
            Phone: ".$_POST['phone']."<br/>
            Dates: ".$_POST['date-from']." to ".$_POST['date-to']."<br/>
            Message: ".$_POST['message']."
        ";
        if (!wp_mail($to, $subject, $content)) {
            $error = true;
            $message = "Email was not able to successfuly send!";
        }
    }
    echo json_encode(array(
        'error' => $error,
        'message' => $message,
        'data' => $_POST
    ));
    return true;
}

if ($_POST['captcha']) {
    return send(true, 'You seem to be a robot. If this is an error, turn off autocomplete.');
}
if (strlen($_POST['name']) < 5) {
    return send(true, 'Name not completely filled out.');
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    return send(true, 'You provided an invalid Email.');
}
if (strlen($_POST['message']) < 10) {
    return send(true, 'You should write something in the message.');
}

return send(false, 'Email sent successfully! We will respond soon!');
