<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php foreach ($rows as $id => $row): ?>
  <div class="slider-item">
    <div class="sub-wrapper">
      <?php print $row; ?>
    </div>
  </div>
<?php endforeach; ?>
