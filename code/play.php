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

    <title>Play</title>
</head>
<body class = "play">
    <h1>Learning</h1>
    
   
    <?php   
     require '../config/db.php';
     require 'global/sidemenu.php';


      // We select the first list if no lists where selected
      if(!isset($_SESSION['list_id'])){
          $first_list_query = "SELECT id FROM lists WHERE lists.user_id = ?";
          $stmt = $conn->prepare($first_list_query);
          $stmt->bind_param('i', $_SESSION['id']);
          $stmt->execute();
          $result = $stmt->get_result();

          $id_column = array();
          while($row = $result->fetch_assoc()){
              array_push($id_column, $row['id']);
          }
          $_SESSION['list_id'] = $id_column[0];
          $stmt->close();
      }


     // Selects the cards  and saves them in SESSION (Only the first time (when we come from homepage to this page)
     if(!isset($_GET['play'])){
        $get_cards = "SELECT * FROM cards WHERE cards.list_id = ? AND cards.user_id = ?";
        $stmt = $conn->prepare($get_cards);
        $stmt->bind_param('ii', $_SESSION['list_id'], $_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $words = array();
        $translations = array();
        while($row = $result->fetch_assoc()){
            array_push($words, $row['word']);
            array_push($translations, $row['translation']);
        }
        $stmt->close(); 
        $game_words = $words;
        $game_translations = $translations;
        $_SESSION['words'] = $words;
        $_SESSION['translations'] = $translations;
        $_SESSION['game_words'] = $game_words;
        $_SESSION['game_translations'] = $game_translations;
     }
     
     $min_size = 4;
     
     // If the list contains less than 4 cards we do not do anything
    if(count($_SESSION['words']) < $min_size){
        echo "<br><br><br><br><br><br><br>";
        echo "<h1>Please add words into the list</h1>";
    }
    // Otherwise the game launches 
    else{

        if(isset($_GET['play'])){
          $index = $_GET['index'];
          \array_splice($_SESSION['game_words'], $index, 1);
          \array_splice($_SESSION['game_translations'], $index, 1);
        }

        if(count($_SESSION['game_words']) == 0) header("Location:lists.php");
        $index = mt_rand(0,count($_SESSION['game_words']) - 1);
        $current_word = $_SESSION['game_words'][$index];
        $current_translation = $_SESSION['game_translations'][$index];

        $other_indexes = UniqueRandomNumbersWithinRange(0, count($_SESSION['words']) - 1, $min_size - 1);
        $other_words = array(
            $_SESSION['words'][$other_indexes[0]],
            $_SESSION['words'][$other_indexes[1]],
            $_SESSION['words'][$other_indexes[2]]
        );
        $other_translations = array(
            $_SESSION['translations'][$other_indexes[0]],
            $_SESSION['translations'][$other_indexes[1]],
            $_SESSION['translations'][$other_indexes[2]]
        );  
        
        while($current_word == $other_words[0] || $current_word == $other_words[1] || $current_word == $other_words[2]){
            $other_indexes = UniqueRandomNumbersWithinRange(0, count($_SESSION['words']) - 1, $min_size - 1);
            $other_words = array(
                $_SESSION['words'][$other_indexes[0]],
                $_SESSION['words'][$other_indexes[1]],
                $_SESSION['words'][$other_indexes[2]]
            );
            $other_translations = array(
                $_SESSION['translations'][$other_indexes[0]],
                $_SESSION['translations'][$other_indexes[1]],
                $_SESSION['translations'][$other_indexes[2]]
            );    
        }

        array_push($other_words, $current_word);
        array_push($other_translations, $current_translation);

        $count = count($other_words);
        $order = range(1, $count);

        shuffle($order);
        array_multisort($order, $other_words, $other_translations);

        echo "<p class = 'play' ><i>Traduit : &nbsp <b>$current_translation </b></i></p>";
            
        echo "<form action='play.php' method = 'get' id = 'card-container'>
                <div class = 'card-container'>
                    <button   class='btn btn-my btn1' onclick = 'checkAnswer()' value = \"{$other_translations[0]}\">$other_words[0]</button>
                    <button   class='btn btn-my btn2' onclick = 'checkAnswer()' value = \"{$other_translations[1]}\">$other_words[1]</button>
                    <button   class='btn btn-my btn3' onclick = 'checkAnswer()' value = \"{$other_translations[2]}\">$other_words[2]</button>
                    <button   class='btn btn-my btn4' onclick = 'checkAnswer()' value = \"{$other_translations[3]}\">$other_words[3]</button>
                </div>
                <div class = 'answer-container'>
                    <button type = 'button'  id = 'btn-answer' onclick = 'showAnswers()'>See Answers</button>
                    <input type = 'hidden' id = 'current_word' value = \"{$current_word}\">
                    <input type = 'hidden' id = 'current_translation' value =  \"{$current_translation}\">
                    <input type = 'hidden' name = 'index' value = \"{$index}\">
                    <input type = 'hidden' name = 'play' value = 'play'>
                </div>
             </form>";         
    }



    function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }
    
    ?>
    
</body>

</html>


<script >
        function checkAnswer(){
           var form = document.getElementById('card-container');
           if(event.target.value != document.getElementById('current_translation').value){
              event.target.setAttribute('type', 'button');
           }
        }

        function showAnswers(){
            var answerBtn = document.getElementById('btn-answer');
            var button1 = document.getElementById('current_word');
            var button2 = document.getElementById('current_translation');
            answerBtn.innerText = answerBtn.innerText == "See Answers" ? "Hide Answers" : "See Answers";
            button1.type = button1.type == "hidden" ? 'button' : 'hidden'; 
            button2.type = button2.type == "hidden" ? 'button' : 'hidden'; 
        }
    </script>
