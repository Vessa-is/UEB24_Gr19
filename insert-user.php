<?php
require_once '../UEB24_Gr19/script/classes/UserRepository.php';
require_once '../UEB24_Gr19/script/classes/User.php';

if (isset($_POST['submitbutton'])) {
    $firstname = $_POST['first-name'] ?? '';
    $lastname = $_POST['last-name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $personalnr = $_POST['nr-personal'] ?? '';

    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($personalnr)) {
        echo "Ju lutem plotësoni të gjitha fushat!";
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email i pavlefshëm!";
        return;
    }

    if (strlen($password) < 6) {
        echo "Fjalëkalimi duhet të ketë të paktën 6 karaktere!";
        return;
    }

    try {
        $userRepository = new UserRepository();

        if ($userRepository->userExistsByEmail($email)) {
            echo "Ky email është përdorur tashmë!";
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = new User($firstname, $lastname, $email, $hashedPassword, $personalnr);

        $success = $userRepository->insertUser($user);

        if ($success) {
            header("Location: login.php?registered=1");
            exit();
        } else {
            echo "Gabim gjatë regjistrimit. Ju lutemi kontaktoni administratorin.";
        }
    } catch (Exception $e) {
        error_log("Gabim gjatë regjistrimit: " . $e->getMessage(), 3, "error.log");
        echo "Ndodhi një gabim i papritur. Ju lutemi kontaktoni administratorin.";
    }
}
?>

