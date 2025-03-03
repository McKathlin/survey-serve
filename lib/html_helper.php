<?php
if (!defined('INCLUDE_HTML_HELPER')) {
  define('INCLUDE_HTML_HELPER', true);

  // Split text on double line breaks to make paragraphs.
  function text_to_paragraphs($text) {
    return
      '<p>' .
      str_replace("\n\n", "</p>\n\n<p>", htmlentities($text)) .
      '</p>';
  }

}
?>