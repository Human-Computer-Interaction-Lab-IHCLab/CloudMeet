<?php

/**
 * Task view callback.
 */
function task_view($task) {
  drupal_set_title(entity_label('task', $task));
  return entity_view('task', array(entity_id('task', $task) => $task), 'full');
}

function task_user_overview($user) {
  $output = '';

  if (entity_access('create', 'task', 'task')) {
    // Get quick create form.
    $form = drupal_get_form('task_quick_create_task_form');
    $output .= render($form);
  }

  $user_task_page = arg(3);

  switch ($user_task_page) {
    case "assigned":
      $view_display = 'user_assigned_tasks';
      break;
    case "completed":
      $view_display = 'user_completed_tasks';
      break;
    default:
      $view_display = 'user_tasks';
  }

  // Load view.
  $output .= views_embed_view('task_user_tasks', $view_display);

  return $output;
}