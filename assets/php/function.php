<?php


$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        "name" => test_input($_POST["name"]),
        "firstname" => test_input($_POST["firstname"]),
        "email" => test_input($_POST["email"]),
        "phone" => test_input($_POST["phone"]),
        "subject" => test_input($_POST["subject"]),
        "message" => test_input($_POST["message"]),
        "newsletter" => isset($_POST["newsletter"]) ? test_input($_POST["newsletter"]) : ""
    ];

    $errors = validate_form_data($data);

    if (empty($errors)) {
        $success = true;
        $data = []; // Clear the data array to clear the form fields
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function validate_form_data($data) {
    $errors = [];

    if (empty($data["name"])) {
        $errors["name"] = "Le nom est requis.";
    }

    if (empty($data["firstname"])) {
        $errors["firstname"] = "Le prénom est requis.";
    }

    if (empty($data["email"])) {
        $errors["email"] = "L'email est requis.";
    } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "L'email est invalide.";
    }

    if (empty($data["message"])) {
        $errors["message"] = "Le message est requis.";
    }

    return $errors;
}