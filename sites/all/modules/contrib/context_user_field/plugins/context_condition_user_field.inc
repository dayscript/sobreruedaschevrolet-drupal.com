<?php
/**
 * @file
 * Context plugin class.
 */

/**
 * Expose use field as a context condition.
 */
class context_condition_user_field extends context_condition {

  /**
   * Condition form.
   *
   * @param object $context
   *    Drupal context.
   *
   * @return array
   *    Returns condition form.
   */
  public function condition_form($context) {
    $form = array();
    $defaults = $this->fetch_from_context($context, 'values');

    $user_fields = field_info_instances('user');
    $field_names = array_keys($user_fields['user']);

    if (!empty($field_names)) {
      $field_names = array_combine($field_names, $field_names);

      $form['user_field_name'] = array(
        '#title' => t('Field name'),
        '#type' => 'select',
        '#options' => $field_names,
        '#description' => t('Select entity field to check'),
        '#default_value' => isset($defaults['user_field_name']) ? $defaults['user_field_name'] : TRUE,
      );

      $form['user_field_blank'] = array(
        '#title' => t('Empty field'),
        '#type' => 'checkbox',
        '#description' => t('Flag this to activate reaction on empty field.'),
        '#default_value' => isset($defaults['user_field_blank']) ? $defaults['user_field_blank'] : TRUE,
      );

      $form['user_field_value'] = array(
        '#title' => t('Field value'),
        '#type' => 'textarea',
        '#description' => t('For multiply values, write one user field value per line to compare'),
        '#default_value' => isset($defaults['user_field_value']) ? $defaults['user_field_value'] : '',
        '#states' => array(
          'visible' => array(
            ':input[name*="user_field_blank"]' => array('checked' => FALSE),
          ),
        ),
      );
    }
    else {
      $form['empty'] = array(
        '#markup' => t("User don't have any fields"),
      );
    }

    return $form;
  }

  /**
   * Condition form submit handler.
   *
   * @param array $values
   *    Form submit values.
   *
   * @return array
   *    Returns field values.
   */
  public function condition_form_submit($values) {
    if (!isset($values['empty'])) {
      $values['user_field_blank'] = isset($values['user_field_blank']) ? $values['user_field_blank'] : FALSE;
      return array(
        'user_field_name' => $values['user_field_name'],
        'user_field_value' => $values['user_field_value'],
        'user_field_blank' => $values['user_field_blank'],
      );
    }
    return array();
  }

  /**
   * Execute.
   *
   * @param string $user
   *    Current user.
   */
  public function execute($user) {
    if ($this->condition_used()) {
      if ($account = user_load($user->uid)) {
        foreach ($this->get_contexts() as $context) {
          $settings = $this->fetch_from_context($context, 'values');
          $items = field_get_items('user', $account, $settings['user_field_name']);

          if (!is_array($items) && $settings['user_field_blank']) {
            $this->condition_met($context);
          }
          elseif (!empty($items)) {
            $values = $this->get_field_multiple_value($settings['user_field_name'], $items);
            $field_values = preg_split('/\r\n/', $settings['user_field_value'], -1);
            $intersect = array_intersect($field_values, $values);
            if (!empty($intersect)) {
              $this->condition_met($context);
            }
          }
        }
      }
    }
  }

  /**
   * Get values for specified field.
   *
   * @param string $field_name
   *    Field name.
   * @param array $items
   *    Values of field.
   *
   * @return array
   *    Return prepared field values.
   */
  protected function get_field_multiple_value($field_name, array $items) {
    $values = array();

    foreach ($items as $item) {
      $values[] = $this->get_field_value($field_name, $item);
    }

    return $values;
  }

  /**
   * Get value for specified field.
   *
   * @param string $field_name
   *    Field name.
   * @param array $item
   *    Values of field.
   *
   * @return mixed
   *    Return value from values array.
   */
  protected function get_field_value($field_name, array $item) {
    $field_info = field_info_field($field_name);

    $field_types = array(
      'taxonomy_term_reference' => 'tid',
      'node_reference' => 'nid',
      'user_reference' => 'uid',
    );

    // Extract values_keys for current field.
    $type = $field_info['type'];
    $value_key = isset($field_types[$type]) ? $field_types[$type] : 'value';

    return isset($item[$value_key]) ? $item[$value_key] : NULL;
  }

}

