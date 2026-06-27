<?php

session_start();


include("config/connect.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);
    $created_at = date('Y-m-d H:i:s');
    
    
    $sql = "INSERT INTO messages (name, email, subject, message, created_at) 
            VALUES ('$name', '$email', '$subject', '$message', '$created_at')";
    

    if ($conn->query($sql) === TRUE) {

        $_SESSION['message'] = "Thank you for your message. We will get back to you soon!@Eartgalla😊";
        $_SESSION['message_type'] = "success";
    } else {

        $_SESSION['message'] = "Error: " . $sql . "<br>" . $conn->error;
        $_SESSION['message_type'] = "error";
    }
    
    $conn->close();
    

    header("Location: contact.php");
    exit();
}
?>
