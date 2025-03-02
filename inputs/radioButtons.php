<legend><?=$question->text?></legend>
<?php 
for ($i = 0; $i < count($question->options); $i++) { 
  $option = $question->options[$i];
  echo "<div class='option-item'>";
  echo "  <input type='radio' id='$i' name='answer' value='$option'>";
  echo "  <label for='$i'>$option</label>";
  echo "</div>\n";
}
?>