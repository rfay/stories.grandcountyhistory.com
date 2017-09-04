<?php
// responsive grid css
if (theme_get_setting('omega_responsive_grid') == 'enabled') {
  // 720px grid (if enabled)
  if(theme_get_setting('omega_responsive_medium')) {
    drupal_add_css(drupal_get_path('theme', 'beta') . '/css/720gs.css', array(
      'group' => CSS_THEME, 
      'every_page' => TRUE, 
      'weight', 20,
      )
    );
  }
  if(theme_get_setting('omega_responsive_default')) {
    drupal_add_css(drupal_get_path('theme', 'beta') . '/css/960gs.css', array(
      'group' => CSS_THEME, 
      'every_page' => TRUE, 
      'weight', 21,
      )
    );
  }
  if(theme_get_setting('omega_responsive_large')) {
    drupal_add_css(drupal_get_path('theme', 'beta') . '/css/1200gs.css', array(
      'group' => CSS_THEME, 
      'every_page' => TRUE, 
      'weight', 21,
      )
    );
  }
}