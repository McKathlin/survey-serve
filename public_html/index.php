<?php
require '../survey_session.php';
require '../lib/html_helper.php';

const SURVEY_PATH = "../surveys/favorites.json";
$survey = SurveySession::startFromFile(SURVEY_PATH);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$survey->title?></title>
</head>
<body>
  <header>
    <h1><?=$survey->title?></h1>
  </header>
  <main>
    <?=text_to_paragraphs($survey->intro)?>
    <nav class="button-row">
      <form action="./survey.php" method="post">
        <input type="hidden" name="index" value=0>
        <button type="submit" name="direction" value=0>Start the Survey</button>
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