<?php
  include '../lib/html_helper.php';

  // Extract the survey
  const SURVEY_PATH = "../surveys/favorites.json";
  $survey = json_decode(file_get_contents(SURVEY_PATH));
  $title = htmlentities($survey->title);
  $introParagraphs = text_to_paragraphs($survey->intro);

  // Start the session
  session_start();
  $_SESSION['title'] = $title;
  $_SESSION['questions'] = $survey->questions;
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
    <?=$introParagraphs?>
    <nav class="button-row">
      <form action="./survey.php" method="post">
        <button type="submit" name="qNum" value="1">Start the Survey</button>
      </form>
    </nav>
  </main>
  <footer>
    <p>
      Made by <a href="https://github.com/mckathlin">McKathlin</a>
    </p>
  </footer>
</body>
</html>