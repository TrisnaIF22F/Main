<?php

session_start();

require './../config/db.php';

if(isset($_POST['submit'])) {

    global $db_connect;

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if($confirm != $password) {
        echo "password tidak sesuai dengan konfirmasi password";
        die;
    }

    $usedEmail = mysqli_query($db_connect,"SELECT email FROM users WHERE email = '$email'");
    if(mysqli_num_rows($usedEmail) > 0) {
        echo "email sudah digunakan";
        die;
    }

    $password = password_hash($password,PASSWORD_DEFAULT);
    $created_at = date('Y-m-d H:i:s',time());
        
    $users = mysqli_query($db_connect,"INSERT INTO users (name,email, password,created_at) VALUES
                            ('$name','$email','$password','$created_at')");

    $getUserdata = mysqli_query($db_connect,"SELECT name, role FROM users WHERE email = '$email'");

    $sesionData = mysqli_fetch_assoc($getUserdata);

    $_SESSION['name'] = $sesionData['name'];
    $_SESSION['role'] = $sesionData['role'];
        
    header('Location:./../profile.php');
//     $_SESSION['name'] = $name;
//     $_SESSION['role'] = $role;
//     echo "registrasi berhasil";
}
