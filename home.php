
<?php 
require_once 'controllers/authController.php'; 

// verify the token
if(isset($_GET['token'])){
    $token = $_GET['token'];
    verifyUser($token);
}

if(!isset($_SESSION['id'])){
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
     <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"> 
     <!-- Our css file  -->
     <link href="css/mystyle.css" rel="stylesheet" >
    
    <title>Homepage</title>


</head>
<body class = "home">

    <h1><em><b>Super Deutsch Arbeiter</b></em></h1>   

           

            <div>
                <br>
                <?php if(!$_SESSION['verified']): ?>
                    <div class="alert alert-warning">
                        <center>
                            Please verify your email address
                        </center>
                    </div>
                <?php endif; ?>
            </div>

            <div class="home-big-container">

            <?php if($_SESSION['verified']): ?>
                <?php require 'code/global/sidemenu.php'?>
            <?php endif; ?>
           

            <?php if($_SESSION['verified']): ?>
            <div class="home-container">
               <a href="<?php echo ROOT_PATH . 'code/lists.php';?>" class = "home-button lists">Lists</a>
               <a href="<?php echo ROOT_PATH . 'code/play.php';?>" class = "home-button play">Play</a>
               <a href="<?php echo ROOT_PATH . 'code/others.php';?>" class = "home-button others">Others</a>
            <?php endif; ?>


            </div>

            

           
            
            
           

        
   
    
</body>
</html>