<tr valign='top' id='customer_tr_<?= $customer['id'] ?>' onClick='viewCustomer(<?= $customer['id'] ?>)'>
	<td  width=20>
		<div class='wrapp'></div>
	</td>
<!--
	<td width=15>
		<input type='checkbox' class='noMargin' />
	</td>
-->
	<td>
		<?= $customer['first_name'] ?> <?= $customer['last_name'] ?>
	</td>
	<td class='greytd'>
		<?php if($customer['email']): ?>
		<a href='mailto:<?= $customer['email'] ?>'><?= $customer['email'] ?></a>
		<?php endif; ?>
	</td>
	<td class='greytd right'>
		<?= $customer['phone1'] ?>
	</td>
	<td class='greytd right'>
		<?= $customer['phone2'] ?>
	</td>
</tr>
