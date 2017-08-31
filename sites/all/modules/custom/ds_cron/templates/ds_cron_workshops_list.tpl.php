<?php
dpm($node);
?>
<div>Numero de talleres: <span><?php echo $node[0]->{'Nro Talleres.'}?></span></div>

<div class="row">
  <?php foreach ($node[0]->{'Detalle Talleres'} as $key => $workshop):?>
    <div class="view-content"
          style="margin: 8px 0;
                 border: solid 1px;
                 padding: 4px;">
      <div>nit_cliente:               <span><?php echo $workshop->nit_cliente?></span></div>
      <div>fecha_creacion:            <span><?php echo $workshop->fecha_creacion?></span></div>
      <div>tp_cliente:                <span><?php echo $workshop->tp_cliente?></span></div>
      <div>tp_taller:                 <span><?php echo $workshop->tp_taller?></span></div>
      <div>segunda_linea_direccion:   <span><?php echo $workshop->segunda_linea_direccion?></span></div>
      <div>tp_direccion_des:          <span><?php echo $workshop->tp_direccion_des?></span></div>
      <div>barrio_zona_des:           <span><?php echo $workshop->barrio_zona_des?></span></div>
      <div>nombre_rutero:             <span><?php echo $workshop->nombre_rutero?></span></div>
      <div>direccion_rutero:          <span><?php echo $workshop->direccion_rutero?></span></div>
      <div>NUMERO DE CONTACTOS :           <span><?php echo $workshop->Contactos->{'Nro Contactos'}?></span></div>
      <div class="view-content"
            style="margin: 8px 0;
                   border: solid 1px;
                   padding: 4px;">
      <?php foreach( $workshop->Contactos->{'Contactos Detalle'}  as $key => $value ):?>
          <div>documento   <span> <?php echo $value->documento ?></span></div>
          <div>primer_nombre   <span> <?php echo $value->primer_nombre ?></span></div>
          <div>segundo_nombre   <span> <?php echo $value->segundo_nombre ?></span></div>
          <div>apellidos   <span> <?php echo $value->apellidos ?></span></div>
          <div>estado_civil   <span> <?php echo $value->genero ?></span></div>
          <div>genero   <span> <?php echo $value->genero ?></span></div>
          <div>telefono   <span> <?php echo $value->telefono ?></span></div>
          <div>celular   <span> <?php echo $value->celular ?></span></div>
          <div>email   <span> <?php echo $value->email ?></span></div>
          <div>tipo_documento   <span> <?php echo $value->tipo_documento ?></span></div>
          <div>lugar_documento   <span> <?php echo $value->lugar_documento ?></span></div>
          <div>hdata   <span> <?php echo $value->hdata ?></span></div>
          <div>tp_tercero_des   <span> <?php echo $value->tp_tercero_des ?></span></div>
      <?php endforeach;?>
    </div>
    </div>
  <?php endforeach;?>
<div>
