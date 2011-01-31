<tr id='contact_tr_<?= $contact['id'] ?>' onClick='editContact(<?= $contact['id'] ?>)'>
	<td  width=20>
		<div class='wrapp'></div>
	</td>
	<td>
		<span id='contact_td_name_<?= $contact['id'] ?>'><?= $contact['name'] ?></span> 
		<span id='contact_td_surname_<?= $contact['id'] ?>'><?= $contact['surname'] ?></span>
	</td>
	<td width=100 id='contact_td_phone1_<?= $contact['id'] ?>'><?= $contact['phone1'] ?></td>
	<td width=100 id='contact_td_phone2_<?= $contact['id'] ?>'><?= $contact['phone2'] ?></td>
	<td class='right' width=200 id='contact_td_email_<?= $contact['id'] ?>'><?= mailto($contact['email1']) ?></td>
</tr>