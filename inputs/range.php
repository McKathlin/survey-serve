<label for="answer">
  <p><?=$question->text?></p>
  <p class="instruction">Adjust the sliding scale below to show your answer.</p>
  <div class="range-container">
    <span class="min-label"><?=$question->minLabel?></span>
    <input type="range" id="answer" name="answer"
      min="<?=$question->min?>" max="<?=$question->max?>" value="<?=$answer?>">
    <span class="max-label"><?=$question->maxLabel?></span>
  </div>
</label>