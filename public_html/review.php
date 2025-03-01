<?php
require '../survey_session.php';
require '../lib/html_helper.php';

$survey = SurveySession::resume();
if (is_null($survey)) {
  header("Location: /index.php");
}
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
    <h2>Thank you! Your answers are below:</h2>
    <?php for($i = 0; $i < $survey->questionCount(); $i++) { ?>
      <section>
        <h3>Question <?=($i + 1)?></h3>
        <p class="question"><?=$survey->questions[$i]->text?></p>
        <p class="answer"><?=$survey->answers[$i]?></p>
      </section>
    <?php } /* end for $i */ ?>
  </main>
  <footer>
    <p>
      Made by <a href="https://github.com/mckathlin">McKathlin</a>
    </p>
  </footer>
</body>
</html>