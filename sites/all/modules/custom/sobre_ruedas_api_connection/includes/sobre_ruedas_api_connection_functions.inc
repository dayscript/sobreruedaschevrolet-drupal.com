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
  $return = array();
  foreach ($talleres as $key => $value) {
    $return[$value->nit_cliente]['guid'] = $value->nit_cliente;
    $return[$value->nit_cliente]['nit_cliente'] = $value->nit_cliente;
    $return[$value->nit_cliente]['fecha_creacion'] = $value->fecha_creacion;
    $return[$value->nit_cliente]['nombre_tercero'] = ucwords(strtolower($value->nombre_tercero));
    $return[$value->nit_cliente]['tp_taller'] = ucfirst(strtolower($value->tp_taller));
    $return[$value->nit_cliente]['role'] = 'Taller';
    $return[$value->nit_cliente]['apellidos'] = '';
    $return[$value->nit_cliente]['pass'] = $value->nit_cliente;
    $return[$value->nit_cliente]['taller_relacionado'] = '';


    if( $value->Contactos->{'Nro Contactos'} >= 1 ){
      $return[$value->nit_cliente]['email'] = ($value->Contactos->{'Contactos Detalle'}[0]->email != '' && $value->Contactos->{'Contactos Detalle'}[0]->email != 'Na') ? $value->Contactos->{'Contactos Detalle'}[0]->email:$value->nit_cliente.'@sincorreo.com';
      if(isset($_GET['mecanicos'])){
        foreach( $value->Contactos->{'Contactos Detalle'} as $key => $contacto){
          if(ucfirst(strtolower($contacto->tp_tercero_des)) == 'Mecanico' || ucfirst(strtolower($contacto->tp_tercero_des)) == 'Propietario' ){
            $return[$contacto->documento]['guid'] = $contacto->documento;
            $return[$contacto->documento]['nit_cliente'] = $contacto->documento;
            $return[$contacto->documento]['fecha_creacion'] = $value->fecha_creacion;
            $return[$contacto->documento]['nombre_tercero'] = $contacto->primer_nombre.' '.$contacto->segundo_nombre ;
            $return[$contacto->documento]['apellidos'] = $contacto->apellidos ;
            $return[$contacto->documento]['tp_taller'] = ucfirst(strtolower($value->tp_taller));
            $return[$contacto->documento]['role'] = ucfirst(strtolower($contacto->tp_tercero_des));
            $return[$contacto->documento]['pass'] = $contacto->documento;
            $return[$contacto->documento]['email'] = ( $contacto->email != '' && $contacto->email != 'Na' )? $contacto->email:$contacto->documento.'@sincorreo.com';
            $return[$contacto->documento]['taller_relacionado'] = $value->nit_cliente;
          }
        }
      }
    }else{
      $return[$value->nit_cliente]['email'] = $value->nit_cliente.'@sincorreo.com';
    }
  }
  #Order
  foreach ($return as $key => $value) {
    $role[$key] = $value['role'];
  }
  array_multisort($role, SORT_DESC, $return);
  return drupal_json_output($return);
}

