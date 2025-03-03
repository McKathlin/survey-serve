<?php
require '../survey_session.php';
require '../lib/html_helper.php';

if (!isset($_GET['survey'])) {
  header("Location: /index.php");
  exit();
}

$handle = $_GET['survey'];
$surveyPath = "../surveys/$handle.json";
$survey = SurveySession::startFromFile($surveyPath);
if (!$survey) {
  http_response_code(404);
  // TODO: show 404 Not Found page
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="survey.css">
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
        <button type="submit" name="direction" value=0 class="next-button">Start the Survey</button>
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