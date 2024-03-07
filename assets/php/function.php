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

        // Path to the JSON file
        $file = 'data.json';

        // Check if the file exists
        if (!file_exists($file)) {
            // If the file doesn't exist, create a new one with an empty array
            file_put_contents($file, json_encode([]));
        }

        // Read the file contents and decode the JSON data into a PHP array
        $fileContents = file_get_contents($file);
        $fileData = json_decode($fileContents, true);

        // Append the new form data to the array
        $fileData[] = $data;

        // Encode the updated array back into JSON and write it to the file
        file_put_contents($file, json_encode($fileData));
        $data = [];

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
    } elseif (strlen($data["name"]) < 2) {
        $errors["name"] = "Le nom doit contenir au moins 2 caractères.";
    }

    if (empty($data["firstname"])) {
        $errors["firstname"] = "Le prénom est requis.";
    } elseif (strlen($data["firstname"]) < 2) {
        $errors["firstname"] = "Le prénom doit contenir au moins 2 caractères.";
    }

    if (empty($data["email"])) {
        $errors["email"] = "L'email est requis.";
    } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "L'email est invalide.";
    } elseif (!preg_match("/\.(com|fr)$/", $data["email"])) {
        $errors["email"] = "L'email doit se terminer par .com ou .fr.";
    }

    if (!empty($data["phone"]) && !preg_match("/^[0-9]{10}$/", $data["phone"])) {
        $errors["phone"] = "Le numéro de téléphone est invalide.";
    }

    if (empty($data["message"])) {
        $errors["message"] = "Le message est requis.";
    } elseif (strlen($data["message"]) < 10) {
        $errors["message"] = "Le message doit contenir au moins 10 caractères.";
    }

    return $errors;
}