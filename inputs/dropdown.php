<label for="answer"><?=$question->text?></label>
<select id="answer" name="answer">
  <option value="">Select one...</option>
  <?php
  foreach ($question->options as $option) {
    echo "<option>$option</option>\n";
  }
  ?>
</select>