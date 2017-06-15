 <?php setlocale(LC_MONETARY,"en_CO");?>
 <table id="resumen-cuenta" style="width: 100%;">
 	<tbody>
 		<tr class="segmento">
 			<td><strong>Tu segmento:</strong></td>
 			<td style="text-align: right;">

      	<strong title="<?php echo $title ?>"><?php echo $user_segmento ?></strong>

      </td>
		</tr>
		<tr>
			<td>Tus compras:</td>
			<td style="text-align: right;"><strong><?php echo '$ '.number_format($value_total, 0, '.', '.') ?></strong></td>
		</tr>
		<tr>
			<td>Te falta para subir de segmento:</td>
			<td style="text-align: right;"><strong><?php echo '$ '.number_format($diference_value, 0, '.', '.') ?></strong>
		</td>
		</tr>
	</tbody>
</table>
