<?php

function sobre_ruedas_api_connection_form(){
  $form = array();

  $form['sobre_ruedas_api_connection_keyuserid'] = array(
    '#type' => 'textfield',
    '#title' => 'Key User Id',
    '#size' => 60,
    '#description' => 'Id Usuario asignado en el sistema de Visitadores Mecánicos',
    '#default_value' => variable_get('sobre_ruedas_api_connection_keyuserid'), 
    '#required' => true,
  );

  $form['sobre_ruedas_api_connection_keysecurity'] = array(
    '#type' => 'textfield',
    '#title' => 'Key Security',
    '#size' => 60,
    '#description' => 'Clave asignada en Sistema de Informacíon – Visitadores Mecánicos y ACdelco',
    '#default_value' => variable_get('sobre_ruedas_api_connection_keysecurity'), 
    '#required' => true,
  );

  return system_settings_form($form);
}

function sobre_ruedas_api_connection_consume_form(){
  $keyuserid = variable_get('sobre_ruedas_api_connection_keyuserid');
  $keysecurity = variable_get('sobre_ruedas_api_connection_keysecurity');

  $form = array();
  
  if(!$keyuserid && !$keysecurity){
    drupal_set_message(t('Check the configuration settings'));
  }else{

    $form['sobre_ruedas_api_connection_consume_startdate'] = array(
      '#type' => 'date', 
      '#title' => 'Desde', 
      '#default_value' => array(
        'month' => 1,
        'day' => 1,
        'year' => date('Y')
      ), 
      '#description' => 'Fecha inicial de la consulta',
      '#required' => false
    );

    $form['sobre_ruedas_api_connection_consume_enddate'] = array(
      '#type' => 'date', 
      '#title' => 'Hasta', 
      '#description' => 'Fecha final de la consulta',
      '#required' => false
    );

    $form['submit_button'] = array(
      '#type' => 'submit',
      // '#ajax' => array(
      //   'callback' => 'ajax_example_autocheckboxes_callback',
      //   'wrapper' => 'sr-table',
      //   'method' => 'replace',
      //   'effect' => 'fade',
      // ),
      '#value' => t('update'),
    );

    $form['sobre_ruedas_api_connection_consume_list'] = array(
      '#markup' => '<div id="sr-table"></div>',
    );
  }

  return $form;
}

function sobre_ruedas_api_connection_consume_form_validate($form, &$form_state) {

}

function sobre_ruedas_api_connection_consume_form_submit($form, &$form_state) {
  $idKey = '900111222'. date('Ymd') .'190146238120';
  $keyuserid = variable_get('sobre_ruedas_api_connection_keyuserid');
  $keysecurity = variable_get('sobre_ruedas_api_connection_keysecurity');

  $start = $form_state['values']['sobre_ruedas_api_connection_consume_startdate'];
  $start['month'] = $start['month'] < 10 ? '0'.$start['month'] : $start['month'];

  $end = $form_state['values']['sobre_ruedas_api_connection_consume_enddate'];
  $end['month'] = $end['month'] < 10 ? '0'.$end['month'] : $end['month'];

  $start_date = $start['year'].$start['month'].$start['day'];

  $end_date = $end['year'].$end['month'].$end['day'];
  $client = new SoapClient('http://visitadorchevrolet.appsxw.co/api/api.ws?wsdl');

  $response = $client->RequestVisitadores($idKey, $keyuserid ,$keysecurity, $start_date, $end_date);

  $talleres = json_decode($response);
  $talleres = $talleres[0]->{'Detalle Talleres'};

  foreach ($talleres as $key => $taller) {
    dpm($taller);
  }
}