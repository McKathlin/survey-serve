<?php
if (!defined('INCLUDE_HTML_HELPER')) {
  define('INCLUDE_HTML_HELPER', true);

  // Split text on double line breaks to make paragraphs.
  function text_to_paragraphs($text, $element = 'p') {
    $standardizedText = str_replace("\r\n", "\n", trim($text));
    return
      "<$element>" .
      str_replace("\n\n", "</$element>\n<$element>", htmlentities($standardizedText)) .
      "</$element>";
  }

}
?>