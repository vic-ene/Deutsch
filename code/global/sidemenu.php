


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <title>Drop</title>
</head>
<style>
*{
    margin: 0;
    padding: 0;
}
div.wrapper{
    position: absolute;
    left: 0px;
    top: 0px;
    z-index: 1;
    
}
.wrapper{
    width: 860px; 
    margin: 0 auto;
}
.wrapper ul{
    list-style: none;
}
.wrapper ul li {
    position: relative;
    background: skyblue;
    width: 170px;
    height: 50px;
    line-height: 50px;
    text-align: center;
    float: left;
    color: black;
    font-size: 20px;   
}
.wrapper ul li.title{
    height: 70px;
    line-height: 70px;
    background: paleturquoise;
    border: 3px solid black;
}
.wrapper ul li:hover{
    background: slateblue; 
    color: aliceblue;
}
.wrapper ul ul{
    display: none;
    position: relative;
    left: -3px;
    top: -3px;
}
.wrapper ul li:hover > ul{
    display: block; 
}
.wrapper ul ul ul{
    margin-left: 170px;
    position: absolute;
    top: 0px;
    left: 1px;
}
a.link{
    text-decoration: none;
    color: black;
    display: block;
}
i{
    text-decoration: none;
    color: black;
    display: block;
}

</style>
<body>

    <div class="wrapper">
        <ul>
            <li class = "title">Menu
                <ul>
                    <li><a href="<?php echo ROOT_PATH . 'home.php';?>" class="link"><i class="fas fa-home">Home</i></a></li>
                    <li><a href="<?php echo ROOT_PATH . 'code/lists.php';?>" class="link"><i class="fas fa-pen">Lists</i></a></li>
                    <li><a href="<?php echo ROOT_PATH . 'code/play.php';?>" class="link"><i class="fas fa-book-open">Play</i></a></li>
                    <li><a href="<?php echo ROOT_PATH . 'code/others.php';?>" class="link"><i class="fas fa-users">Others</i></a></li>
                    <li><a href="<?php echo ROOT_PATH . 'home.php?logout=1';?>" class="link"><i class="fas fa-sign-out-alt">Logout</i></a></li>
                </ul>
            </li>
        </ul>
        
    </div>
    
    
</body>
</html>