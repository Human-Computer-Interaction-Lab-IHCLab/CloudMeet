<?php

/**
 * Task list view callback.
 */
function task_list_view($task_list) {
  drupal_set_title(entity_label('task_list', $task_list));
  return entity_view('task_list', array(entity_id('task_list', $task_list) => $task_list), 'full');
}
