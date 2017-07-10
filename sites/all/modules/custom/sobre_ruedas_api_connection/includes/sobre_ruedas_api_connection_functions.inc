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


function sobre_ruedas_get_users() {

  $idKey = '900111222'. date('Ymd') .'190146238120';
  $keyuserid = variable_get('sobre_ruedas_api_connection_keyuserid');
  $keysecurity = variable_get('sobre_ruedas_api_connection_keysecurity');

  $start_date = '2017011';
  $end_date = '20170515';

  $client = new SoapClient('http://visitadorchevrolet.appsxw.co/api/api.ws?wsdl');

  $response = $client->RequestVisitadores($idKey, $keyuserid ,$keysecurity, $start_date, $end_date);
  $talleres = json_decode($response);
  $talleres = $talleres[0]->{'Detalle Talleres'};
  #dpm($talleres);
  $return = array();
  foreach ($talleres as $key => $value) {
    if(isset($_GET['talleres'])){
      $return[$value->nit_cliente]['guid'] = $value->nit_cliente;
      $return[$value->nit_cliente]['nit_cliente'] = $value->nit_cliente;
      $return[$value->nit_cliente]['fecha_creacion'] = $value->fecha_creacion;
      $return[$value->nit_cliente]['titulo'] = ucwords(strtolower($value->nombre_tercero));
      $return[$value->nit_cliente]['tp_taller'] = ( strtolower( $value->tp_taller ) == "gasolina" )?'gasoline':'diesel';
      $return[$value->nit_cliente]['email'] = $value->nit_cliente.'@sincorreo.com';
      $return[$value->nit_cliente]['direccion'] = $value->segunda_linea_direccion;
      $return[$value->nit_cliente]['barrio'] = $value->barrio_zona_des;
      $return[$value->nit_cliente]['ciudad'] = 'Bogotá';
      $return[$value->nit_cliente]['tp_cliente'] = $value->tp_cliente;
    }
    if(isset($_GET['mecanicos'])){
      if( $value->Contactos->{'Nro Contactos'} >= 1 ){
        foreach( $value->Contactos->{'Contactos Detalle'} as $key => $contacto){
          if(ucfirst(strtolower($contacto->tp_tercero_des)) == 'Mecanico' || ucfirst(strtolower($contacto->tp_tercero_des)) == 'Propietario' ){
            $return[$contacto->documento]['guid'] = $contacto->documento;
            $return[$contacto->documento]['nit_cliente'] = $contacto->documento;
            $return[$contacto->documento]['fecha_creacion'] = $value->fecha_creacion;
            $return[$contacto->documento]['nombre_tercero'] = $contacto->primer_nombre.' '.$contacto->segundo_nombre ;
            $return[$contacto->documento]['apellidos'] = $contacto->apellidos ;
            $return[$contacto->documento]['tp_taller'] = ( strtolower( $value->tp_taller ) == "gasolina" )?'gasoline':'diesel';
            $return[$contacto->documento]['role'] = ucfirst( strtolower( $contacto->tp_tercero_des ) );
            $return[$contacto->documento]['pass'] = $contacto->documento;
            $return[$contacto->documento]['email'] = validate_email($contacto->email,$contacto->documento);
            $return[$contacto->documento]['taller_relacionado'] = $value->nit_cliente;
            $return[$contacto->documento]['estado_civil'] = $value->estado_civil;
            $return[$contacto->documento]['genero'] = $contacto->genero;
            $return[$contacto->documento]['telefono'] = $contacto->telefono;
            $return[$contacto->documento]['celular'] = $contacto->celular;
            $return[$contacto->documento]['hdata'] = $contacto->hdata;
          }
        }
      }
    }
  }
  #Order
  foreach ($return as $key => $value) {
    $role[$key] = $value['role'];
  }
  array_multisort($role, SORT_DESC, $return);
  #dpm($return);
  #return 'OK';

  return drupal_json_output($return);
}

function sobre_ruedas_get_purchases() {

  $idKey = '900111222'. date('Ymd') .'190146238120';
  $keyuserid = variable_get('sobre_ruedas_api_connection_keyuserid');
  $keysecurity = variable_get('sobre_ruedas_api_connection_keysecurity');

  $start_date = '2017011';
  $end_date = str_replace('-','',date('Y-m-d'));
  $client_id = '17195260';


  $client = new SoapClient('http://visitadorchevrolet.appsxw.co/api/api.ws?wsdl');

  $users = user_load_multiple($uids = array(), $conditions = array('status'=>'1'),$reset=false);
  $users_nids = array();
  foreach ($users as $key => $user) {
    if(in_array('Propietario',$user->roles) || in_array('Mecanico',$user->roles)){
          $users_nids[$user->uid] = $user->name;
    }
  }

  foreach ($users_nids as $key => $identification) {
    $response_data = json_decode($client->RequestPurchases($idKey, $keyuserid ,$keysecurity, $identification,  $start_date, $end_date));
    if( !array_key_exists('Response', $response_data[0] ) ){
        foreach($response_data[0]->{'Datos Compras'} as $id => $purchase){
            $response[$purchase->referencias]['guid'] = $purchase->referencias;
            $response[$purchase->referencias]['valor_unitario'] = $purchase->valor_unitario ;
            $response[$purchase->referencias]['descripcion'] = $purchase->descripcion ;
            $response[$purchase->referencias]['nit'] = $purchase->nit;
            $response[$purchase->referencias]['title'] = $purchase->referencias.'-'.$purchase->fecha.'-'.$purchase->nit;
        }
    }
  }

  return drupal_json_output($response);
  /*return 'asd';*/

}

function validate_email( $email, $nit ){

  if( filter_var($email, FILTER_VALIDATE_EMAIL) !== false){
      return str_replace(' ', '', $email);
  }

  if( $email =="" || $email=="Na" || $email =="NA"  ){
      return $nit.'@sincorreo.com';
  }

  $domains = array('hotmail.com','gmail.com','outlook.com','mail.com','yahoo.es','yahoo.com','yahoo.co');
  $email = 'Carloshuuuoutlook.com';
  foreach ($domains as $key => $domain) {
    if( strpos($email, $domain) !== false  ){
        $pos = strpos($email, $domain);
        return  str_replace(' ','',substr_replace($email ,'@',$pos,0));
      }
  }
}
