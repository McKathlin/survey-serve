<?php
require '../SurveyApp.php';
require '../lib/html_helper.php';

$survey = SurveyApp::finishSession();
if (is_null($survey)) {
  header("Location: /index.html");
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
    <h2>Thank you! Your answers have been recorded.</h2>
    <?php for($i = 0; $i < $survey->questionCount(); $i++) { ?>
      <section class="review-question">
        <div class="question"><p>Question <?=($i + 1)?>: <?=$survey->questions[$i]->text?></p></div>
        <div class="answer"><?=$survey->getAnswerHtml($i, 'p')?></div>
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