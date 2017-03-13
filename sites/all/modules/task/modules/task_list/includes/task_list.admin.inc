<?php

/**
 * Generates the task_list type editing form.
 */
function task_list_type_form($form, &$form_state, $task_list_type, $op = 'edit') {

  if ($op == 'clone') {
    $task_list_type->label .= ' (cloned)';
    $task_list_type->type = '';
  }

  $form['label'] = array(
    '#title' => t('Label'),
    '#type' => 'textfield',
    '#default_value' => $task_list_type->label,
    '#description' => t('The human-readable name of this task_list type.'),
    '#required' => TRUE,
    '#size' => 30,
  );

  // Machine-readable type name.
  $form['type'] = array(
    '#type' => 'machine_name',
    '#default_value' => isset($task_list_type->type) ? $task_list_type->type : '',
    '#maxlength' => 32,
    '#disabled' => $task_list_type->isLocked() && $op != 'clone',
    '#machine_name' => array(
      'exists' => 'task_list_types',
      'source' => array('label'),
    ),
    '#description' => t('A unique machine-readable name for this task_list type. It must only contain lowercase letters, numbers, and underscores.'),
  );

  $form['description'] = array(
    '#type' => 'textarea',
    '#default_value' => isset($task_list_type->description) ? $task_list_type->description : '',
    '#description' => t('Description about the task_list type.'),
  );

  $form['actions'] = array('#type' => 'actions');
  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save task_list type'),
    '#weight' => 40,
  );

  if (!$task_list_type->isLocked() && $op != 'add' && $op != 'clone') {
    $form['actions']['delete'] = array(
      '#type' => 'submit',
      '#value' => t('Delete task_list type'),
      '#weight' => 45,
      '#limit_validation_errors' => array(),
      '#submit' => array('task_list_type_form_submit_delete')
    );
  }
  return $form;
}

/**
 * Submit handler for creating/editing task_list_type.
 */
function task_list_type_form_submit(&$form, &$form_state) {
  $task_list_type = entity_ui_form_submit_build_entity($form, $form_state);
  // Save and go back.
  task_list_type_save($task_list_type);

  // Redirect user back to list of task_list types.
  $form_state['redirect'] = 'admin/structure/task-list-types';
}

function task_list_type_form_submit_delete(&$form, &$form_state) {
  $form_state['redirect'] = 'admin/structure/task-list-types/' . $form_state['task_list_type']->type . '/delete';
}

/**
 * task_list type delete form.
 */
function task_list_type_form_delete_confirm($form, &$form_state, $task_list_type) {
  $form_state['task_list_type'] = $task_list_type;
  // Always provide entity id in the same form key as in the entity edit form.
  $form['task_list_type_id'] = array('#type' => 'value', '#value' => entity_id('task_list_type' ,$task_list_type));
  return confirm_form($form,
    t('Are you sure you want to delete task_list type %title?', array('%title' => entity_label('task_list_type', $task_list_type))),
      'task_list/' . entity_id('task_list_type' ,$task_list_type),
    t('This action cannot be undone.'),
    t('Delete'),
    t('Cancel')
  );
}

/**
 * task_list type delete form submit handler.
 */
function task_list_type_form_delete_confirm_submit($form, &$form_state) {
  $task_list_type = $form_state['task_list_type'];
  task_list_type_delete($task_list_type);

  watchdog('task_list_type', '@type: deleted %title.', array('@type' => $task_list_type->type, '%title' => $task_list_type->label));
  drupal_set_message(t('@type %title has been deleted.', array('@type' => $task_list_type->type, '%title' => $task_list_type->label)));

  $form_state['redirect'] = 'admin/structure/task-list-types';
}

/**
 * Page to select task_list Type to add new task_list.
 */
function task_list_admin_add_page() {
  $items = array();
  foreach (task_list_types() as $task_list_type_key => $task_list_type) {
    $items[] = l(entity_label('task_list_type', $task_list_type), 'task-list/add/' . $task_list_type_key);
  }
  return array('list' => array('#theme' => 'item_list', '#items' => $items, '#title' => t('Select type of task_list to create.')));
}

/**
 * Add new task_list page callback.
 */
function task_list_add($type) {
  $task_list_type = task_list_types($type);

  $task_list = entity_create('task_list', array('type' => $type));
  drupal_set_title(t('Create @name', array('@name' => entity_label('task_list_type', $task_list_type))));

  $output = drupal_get_form('task_list_form', $task_list);

  return $output;
}

/**
 * task_list Form.
 */
function task_list_form($form, &$form_state, $task_list) {
  $form_state['task_list'] = $task_list;

  $form['title'] = array(
    '#type' => 'textfield',
    '#required' => TRUE,
    '#title' => t('Name'),
    '#default_value' => $task_list->title,
  );

  $form['uid'] = array(
    '#type' => 'value',
    '#value' => $task_list->uid,
  );

  field_attach_form('task_list', $task_list, $form, $form_state);

  $submit = array();
  if (!empty($form['#submit'])) {
    $submit += $form['#submit'];
  }

  $form['actions'] = array(
    '#weight' => 100,
  );

  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save task_list'),
    '#submit' => $submit + array('task_list_form_submit'),
  );

  // Show Delete button if we edit task_list.
  $task_list_id = entity_id('task_list' ,$task_list);
  if (!empty($task_list_id) && task_list_access('edit', $task_list)) {
    $form['actions']['delete'] = array(
      '#type' => 'submit',
      '#value' => t('Delete'),
      '#submit' => array('task_list_form_submit_delete'),
    );
  }

  $form['#validate'][] = 'task_list_form_validate';

  return $form;
}

function task_list_form_validate($form, &$form_state) {

}

/**
 * task_list submit handler.
 */
function task_list_form_submit($form, &$form_state) {
  $task_list = $form_state['task_list'];

  entity_form_submit_build_entity('task_list', $task_list, $form, $form_state);

  task_list_save($task_list);

  $task_list_uri = entity_uri('task_list', $task_list);

  $form_state['redirect'] = $task_list_uri['path'];

  drupal_set_message(t('task_list %title saved.', array('%title' => entity_label('task_list', $task_list))));
}

function task_list_form_submit_delete($form, &$form_state) {
  $task_list = $form_state['task_list'];
  $task_list_uri = entity_uri('task_list', $task_list);
  $form_state['redirect'] = $task_list_uri['path'] . '/delete';
}

/**
 * Delete confirmation form.
 */
function task_list_delete_form($form, &$form_state, $task_list) {
  $form_state['task_list'] = $task_list;
  // Always provide entity id in the same form key as in the entity edit form.
  $form['task_list_type_id'] = array('#type' => 'value', '#value' => entity_id('task_list' ,$task_list));
  $task_list_uri = entity_uri('task_list', $task_list);
  return confirm_form($form,
    t('Are you sure you want to delete task_list %title?', array('%title' => entity_label('task_list', $task_list))),
    $task_list_uri['path'],
    t('This action cannot be undone.'),
    t('Delete'),
    t('Cancel')
  );
}

/**
 * Delete form submit handler.
 */
function task_list_delete_form_submit($form, &$form_state) {
  $task_list = $form_state['task_list'];
  task_list_delete($task_list);

  drupal_set_message(t('task_list %title deleted.', array('%title' => entity_label('task_list', $task_list))));

  $form_state['redirect'] = '<front>';
}
