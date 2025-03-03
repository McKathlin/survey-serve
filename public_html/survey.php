<?php
require '../survey_session.php';
require '../lib/html_helper.php';

$survey = SurveySession::resume();
if (is_null($survey)) {
  header("Location: /index.php");
  exit();
}

// Store the previous answer on the session
$previousIndex = intval($_POST['index'] ?? 0);
if (isset($_POST['answer'])) {
  $survey->setAnswer($previousIndex, $_POST['answer']);
}

// Get the current question,
// or if we're past the last question, proceed to review.
$questionIndex = $previousIndex + intval($_POST['direction']);
if ($questionIndex >= $survey->questionCount()) {
  header("Location: /survey-review.php");
  exit();
}
$question = $survey->questions[$questionIndex];
$isLastQuestion = ($questionIndex + 1 == $survey->questionCount());
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="site.css">
  <title><?=$survey->title?></title>
</head>
<body>
  <header>
    <h1><?=$survey->title?></h1>
  </header>
  <main>
    <h2>Question <?=($questionIndex + 1)?> of <?=$survey->questionCount()?></h2>
    <form method="post">
      <input type="hidden" name="index" value="<?=$questionIndex?>">
      <fieldset>
        <?php
        $questionPath = "../inputs/" . $question->input . ".php";
        if (file_exists($questionPath)) {
          include $questionPath;
        } else {
          include "../inputs/text.php";
        }
        ?>
      </fieldset>
      <nav class="button-row">
        <button type="submit" name="direction" value="1" class="next-button">
          <?=($isLastQuestion ? "Finish" : "Next")?>
        </button>
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