<?php require_once 'controllers/authController.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <!-- Our css file -->
    <link href="css/mystyle.css" rel="stylesheet" >

    <title>Register</title>
</head>
<body class = "background french_flag">

    <div class="container">
        <div class="row">
            <div class ="col-md-6 offset-md-6 form-div">
                <form action="signup.php" method="post">
                    <h3 class = "text-center">Register</h3>

                    <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <?php foreach($errors as $error): ?>
                                <li><?php echo $error ?></li>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name = "username" value = "<?php echo $username; ?>"class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name = "email" value = "<?php echo $email; ?>"class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name = "password" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="passwordConf">Confirm Password</label>
                        <input type="password" name = "passwordConf" class="form-control form-control-lg">
                    </div>

                    <div class="form-group">
                        <button type="submit" name ="signup-btn" class ="btn btn-primary btn-block btn-lg">Sign Up</button>
                    </div>
                    <a href="login.php" class = "btn btn-info btn-block">Sign In</a>


                </form>
            </div>
        </div>
    </div>
    
   
    
    
</body>
</html>