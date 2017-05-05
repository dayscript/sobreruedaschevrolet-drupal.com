<<<<<<< HEAD
<?php

function sobre_ruedas_views_data_alter(&$data) {
  // debug($data['node']);
  $data['node']['sobre_ruedas_redeem_benefit'] = array(
    'title' => t('Redeem'),
    'help' => t('Clickable button to redeem benefits.'),
    'field' => array(
      'handler' => 'sobre_ruedas_views_handler_field_redeem',
      'group' => 'Sobre Ruedas',
      'click sortable' => FALSE,
    ),
  );

  $data['node']['sobre_ruedas_benefit_title'] = array(
    'title' => t('Benefit Title'),
    'help' => t('Benefit Title or surprise title.'),
    'field' => array(
      'handler' => 'sobre_ruedas_views_handler_field_title',
      'group' => 'Sobre Ruedas',
      'click sortable' => TRUE,
    ),
  );

  $data['node']['sobre_ruedas_benefit_description'] = array(
    'title' => t('Benefit Description'),
    'help' => t('Benefit description or surprise description.'),
    'field' => array(
      'handler' => 'sobre_ruedas_views_handler_field_description',
      'group' => 'Sobre Ruedas',
      'click sortable' => TRUE,
    ),
  );

  $data['node']['sobre_ruedas_active_quiz_link'] = array(
    'title' => t('Active Quiz Link'),
    'help' => t('Get the correct URL for viewing trivias.'),
    'field' => array(
      'handler' => 'sobre_ruedas_views_handler_field_active_quiz_link',
      'group' => 'Sobre Ruedas',
      'click sortable' => TRUE,
    ),
  );
=======
<?php

function sobre_ruedas_views_data_alter(&$data) {
  // debug($data['node']);
  $data['node']['sobre_ruedas_redeem_benefit'] = array(
    'title' => t('Redeem'),
    'help' => t('Clickable button to redeem benefits.'),
    'field' => array(
      'handler' => 'sobre_ruedas_views_handler_field_redeem',
      'group' => 'Sobre Ruedas',
      'click sortable' => FALSE,
    ),
  );

  $data['node']['sobre_ruedas_benefit_title'] = array(
    'title' => t('Benefit Title'),
    'help' => t('Benefit Title or surprise title.'),
    'field' => array(
      'handler' => 'sobre_ruedas_views_handler_field_title',
      'group' => 'Sobre Ruedas',
      'click sortable' => TRUE,
    ),
  );

  $data['node']['sobre_ruedas_benefit_description'] = array(
    'title' => t('Benefit Description'),
    'help' => t('Benefit description or surprise description.'),
    'field' => array(
      'handler' => 'sobre_ruedas_views_handler_field_description',
      'group' => 'Sobre Ruedas',
      'click sortable' => TRUE,
    ),
  );

  $data['node']['sobre_ruedas_active_quiz_link'] = array(
    'title' => t('Active Quiz Link'),
    'help' => t('Get the correct URL for viewing trivias.'),
    'field' => array(
      'handler' => 'sobre_ruedas_views_handler_field_active_quiz_link',
      'group' => 'Sobre Ruedas',
      'click sortable' => TRUE,
    ),
  );
>>>>>>> 8f58f30d06a6d6ae3f481fc9264055f2a8670c42
}