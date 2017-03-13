<?php


class task_handler_field_task_completed extends views_handler_field_boolean {

  function render($values) {

    $value = $this->get_value($values);
    if (!empty($this->options['not'])) {
      $value = !$value;
    }

    if ($this->options['type'] == 'custom') {
      return $value ? filter_xss_admin($this->options['type_custom_true']) : filter_xss_admin($this->options['type_custom_false']);
    }
    else if (isset($this->formats[$this->options['type']])) {

      ctools_include('ajax');

      return $value ? ctools_ajax_text_button($this->formats[$this->options['type']][0], "task/ajax/complete/nojs/$values->tid", t('Complete task')) : ctools_ajax_text_button($this->formats[$this->options['type']][1], "task/ajax/complete/nojs/$values->tid", t('Complete task'));
    }
    else {
      return $value ? $this->formats['yes-no'][0] : $this->formats['yes-no'][1];
    }
  }

}