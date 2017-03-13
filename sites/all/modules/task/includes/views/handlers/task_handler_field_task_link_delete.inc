<?php

/**
 * @file
 * Definition of views_handler_field_task_link_delete.
 */

/**
 * Field handler to present a link task delete.
 *
 * @ingroup views_field_handlers
 */
class task_handler_field_task_link_delete extends task_handler_field_task_link {

  /**
   * Renders the link.
   */
  function render_link($task, $values) {
    // Ensure user has access to delete this task.
    if (!task_access('delete', $task)) {
      return;
    }

    $this->options['alter']['make_link'] = TRUE;
    $this->options['alter']['path'] = "task/$task->tid/delete";
    $this->options['alter']['query'] = drupal_get_destination();

    $text = !empty($this->options['text']) ? $this->options['text'] : t('delete');
    return $text;
  }
}
