<?php
  require '../survey_session.php';
  require '../lib/html_helper.php';

  $survey = SurveySession::resume();
  if (is_null($survey)) {
    header("Location: /index.php");
  }

  // Store the previous answer on the session
  $previousIndex = intval($_POST['index'] ?? 0);
  $survey->setAnswer($previousIndex, $_POST['answer']);

  // Find the current question.
  $questionIndex = $previousIndex + intval($_POST['direction']);
  $question = $survey->questions[$questionIndex];

  // If we're passing the last question, proceed to the review page.
  if ($questionIndex >= $survey->questionCount()) {
    header("Location: /review.php");
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
    <p><?=var_dump($_POST)?></p>
  </header>
  <main>
    <h2>Question <?=($questionIndex + 1)?> of <?=$survey->questionCount()?></h2>
    <form method="post">
      <input type="hidden" name="index" value="<?=$questionIndex?>">
      <fieldset>
        <?php
          echo text_to_paragraphs($question->text)
        ?>
        <!-- TODO: Insert the input fragment here. -->
      </fieldset>
      <nav class="button-row">
        <button type="submit" name="direction" value="1">Next</button>
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