function sobre_ruedas_get_purchases() {

  $idKey = '900111222'. date('Ymd') .'190146238120';
  $keyuserid = variable_get('sobre_ruedas_api_connection_keyuserid');
  $keysecurity = variable_get('sobre_ruedas_api_connection_keysecurity');

  $start_date = '2017011';
  $end_date = '20170428';
  $client_id = '17195260';

  $client = new SoapClient('http://visitadorchevrolet.appsxw.co/api/api.ws?wsdl');

  $users = '["1003400709","1012329331","1013583846","1014219781","1014254149","1014285099","1016001033","10160833128","101704401","1018432632","1022394717","10238656291","103056222","1030637483","1032358298","103238757","1032412933","106791575","1071646354","1100397526","11178045427","11252341","113379169","12101223","13353263","13883372","16450372","166620428","171708837","17193508","17195260","184618062","19078228","19120641","191823788","19210389","19233578","19233990","192364955","19257841","19276587","19282712","19287419","19290077","19297309","19331475","19340394","193663298","193739391","194582217","19465454","19490074","24182749","2890847","3184086","3192747","3222593","3229999","38386269","396866162","39710789","42426177","4281738","4292435","51906537","520253288","520791441","52110395","52190456","52336806","523671375","52397601","52453842","52551574","53080501","5595831","5619442","5853390","5978985","602937969","6385971","657461132","67575145","7219722","731374774","73339560","74333512","78763155","790443209","79050854","79051528","79056886","79058749","791046795","79105765","791293552","79153151","792413661","79246285","79252324","792533971","79256541","79265007","79271033","79271414","79273266","79277189","79278427","79287064","79287505","79291395","79318040","79331096","79332563","793508770","79353230","79353491","793709093","79378911","794138821","79414679","79428641","79430194","79445776","79474192","79480836","79484152","79496825","79500897","79500915","79504577","79516426","79530379","79556659","79559104","795604969","79562053","79583498","795963151","795990403","79611998","79627224","79627545","796536592","796557821","79706295","79713257","79717682","79735909","797367487","79741464","79750605","79753979","79794000","79803672","79816530","79841250","79852305","79860729","79867664","79870346","79879376","79899471","799067761","79938846","79955283","79973769","79995947","79999350","800144034","80017968","80018395","800187839","800193855","80025060","800659756","801181781","80123971","80174372","80178972","80179414","801961041","80239412","80251006","80260805","804074905","804091970","80415670","80466523","80470040","80761012","80762918","80878720","830063073","830126102","830136774","830371362","860007339","86001482","860507000","900018910","900021123","900045014","900049767","900100831","900209134","900261567","900267320","900350242","900352174","900387117","900500948","900517684","900521430","900621949","900702742","900808781","900868766","900884189","900955135","91013577","93294425","932982536","95355018","95363403"]';

  foreach (json_decode($users) as $key => $value) {
    $response[$value] = $client->RequestPurchases($idKey, $keyuserid ,$keysecurity, $value,  $start_date, $end_date);
  }

 /* $response = '[{"ip1":"200.118.122.79","Nro Items":8,"Datos Compras":[{"sede":"REPUESTOS AMERICAS","numerofactura":"74574","referencias":"93745867","valor_unitario":"351546.00","descripcion":"KITEMBRAGUE","fecha":"2017-03-04","nit":"79050854"},{"sede":"REPUESTOS AMERICAS","numerofactura":"74574","referencias":"96238218","valor_unitario":"893.00","descripcion":"BUJE CONTROL DECAMBIOS","fecha":"2017-03-04","nit":"79050854"},{"sede":"REPUESTOS AMERICAS","numerofactura":"74648","referencias":"93746917","valor_unitario":"292124.00","descripcion":"KIT SISTDISTRIBUCION","fecha":"2017-03-07","nit":"79050854"},{"sede":"REPUESTOS AMERICAS","numerofactura":"74950","referencias":"55594651","valor_unitario":"36524.00","descripcion":"ELEMENTO FILTRO ACEITEY","fecha":"2017-03-18","nit":"79050854"},{"sede":"REPUESTOS AMERICAS","numerofactura":"74950","referencias":"95021102","valor_unitario":"76075.00","descripcion":"ELEMENTO PURIFICADORAIRE","fecha":"2017-03-18","nit":"79050854"},{"sede":"REPUESTOS AMERICAS","numerofactura":"74950","referencias":"95632506-1","valor_unitario":"29000.00","descripcion":"ACEITE SINTETICO 5W30X CUARTOS","fecha":"2017-03-18","nit":"79050854"},{"sede":"REPUESTOS AMERICAS","numerofactura":"75017","referencias":"12620540","valor_unitario":"45166.00","descripcion":"BUJIA 41-108 CAPTIVASPOR","fecha":"2017-03-22","nit":"79050854"},{"sede":"REPUESTOS AMERICAS","numerofactura":"75340","referencias":"96893815","valor_unitario":"132581.00","descripcion":"SENSOR PRESION AIREMULTIPLE ADMISION","fecha":"2017-04-04","nit":"79050854"}]}]';*/

  dpm($response);
  return 'asd'; #drupal_json_output($purchases);

}
