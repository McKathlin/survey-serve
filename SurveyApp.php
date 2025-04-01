<?php
require '../lib/html_helper.php';

// Classes in this file:
// * SurveyApp
// * SurveySession

class SurveyApp {
  // Paths (relative to public_html)

  const SURVEY_DIR = "../surveys";
  const ANSWERS_DIR = "../answers";

  public static function getSurveyPath($surveyHandle) {
    return self::SURVEY_DIR . "/" . $surveyHandle . ".json";
  }

  public static function getAnswersPath($surveyHandle) {
    return self::ANSWERS_DIR . "/" . $surveyHandle . ".tsv";
  }

  // Session

  public static function startSession($surveyHandle) {
    return SurveySession::startFromFile(self::getSurveyPath($surveyHandle));
  }

  public static function resumeSession() {
    return SurveySession::resume();
  }

  public static function finishSession() {
    $survey = SurveySession::resume();
    self::_writeSurveyAnswers("../answers/$survey->handle.tsv");
    SurveySession::clear();
  }

  private static function _writeSurveyAnswers($path) {
    $survey = SurveySession::resume();
    if (is_null($survey)) {
      return false;
    }

    // Append answers to a TSV file.
    $tsvItems = [];
    foreach ($survey->getPlainAnswers() as $answer) {
      $tsvAnswer = $answer;
      $tsvAnswer = str_replace("\r\n", "\n", $tsvAnswer);
      $tsvAnswer = str_replace("\\", "\\\\", $tsvAnswer);
      $tsvAnswer = str_replace("\n", "\\n", $tsvAnswer);
      $tsvAnswer = str_replace("\t", "\\t", $tsvAnswer);
      array_push($tsvItems, $tsvAnswer);
    }
    $tsvLine = implode("\t", $tsvItems) . "\n";
    file_put_contents($path, $tsvLine, FILE_APPEND);
    return true;
  }
}

class SurveySession {
  // Properties
  public string $title;
  public string $intro;
  public string $handle;
  public array $questions;

  // Raw answers are private because they contain unsafe user-submitted text.
  private array $answers;

  // Constructor
  public function __construct($dataObject, $answers = NULL) {
    $this->title = $dataObject->title;
    $this->intro = $dataObject->intro;
    $this->handle = $dataObject->handle;
    $this->questions = $dataObject->questions;
    $this->answers = $answers ?? [];
  }

  // Static factory methods

  public static function startFromFile($path) {
    if (file_exists($path)) {
      return self::startFromJson(file_get_contents($path));
    } else {
      return NULL;
    }
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
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    if (isset($_SESSION['survey'])) {
      return new SurveySession($_SESSION['survey'], $_SESSION['answers']);
    } else {
      return NULL;
    }
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

  // Returns all answers, unaltered.
  // Syntactic vinegar for answers property
  public function getPlainAnswers() {
    return $this->answers;
  }
}

?>
