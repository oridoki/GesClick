<tr id='tax_tr_<?= $tax['id'] ?>'>
	<td id='tax_<?= $tax['id'] ?>_name'><?= $tax['name'] ?></td>
	<td id='tax_<?= $tax['id'] ?>_value'><?= $tax['value'] ?></td>
	<td class='options'>
		<div class='linked' onClick='deleteTax(<?= $tax['id'] ?>)'><img src='<?= base_url() ?>system/includes/img/icons/delete.jpg' title='<?= _("Borrar Empresa") ?>' alt='<?= _("Borrar Empresa") ?>' width=15 /></div>
		<div class='linked' onClick='editTax(<?= $tax['id'] ?>)'><img src='<?= base_url() ?>system/includes/img/icons/edit.jpg' title='<?= _("Editar Empresa") ?>' alt='<?= _("Editar Empresa") ?>' width=15 /></div>
	</td>
</tr>