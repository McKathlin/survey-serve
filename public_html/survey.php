<?php
  include '../lib/html_helper.php';

  session_start();
  if (!isset($_SESSION['questions'])) {
    header("Location: /index.php");
  }

  // Find the current question
  $questionNumber = $_POST['qNum'] ?? 1;
  $questionCount = count($_SESSION['questions']);
  $question = $_SESSION['questions'][$questionNumber - 1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$title?></title>
</head>
<body>
  <header>
    <h1><?=$title?></h1>
  </header>
  <main>
    <h2>Question <?=$questionNumber?> of <?=$questionCount?></h2>
    <form method="post">
      <!-- TODO: The question goes here. -->
       <p><?=var_dump($question)?></p>
      <nav class="button-row">
        <button type="submit" name="qNum" value="<?=($questionNumber + 1)?>">Next</button>
      </nav>
    </form>
  </main>
  <footer>
    <p>
      Made by <a href="https://github.com/mckathlin">McKathlin</a>
    </p>
  </footer>
</body>
</html>