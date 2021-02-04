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
    
    <h1>Your Lists</h1>

    <form action="lists.php" method = "post">
        <div class="list-create">
            <input type="text" name = "new_list_name"  id = "new_list_name" placeholder = "create a new list">
            <button >Create</button>
        </div>
    </form>

    <script type = "text/javascript">
        function saveInfo(){
            document.getElementById('list_name').value =  event.target.value;
            document.getElementById('list_id').value =  event.target.getAttribute('data-value');
        }
    </script>



   
    <form action="listContent.php" method = "get">
    <div class="lists-display">

   

        <?php   

      
        
        require '../config/db.php';
        require 'global/sidemenu.php';

        if(isset($_POST['delete_list'])){
            $delete_list_query = "DELETE FROM lists WHERE lists.id = ? AND lists.user_id = ?";
            $stmt = $conn->prepare($delete_list_query);
            $stmt->bind_param('ii',$_SESSION['list_id'], $_SESSION['id']);
            $stmt->execute();
            $stmt->close();

            $delete_cards_query = "DELETE FROM cards WHERE cards.list_id = ? AND cards.user_id = ?";
            $stmt2 = $conn->prepare($delete_cards_query);
            $stmt2->bind_param('ii',$_SESSION['list_id'], $_SESSION['id']);
            $stmt2->execute();
            $stmt2->close();  
            
            unset($_SESSION['list_id']);
        }

        if(!empty($_POST['new_list_name'])){
            $new_list_name = $_POST['new_list_name'];
            $create_list_query = "INSERT INTO lists(name, user_id) VALUES (?, ?)";
            $stmt = $conn->prepare($create_list_query);
            $stmt->bind_param('si',$new_list_name, $_SESSION['id']);
            $stmt->execute();
            $stmt->close();
        }
        
        $list_query = "SELECT * FROM lists WHERE lists.user_id=?";
        $stmt = $conn->prepare($list_query);
        $stmt->bind_param('i', $_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()){
            $data = "<input onclick = 'saveInfo()' type = 'submit'  data-value = " .$row['id']. " value = " . $row['name'] .  "></input>";
            echo $data;
        }
        $stmt->close();
        ?>
        <input type="hidden" name = "list_name" id = "list_name" value = "">
        <input type="hidden" name = "list_id" id = "list_id" value = "">
    </div>
    </form>

   
</body>
</html>