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

    <title>Login</title>
</head>
<body class = "background deutsch_flag">

    <div class="container">
        <div class="row">
            <div class ="col-md-6 offset-md-6 form-div login">
                <form action="login.php" method="post">
                    <br><br><br>
                    <h3 class = "text-center" style = "color:white">Login</h3>

                    <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <?php foreach($errors as $error): ?>
                                <li><?php echo $error ?></li>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="username">Username or Email</label>
                        <input type="text" name = "username" value = "<?php echo $username; ?>" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name = "password" class="form-control form-control-lg">
                    </div>


                    <div class="form-group">
                        <button type="submit" name ="login-btn" class ="btn btn-primary btn-block btn-lg">Login</button>
                    </div>

                    <a href="signup.php" class = "btn btn-info btn-block">Sign Up</a>
                   
                   
                     
                    </div>

                </form>
            </div>
        </div>
    </div>

    
</body>
</html>