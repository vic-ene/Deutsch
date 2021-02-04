<?php

session_start();

require 'config/db.php';
require_once 'emailController.php';

$errors = array();
$username = "";
$email = "";

if(isset($_POST['signup-btn'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];


    if(empty($username)){
        $errors['username'] = "Username required";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Email address is invalid";
    }
    if(empty($email)){
        $errors['email'] = "Email required";
    }
    if(empty($password)){
        $errors['password'] = "Password required";
    }
    if($password !== $passwordConf){
        $errors['password'] = "The two passwords do not match";
    }

    $emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $conn->prepare($emailQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    $stmt->close();

    if($userCount > 0){
        $errors['email'] = "Email already exists";
    }

    if(count($errors) === 0){
        $password = password_hash($password, PASSWORD_DEFAULT);

        $token = bin2hex(random_bytes(50));
        $verified = false;
        $is_admin = 0;

        $sql = "INSERT INTO users (username, email, verified, token, password, is_admin)
        VALUES (?, ?, ?, ?, ?, ?)";
         $stmt = $conn->prepare($sql);
         $stmt->bind_param('ssissi', $username, $email, $verified, $token, $password, $is_admin);
         
         if($stmt->execute()){
             // login user
            $user_id = $conn->insert_id;
            $_SESSION['id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['verified'] = $verified;
            $_SESSION['is_admin'] = $is_admin;
            sendVerificationEmail($email, $token);

            header('location: home.php');
            exit();
         }else{
             $errors['db_error'] = "Database error: failed to register";
         }

    }

}


if(isset($_POST['login-btn'])){
    $username = $_POST['username'];   
    $password = $_POST['password'];
   

    if(empty($username)){
        $errors['username'] = "Username required";
    }
    if(empty($password)){
        $errors['password'] = "Password required";
    }

    if(count($errors) === 0 ){
        $sql = "SELECT * FROM users WHERE email = ? OR username = ?  LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    
        if(password_verify($password, $user['password'])){
                
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['verified'] = $user['verified'];
                $_SESSION['is_admin'] = $user['is_admin'];
                
                header('location: home.php');
                exit();
    
        }else{
            $errors['login_fail'] = "Wrong credentials";
        }
    }
} 


if(isset($_GET['logout'])){

    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['verified']);
    unset($_SESSION['is_admin']);
    unset($_SESSION['list_id']);
    unset($_SESSION['card_id']);
    header('location: login.php');
    exit();
}


function verifyUser($token){

    global $conn; 
    $sql = "SELECT * FROM users WHERE token = '$token' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $update_query = "UPDATE users SET verified = 1 WHERE token = '$token'";

        if(mysqli_query($conn, $update_query)){
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['verified'] = 1;
            $_SESSION['is_admin'] = $user['is_admin'];

            header('location: home.php');
            exit();

        }
    }
    else{
        echo 'User not found';
    }
}



