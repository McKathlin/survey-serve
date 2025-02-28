<?php

// Split text on double line breaks to make paragraphs.
function text_to_paragraphs($text) {
  return
    '<p>' .
    str_replace("\n\n", "</p>\n\n<p>", htmlentities($text)) .
    '</p>';
}

?>