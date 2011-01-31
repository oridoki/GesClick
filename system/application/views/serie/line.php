<tr id='serie_tr_<?= $serie['id'] ?>'>
	<td id='serie_<?= $serie['id'] ?>_title'><?= $serie['prefix'] ?></td>
	<td id='serie_<?= $serie['id'] ?>_body'><?= $serie['description'] ?></td>
	<td class='options'>
		<span class='linked' onClick='editSerie(<?= $serie['id'] ?>)'><img src='<?= base_url() ?>system/includes/img/icons/edit.jpg' title='<?= _("Editar Serie") ?>' alt='<?= _("Editar Serie") ?>' width=25 /></span>
		<span class='linked' onClick='deleteSerie(<?= $serie['id'] ?>)'><img src='<?= base_url() ?>system/includes/img/icons/delete.jpg' title='<?= _("Borrar Serie") ?>' alt='<?= _("Borrar Serie") ?>' width=25 /></span>
	</td>
</tr>
