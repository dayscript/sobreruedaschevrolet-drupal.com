<?php

/**
 * Implements template_preprocess_html().
 */
function sobre_ruedas_preprocess_html(&$variables) {
}

/**
 * Implements template_preprocess_page.
 */
function sobre_ruedas_preprocess_page(&$variables) {
  $user = $variables['user'];

  $show_contextual_tabs = FALSE;
  foreach ($user->roles as $role) {
    if($role == 'administrator'){
      $show_contextual_tabs = TRUE;
    }
  }

  if(!$show_contextual_tabs){
    unset($variables['tabs']);
  }
}