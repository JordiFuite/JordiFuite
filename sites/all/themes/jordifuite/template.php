<?php

/**
 * Add body classes if certain regions have content.
 */
function jordifuite_preprocess_html(&$variables) {
  if (isset($_GET['embed']) && $_GET['embed'] == 1) {
    $variables['theme_hook_suggestions'][] = 'html__embed';
  }
  else {
    if (!empty($variables['page']['featured'])) {
      $variables['classes_array'][] = 'featured';
    }

    if (!empty($variables['page']['triptych_first'])
      || !empty($variables['page']['triptych_middle'])
      || !empty($variables['page']['triptych_last'])) {
      $variables['classes_array'][] = 'triptych';
    }

    if (!empty($variables['page']['footer_firstcolumn'])
      || !empty($variables['page']['footer_secondcolumn'])
      || !empty($variables['page']['footer_thirdcolumn'])
      || !empty($variables['page']['footer_fourthcolumn'])) {
      $variables['classes_array'][] = 'footer-columns';
    }

    // Add conditional stylesheets for IE
    drupal_add_css(path_to_theme() . '/css/ie.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
    drupal_add_css(path_to_theme() . '/css/ie6.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'IE 6', '!IE' => FALSE), 'preprocess' => FALSE));
    drupal_add_js(path_to_theme() . '/js/behaviors.js');
    drupal_add_js(path_to_theme() . '/js/youtube.js');
    drupal_add_js(path_to_theme() . '/js/jquery.tubular.1.0.js');
  }
  if (isset($_GET['q'])) {
    $classes = $_GET['q'];
  }
  else {
    $classes = 'front';
  }
    $classes = str_replace('/', '-', $classes);
    $variables['classes_array'][] = $classes;

}

/**
 * Override or insert variables into the page template for HTML output.
 */
function jordifuite_process_html(&$variables) {
  // Hook into color.module.
  if (module_exists('color')) {
    _color_html_alter($variables);
  }
}
function jordifuite_preprocess_region(&$variables) {
  if (isset($_GET['embed']) && $_GET['embed'] == 1) {
    $variables['theme_hook_suggestions'][] = 'region__embed';
  }
}
/**
 * Override or insert variables into the page template.
 */
function jordifuite_process_page(&$variables) {
  // Hook into color.module.
  if (module_exists('color')) {
    _color_page_alter($variables);
  }
  // Always print the site name and slogan, but if they are toggled off, we'll
  // just hide them visually.
  $variables['hide_site_name']   = theme_get_setting('toggle_name') ? FALSE : TRUE;
  $variables['hide_site_slogan'] = theme_get_setting('toggle_slogan') ? FALSE : TRUE;
  if ($variables['hide_site_name']) {
    // If toggle_name is FALSE, the site_name will be empty, so we rebuild it.
    $variables['site_name'] = filter_xss_admin(variable_get('site_name', 'Drupal'));
  }
  if ($variables['hide_site_slogan']) {
    // If toggle_site_slogan is FALSE, the site_slogan will be empty, so we rebuild it.
    $variables['site_slogan'] = filter_xss_admin(variable_get('site_slogan', ''));
  }
  // Since the title and the shortcut link are both block level elements,
  // positioning them next to each other is much simpler with a wrapper div.
  if (!empty($variables['title_suffix']['add_or_remove_shortcut']) && $variables['title']) {
    // Add a wrapper div using the title_prefix and title_suffix render elements.
    $variables['title_prefix']['shortcut_wrapper'] = array(
      '#markup' => '<div class="shortcut-wrapper clearfix">',
      '#weight' => 100,
    );
    $variables['title_suffix']['shortcut_wrapper'] = array(
      '#markup' => '</div>',
      '#weight' => -99,
    );
    // Make sure the shortcut link is the first item in title_suffix.
    $variables['title_suffix']['add_or_remove_shortcut']['#weight'] = -100;
  }
}

function jordifuite_preprocess_page(&$variables) {
  if (isset($_GET['embed']) && $_GET['embed'] == 1) {
    $variables['theme_hook_suggestions'][] = 'page__embed';
  }
  if (isset($variables['node'])) {
    if ($variables['node']->type == 'portfolio_item') {
      $variables['title'] = 'Portfolio';
    }
  }
}

function jordifuite_node_view($node, $view_mode, $langcode) {
}

/**
 * Override or insert variables into the node template.
 */
function jordifuite_preprocess_node(&$variables) {
  if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
    $variables['classes_array'][] = 'node-full';
  }
}

/**
 * Override or insert variables into the block template.
 */
function jordifuite_preprocess_block(&$variables) {
  // In the header region visually hide block titles.
  if ($variables['block']->region == 'header') {
    $variables['title_attributes_array']['class'][] = 'element-invisible';
  }
  if (isset($_GET['embed']) && $_GET['embed'] == 1) {
    $variables['theme_hook_suggestions'][] = 'block__embed';
  }
}

/**
 * Implements theme_menu_tree().
 */
function jordifuite_menu_tree($variables) {
  return '<ul class="menu clearfix">' . $variables['tree'] . '</ul>';
}


