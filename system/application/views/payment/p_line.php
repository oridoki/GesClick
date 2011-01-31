<tr valign='top' id='payment_tr_<?= $payment['id'] ?>' onClick='editPayment(<?= $payment['id'] ?>)' style='background:<?= $payment['color'] ?>'>
	<td  width=20>
		<div class='wrapp'></div>
	</td>
	<?php if(isset($payment['serie'])): ?>
	<td class='serie'>
		<?= $payment['serie']." ".$payment['number'] ?>
	</td>
	<?php endif ?>
	<?php if(isset($payment['first_name'])): ?>
	<td width=200>
		<strong><?= $payment['first_name']." ".$payment['last_name'] ?></strong>
	</td>
	<?php endif ?>
	<td>
		<input type='hidden' name='payment_bill_id' class='payment_bill_id' value='<?= (isset($payment['bill_id'])) ? $payment['bill_id'] : '' ?>' />
		<input type='hidden' name='payment_notes' class='payment_notes' value='<?= ($payment['notes']) ? $payment['notes'] : '' ?>' />
		<input type='hidden' name='payment_state' class='payment_state' value='<?= ($payment['state']) ? $payment['state'] : '0' ?>' />
		
		<span class='payment_alias'><?= $payment['alias'] ?></span>
	</td>
	<td class='payment_state right state<?= $payment['state'] ?>' width=100>
		<?php $stateName = ($this->config->item('stateName')) ?>
		<?= $stateName[$payment['state']] ?>
	</td>
	<td class='right' width=100>
		<span class='payment_date'><?= trim($payment['date']) ?></span>
	</td>
	<td class='right' width=100>
		<span class='payment_amount'><?= number_format($payment['amount'], 2, ",", ".") ?></span> €
	</td>
</tr>