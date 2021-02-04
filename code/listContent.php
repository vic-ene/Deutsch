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
    
    <h1>List Content</h1>

    <script>
        function reply_click(clicked_id){ 
           document.getElementById('card_id').value = document.getElementById(clicked_id).id;
        }
        
    </script>



    <form action="listContent.php" action = "get"> 
        <div class="input-group add-card">
            <div class="input-group-prepend">
                <button class="input-group-text">Add Card</button>
            </div>
            <input type="text" class="form-control"  name = "word" placeholder = "german word">
            <input type="text" class="form-control"  name = "translation" placeholder = "french translation">
        </div>
    </form>
    

    <form action="lists.php" method = "post">
        <div class = delete_list style="position: absolute; top: 0; right: 0; width: 100px; text-align:right;">
            <button  onclick="return confirm('Do you really want to delete the list ? ');" name = "delete_list">Delete</button>
        </div>
    </form>

    <form action="cardContent.php" method="get">
    <div class="cards-display">

    <input type="hidden" name = "card_id" id = "card_id">

    <?php   
      require '../config/db.php';
      require 'global/sidemenu.php';


      if(isset($_POST['delete_card'])){
        $delete_card_query = "DELETE FROM cards WHERE cards.id = ? AND cards.list_id = ? AND cards.user_id = ?";
        $stmt = $conn->prepare($delete_card_query);
        $stmt->bind_param('iii', $_SESSION['card_id'],  $_SESSION['list_id'], $_SESSION['id']);
        $stmt->execute();
        $stmt->close();
    }


    if(isset($_GET['list_id']) && isset($_GET['list_name'])){
        $_SESSION['list_id'] = $_GET['list_id'];
        $_SESSION['list_name'] = $_GET['list_name'];
    }
    if(isset($_GET['word']) && isset($_GET['translation'])){
        $word = $_GET['word'];
        $translation = $_GET['translation'];
        $add_card_query = "INSERT INTO cards(word, translation, user_id, list_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($add_card_query);
        $stmt->bind_param('ssii', $word, $translation, $_SESSION['id'], $_SESSION['list_id']);
        $stmt->execute();
        $stmt->close();  
    }


    $list_query = "SELECT * FROM cards WHERE cards.list_id = ? AND cards.user_id = ?";
    $stmt = $conn->prepare($list_query);
    $stmt->bind_param('ii', $_SESSION['list_id'], $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        $val = "<p>" .  $row['word'] . "</p><p>" .$row['translation'] . "</p>";
        $id = $row['id'];
        $data = "<button  id = ". $id . " onClick = 'reply_click(this.id)' > " .$val. " </button> "; 
        echo $data;
    }
    $stmt->close();  
    ?>
    

    </div>
    </form>
</body>
</html>