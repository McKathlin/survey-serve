<legend><?=$question->text?></legend>
<?php 
for ($i = 0; $i < count($question->options); $i++) {
  $option = $question->options[$i];
  $checked = $option == $answer ? "checked" : "";
  echo "<div class='option-item'>";
  echo "  <input type='radio' id='$i' name='answer' value='$option' $checked>";
  echo "  <label for='$i'>$option</label>";
  echo "</div>\n";
}
?>