<?php

/**
 * @file
 * Provide views data and handlers for task.
 */

/**
 * Implements hook_views_data_alter().
 */
function task_views_data_alter(&$data) {

  $data['views']['task_create_task_form'] = array(
    'title' => t('Create task form'),
    'help' => t('Provides a form for creating tasks.'),
    'area' => array(
      'handler' => 'task_handler_create_task_form_area',
    ),
  );

  $data['task']['edit_task'] = array(
    'field' => array(
      'title' => t('Edit link'),
      'help' => t('Provide a simple link to edit the task.'),
      'handler' => 'task_handler_field_task_link_edit',
    ),
  );

  $data['task']['delete_task'] = array(
    'field' => array(
      'title' => t('Delete link'),
      'help' => t('Provide a simple link to delete the task.'),
      'handler' => 'task_handler_field_task_link_delete',
    ),
  );

  $data['task']['completed']['field']['handler'] = 'task_handler_field_task_completed';

  return $data;
}
