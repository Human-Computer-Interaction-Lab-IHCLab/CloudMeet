<?php

/**
 * @file
 * Provides preprocess logic and other functionality for theming.
 */
// Ensure that __DIR__ constant is defined:
if (!defined('__DIR__')) {
  define('__DIR__', dirname(__FILE__));
}


// Require module-specific files:
$requires = file_scan_directory(__DIR__ . '/includes/modules', '/\.inc$/');
foreach ($requires as $require) {
  if (module_exists($require->name)) {
    require_once $require->uri;
  }
}

/**
 * Implements hook_theme().
 */
function html5_simplified_theme($existing, $type, $theme, $path) {
  return array(
    'navbar_brand' => array(
      'variables' => array(
        'name' => NULL,
        'href' => NULL,
        'logo' => NULL,
      ),
    ),
    'navbar_toggler' => array(),
    'preface' => array(
      'path' => $path . '/templates',
      'template' => 'preface',
      'variables' => array(
        'breadcrumb' => NULL,
        'title_prefix' => array(),
        'title' => NULL,
        'title_suffix' => array(),
        'messages' => NULL,
        'help' => array(),
        'tabs' => array(),
        'actions' => array(),
      ),
    ),
    'copyright' => array(
      'variables' => array(
        'name' => NULL,
      ),
    ),
    'pure_form_wrapper' => array(
      'render element' => 'element',
    ),
    'search_input_wrapper' => array(
      'render element' => 'element',
    ),
  );
}

/**
 * Implement hook_preprocess_page().
 */
function html5_simplified_preprocess_page(&$variables) {
  $variables['site_name'] = $variables['site_slogan'] = '';
  if(theme_get_setting('toggle_name')) {
    $variables['site_name'] = filter_xss_admin(variable_get('site_name', 'Drupal'));
  }
  if(theme_get_setting('toggle_slogan')) {
    $variables['site_slogan'] .= filter_xss_admin(variable_get('site_slogan', 'Responsive simplified theme'));
  }
  $variables['site_name_and_slogan'] = $variables['site_name'] . ' ' . $variables['site_slogon'];
  if(theme_get_setting('toggle_main_menu')) {
    $variables['navbar_menu'] = theme('links__system_main_menu', array(
        'links' => $variables['main_menu'],
        'attributes' => array(
            'class' => array('links', 'inline', 'main-menu'),
        ),
        'heading' => array(
            'text' => t('Main menu'),
            'level' => 'h2',
            'class' => array('element-invisible'),
        )
    ));
  }
}