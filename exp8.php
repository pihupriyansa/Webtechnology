<!DOCTYPE html>
<html>
<head>
    <title>Styled Form</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f2f2f2;
        }
        .container {
            width: 350px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px gray;
        }
        input {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>

<div class="container">
<h2>Registration Form</h2>

<?php

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $phone = trim($_POST["phone"]);

    if ($name == "" || $email == "" || $password == "" || $phone == "") {
        $message = "<p class='error'>All fields are required!</p>";
    }
    elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $message = "<p class='error'>Name must contain only letters!</p>";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<p class='error'>Invalid email format!</p>";
    }
    elseif (strlen($password) < 6) {
        $message = "<p class='error'>Password must be at least 6 characters!</p>";
    }
    elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $message = "<p class='error'>Phone must be 10 digits!</p>";
    }
    else {
        $message = "<p class='success'>Form submitted successfully!</p>";
        $message .= "Name: " . $name . "<br>";
        $message .= "Email: " . $email . "<br>";
        $message .= "Phone: " . $phone;
    }
}

echo $message;

?>

<form method="post">
    Name:
    <input type="text" name="name">

    Email:
    <input type="text" name="email">

    Password:
    <input type="password" name="password">

    Phone:
    <input type="text" name="phone">

    <input type="submit" value="Submit" class="btn">
</form>

</div>

</body>
</html>