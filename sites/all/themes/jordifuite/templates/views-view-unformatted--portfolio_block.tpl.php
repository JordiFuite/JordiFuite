<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<div class="table">
<?php foreach ($rows as $id => $row): ?>
  <div <?php if ($classes_array[$id]) { print ' class="portfolio-column ' . $classes_array[$id] .'"';  } ?>>
    <?php print $row; ?>
  </div>
<?php endforeach; ?>
</div>
