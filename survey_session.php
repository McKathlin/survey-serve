<?php
require '../lib/html_helper.php';

class SurveySession {
  // Properties
  public string $title;
  public string $intro;
  public array $questions;

  // Raw answers are private because they contain unsafe user-submitted text.
  private array $answers;

  // Constructor
  public function __construct($dataObject, $answers = NULL) {
    $this->title = $dataObject->title;
    $this->intro = $dataObject->intro;
    $this->questions = $dataObject->questions;
    $this->answers = $answers ?? [];
  }

  // Static factory methods

  public static function startFromFile($path) {
    return SurveySession::startFromJson(file_get_contents($path));
  }

  public static function startFromJson($json) {
    $newData = json_decode($json);
    $newAnswers = [];
    session_start();
    $_SESSION['survey'] = $newData;
    $_SESSION['answers'] = $newAnswers;
    $survey = new SurveySession($newData, $newAnswers);
    return $survey;
  }

  public static function resume() {
    session_start();
    if (!isset($_SESSION['survey'])) {
      return NULL;
    }
    return new SurveySession($_SESSION['survey'], $_SESSION['answers']);
  }

  public static function clear() {
    session_start();
    $_SESSION['survey'] = NULL;
    $_SESSION['answers'] = NULL;
  }

  // Instance methods

  public function questionCount() {
    return count($this->questions);
  }

  // Sets an answer at a given index.
  // If there is already an answer, the new value replaces the old.
  public function setAnswer($index, $value) {
    $this->answers[$index] = $value;
    $_SESSION['answers'][$index] = $value;
  }

  // Returns an answer in an HTML-safe form.
  public function getAnswerHtml($index, $element = NULL) {
    $answer = $this->answers[$index];
    if (is_null($element)) {
      return htmlentities($answer);
    } else if ('paragraph' == $this->questions[$index]->input) {
      return text_to_paragraphs($answer, $element);
    } else {
      return "<$element>" . htmlentities($answer) . "</$element>";
    }
  }
}

?>
