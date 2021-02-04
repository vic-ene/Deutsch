<?php require '../controllers/checkSession.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"> 
     <!-- Our css file  -->
     <link href="../css/mystyle.css" rel="stylesheet" >

    <title>Lists</title>
</head>
<body>
    
    <h1>Your card</h1>

    <form action="listContent.php" method = "post">
        <div class = delete_card style="position: absolute; top: 0; right: 0; width: 100px; text-align:right;">
            <button name = "delete_card">Delete</button>
        </div>
    </form>

   
    <?php 
        require '../config/db.php';
        require 'global/sidemenu.php';
        
        if(isset($_GET['update'])){
            $word = $_GET['word'];
            $translation = $_GET['translation'];
            $update_card_query = "UPDATE cards SET cards.word = ?, cards.translation = ?
                            WHERE (cards.list_id = ?  AND cards.user_id = ? AND cards.id = ?)";
            $stmt = $conn->prepare($update_card_query);
            $stmt->bind_param('ssiii', $word, $translation, $_SESSION['list_id'], $_SESSION['id'], $_SESSION['card_id']);
            $stmt->execute();
            $stmt->close();
        }
        
        if(!empty($_GET['card_id'])){
            $_SESSION['card_id'] = $_GET['card_id'];
        }
       
       
        $word = "";
        $translation = "";
        $list_query = "SELECT * FROM cards WHERE cards.list_id = ? AND cards.user_id = ? AND cards.id = ?";

        $stmt = $conn->prepare($list_query);
        $stmt->bind_param('iii', $_SESSION['list_id'], $_SESSION['id'], $_SESSION['card_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()){
            $word = $row['word'];
            $translation = $row['translation'];
        }
      
        
        $stmt->close();  

    ?>

    <form action="cardContent.php" method = "get" >
        <div class="card-content">
            <input type="text" name = "word" id = "word"  value = '<?php echo $word; ?>' >
            <input type="text" name = "translation" id = "translation" value= '<?php echo $translation; ?>'>
            <button  name = "update"  value = "update" >Update</button>
        </div>
    </form>

    <form action="listContent.php" action = "get">
        <div class="card-content">
            <button  name = "back"  value = "back" >Back to List</button>
        </div>
    </form>
   


  

</body>
</html>



 