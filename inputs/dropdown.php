<label for="answer"><?=$question->text?></label>
<select id="answer" name="answer">
  <option value="">Select one...</option>
  <?php
  foreach ($question->options as $option) {
    if ($option == $answer) {
      echo "<option selected='selected'>$option</option>";
    } else {
      echo "<option>$option</option>\n";
    }
  }
  ?>
</select>