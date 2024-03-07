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
        "file" => isset($_FILES["file"]) ? $_FILES["file"] : "",
        "newsletter" => isset($_POST["newsletter"]) ? test_input($_POST["newsletter"]) : ""
    ];

    $errors = validate_form_data($data);

   if (isset($_FILES['file'])) {
    $allowedExtensions = ['doc', 'docx', 'pdf', 'txt', 'jpg', 'png'];

    $maxFileSize = 2 * 1024 * 1024;

    $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    if (!in_array($fileExtension, $allowedExtensions)) {
        $errors['file'] = "Invalid file type. Only .doc, .docx, .pdf, .txt, .jpg and .png files are allowed.";
    }

    if ($_FILES['file']['size'] > $maxFileSize) {
        $errors['file'] = "File is too large. Maximum size is 2MB.";
    }

    if (!isset($errors['file'])) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            echo "File is valid, and was successfully uploaded.\n";
            // Add the file information to the data array
            $data['file_name'] = $_FILES['file']['name'];
            $data['file_size'] = $_FILES['file']['size'];
            $data['file_path'] = $uploadFile; // Add this line
        } else {
            echo "Possible file upload attack!\n";
        }
    }
}

    if (empty($errors)) {
        $success = true;

        $file = 'data.json';

        if (!file_exists($file)) {
            file_put_contents($file, json_encode([]));
        }

        $fileContents = file_get_contents($file);
        $fileData = json_decode($fileContents, true);

        $fileData[] = $data;

        file_put_contents($file, json_encode($fileData));

        $csvFile = 'data.csv';

        $handle = fopen($csvFile, 'a');

        $data['date'] = date('Y-m-d H:i:s');

        fputcsv($handle, $data);

        fclose($handle);

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