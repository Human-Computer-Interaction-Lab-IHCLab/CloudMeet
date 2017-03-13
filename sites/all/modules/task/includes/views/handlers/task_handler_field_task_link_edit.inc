<?php

/**
 * @file
 * Definition of views_handler_field_task_link_edit.
 */

/**
 * Field handler to present a link task edit.
 *
 * @ingroup views_field_handlers
 */
class task_handler_field_task_link_edit extends task_handler_field_task_link {

  /**
   * Renders the link.
   */
  function render_link($task, $values) {
    // Ensure user has access to edit this task.
    if (!task_access('edit', $task)) {
      return;
    }

    $this->options['alter']['make_link'] = TRUE;
    $this->options['alter']['path'] = "task/$task->tid/edit";
    $this->options['alter']['query'] = drupal_get_destination();

    $text = !empty($this->options['text']) ? $this->options['text'] : t('edit');
    return $text;
  }
}
