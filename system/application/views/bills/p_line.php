<tr valign='top' id='bill_tr_<?= $bill['id'] ?>' onClick='viewBill(<?= $bill['id'] ?>)' style='background:<?= $bill['color'] ?>'>
	<td  width=20>
		<div class='wrapp'></div>
	</td>
<!--

	<td width=15>
		<input type='checkbox' class='noMargin' id='line<?= $bill['id'] ?>' name='line<?= $bill['id'] ?>' value='<?= $bill['id'] ?>' />
	</td>
-->	
	<?php if(isset($bill['tipus'])): ?>
	<td class='serie type<?= $bill['type_id'] ?>'>
		<?= $bill['tipus'] ?>
	</td>
	<?php endif ?>
	<td class='serie'>
		<?= $bill['serie'] ?> <?= $bill['number'] ?>
	</td>
	<td>
		<?= $bill['first_name']." ".$bill['last_name'] ?>
	</td>
	<td>
		<?= substr($bill['date'], 0, strpos($bill['date'], " ")) ?>
	</td>
	<td class='right'>
		<?= number_format($bill['total'], 2, ",", ".") ?>
	</td>
</tr>