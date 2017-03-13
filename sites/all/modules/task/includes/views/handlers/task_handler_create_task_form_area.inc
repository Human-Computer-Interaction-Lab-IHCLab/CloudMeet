<?php

class task_handler_create_task_form_area extends views_handler_area {
  function render($empty = FALSE) {
    $output = drupal_get_form('task_quick_create_task_form');

    return drupal_render($output);
  }
}