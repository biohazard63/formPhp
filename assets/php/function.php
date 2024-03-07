<?php

// Initialize success variable to false
$success = false;

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare the data array with sanitized input
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

    // Validate the form data
    $errors = validate_form_data($data);

    // Check if a file is uploaded
    if (isset($_FILES['file'])) {
        // Define allowed file extensions and maximum file size
        $allowedExtensions = ['doc', 'docx', 'pdf', 'txt', 'jpg', 'png'];
        $maxFileSize = 2 * 1024 * 1024;

        // Get the file extension
        $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        // Validate the file extension
        if (!in_array($fileExtension, $allowedExtensions)) {
            $errors['file'] = "Type de fichier invalide. Seuls les fichiers .doc, .docx, .pdf, .txt, .jpg et .png sont autorisés.";
        }

        // Validate the file size
        if ($_FILES['file']['size'] > $maxFileSize) {
            $errors['file'] = "Le fichier est trop grand. La taille maximale est de 2 Mo.";
        }

        // If there are no file errors, proceed with the file upload
        if (!isset($errors['file'])) {
            // Define the upload directory and file path
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($_FILES['file']['name']);

            // Create the upload directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Move the uploaded file to the upload directory
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
                echo "File is valid, and was successfully uploaded.\n";
                // Add the file information to the data array
                $data['file_name'] = $_FILES['file']['name'];
                $data['file_size'] = $_FILES['file']['size'];
                $data['file_path'] = $uploadFile;
            } else {
                echo "Possible file upload attack!\n";
            }
        }
    }

    // If there are no errors, proceed with storing the data
    if (empty($errors)) {
        $success = true;

        // Define the JSON file path
        $file = 'data.json';

        // Create the JSON file if it doesn't exist
        if (!file_exists($file)) {
            file_put_contents($file, json_encode([]));
        }

        // Read the JSON file contents
        $fileContents = file_get_contents($file);
        $fileData = json_decode($fileContents, true);

        // Add the data to the file data array
        $fileData[] = $data;

        // Write the updated data back to the JSON file
        file_put_contents($file, json_encode($fileData));

        // Define the CSV file path
        $csvFile = 'data.csv';

        // Open the CSV file for appending
        $handle = fopen($csvFile, 'a');

        // Add the current date to the data array
        $data['date'] = date('Y-m-d H:i:s');

        // Write the data to the CSV file
        fputcsv($handle, $data);

        // Close the CSV file
        fclose($handle);

        // Reset the data array
        $data = [];
    }
}

/**
 * Sanitize the input data
 *
 * @param string $data The input data
 * @return string The sanitized data
 */
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Validate the form data
 *
 * @param array $data The form data
 * @return array The validation errors
 */
function validate_form_data($data) {
    $errors = [];

    // Validate the name
    if (empty($data["name"])) {
        $errors["name"] = "Le nom est requis.";
    } elseif (strlen($data["name"]) < 2) {
        $errors["name"] = "Le nom doit contenir au moins 2 caractères.";
    }

    // Validate the firstname
    if (empty($data["firstname"])) {
        $errors["firstname"] = "Le prénom est requis.";
    } elseif (strlen($data["firstname"]) < 2) {
        $errors["firstname"] = "Le prénom doit contenir au moins 2 caractères.";
    }

    // Validate the email
    if (empty($data["email"])) {
        $errors["email"] = "L'email est requis.";
    } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "L'email est invalide.";
    } elseif (!preg_match("/\.(com|fr)$/", $data["email"])) {
        $errors["email"] = "L'email doit se terminer par .com ou .fr.";
    }

    // Validate the phone number
    if (!empty($data["phone"]) && !preg_match("/^[0-9]{10}$/", $data["phone"])) {
        $errors["phone"] = "Le numéro de téléphone est invalide.";
    }

    // Validate the message
    if (empty($data["message"])) {
        $errors["message"] = "Le message est requis.";
    } elseif (strlen($data["message"]) < 10) {
        $errors["message"] = "Le message doit contenir au moins 10 caractères.";
    }

    return $errors;
}