<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta content="text/html;" http-equiv="content-type" charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/base.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/admin.css" />
</head>

<body<?php if($print == 1): ?> onLoad='print()'<?php endif ?>>
	<div id="cont" style='width: 650px;'>
		<div class='content' style='width: 650px; height: 800px; background-color: rgb(255, 255, 255); padding: 0px'>
		
			<div class='bills'>
	
				<div class='bills_view' style='width:100%'>
		
					<div class='bills_superior'>
						<div class='billlogo'><img src='<?= $company['company_logo'] ?>' /></div>

						<div class='number'><?= strtoupper($bill['bill_name'])._(" nº ").$bill['serie'].$bill['number'] ?></div>
						<div class='date'><?= _("FECHA ")." ".$bill['date'] ?></div>

						<div class='biller'>
						    <p><strong><?= $company['name'] ?></strong></p><br />
						    <p><?= $company['vat_number'] ?></p>
						    <p><?= $company['address'] ?> </p>
						    <p><?= $company['postal_code']." ".$company['city'] ?> </p>
						    <p><?= $company['region']." - ".$company['country'] ?> </p>
						    <p><?= $company['phone1']." - ".$company['email'] ?> </p>
						</div>

						<div class='customerData'>
						    <p style='text-transform:uppercase'><?= $customer['first_name']." ".$customer['last_name'] ?></p>
						    <p><?= $customer['vat_number'] ?></p>
						    <p><?= $customer['address'] ?> </p>
						    <p><?= $customer['postal_code']." ".$customer['city'] ?> </p>
						    <p><?= $customer['region']." - ".$customer['country'] ?> </p>
						</div>
					</div>
		
					<div class='budgets'>
						<table class="estilo" border=0>
							<thead> 
								<tr> 
									<th scope="col" id="description"><?= _("Descripción") ?></th> 
									<th scope="col" id="qty" width=30><acronym title="<?= _("Cantidad") ?>">Q.</acronym></th>			
									<th scope="col" id="amount" width=50><?= _("Precio") ?></th> 
									<?php if($descuento > 0): ?>
									<th scope="col" id="discount" width=30><acronym title="<?= _("Descuento") ?>"><?= _("Dto.") ?></acronym>(%)</th> 
									<?php endif ?>
									<th scope="col" id="item_total" width=60 class="right"><?= _("Subtotal") ?></th> 
								</tr> 
							</thead> 
							<tfoot> 
								<tr><td colspan=<?php if($descuento > 0): ?>5<?php else: ?>4<?php endif ?> class='separator'>&nbsp;</td></tr>
								<tr> 
									<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
									<td scope="row" class="right"><p><?= _("SUBTOTAL") ?>:</p></td> 
									<td scope="row" class="right"><p id="subtotal"><strong><?= number_format($subtotal, 2, ",", ".") ?></strong></p></td> 
								</tr> 
								<?php if($descuento > 0): ?>
								<tr> 
									<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
									<td scope="row" class="right"><p><?= _("DESCUENTO") ?>:</p></td> 
									<td scope="row" class="right"><p id="total_discount"><?= number_format($descuento, 2, ",", ".") ?></p></td> 
								</tr> 
								<?php endif ?>
								<tr> 
									<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
									<td scope="row" class="right"><p><?= _("IMPUESTOS") ?>:</p></td> 
									<td scope="row" class="right"><p id="total_taxes"><?= number_format($impuesto1, 2, ",", ".") ?></p></td> 
								</tr> 
								<?php if($impuesto2 != 0): ?>
								<tr> 
									<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
									<td scope="row" class="right"><p><?= _("IMPUESTOS") ?>:</p></td> 
									<td scope="row" class="right"><p id="total_taxes"><?= number_format($impuesto2, 2, ",", ".") ?></p></td> 
								</tr> 
								<?php endif ?>
								<tr id="total_foot"> 
									<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
									<td scope="row" class="right btop arrowed"><strong><?= _("TOTAL") ?></strong></td> 
									<td scope="row" class="right btop"><p id="total"><strong><?= number_format($total, 2, ",", ".") ?></strong></p></td> 
								</tr> 
								<?php if($bill['advance'] >0): ?>
								<tr id="total_advance"> 
									<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
									<td scope="row" class="right btop arrowed"><strong><?= _("ANTICIPO") ?></strong></td> 
									<td scope="row" class="right btop"><p id="total"><strong><?= number_format($bill['advance'], 2, ",", ".") ?></strong></p></td> 
								</tr>
								<tr id="total_w_advance"> 
									<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
									<td scope="row" class="right btop arrowed"><strong><?= _("TOTAL SIN ANTICIPO") ?></strong></td> 
									<td scope="row" class="right btop"><p id="total"><strong><?= number_format($total - $bill['advance'], 2, ",", ".") ?></strong></p></td> 
								</tr>
								<?php endif ?>


							</tfoot> 
							<tbody id="items_list"> 
								<?php $grey = 'grey' ?>
								<?php for($i=0;$i<count($items);$i++): ?>
									<tr id="item_<?= $i ?>" index="0" class='<?= $grey ?>'> 
										<td> 
											<?= $items[$i]['description'] ?>
										</td> 
										<td> 
											<?= $items[$i]['quantity'] ?>
										</td> 
										<td class='right'> 
											<?= $items[$i]['price'] ?>
										</td> 
										<?php if($descuento > 0): ?>
										<td class='right'> 
											<?= $items[$i]['discount_rate']  ?> %
										</td> 
										<?php endif ?>
										<td class="right"><?= number_format(($items[$i]['quantity'] * $items[$i]['price']), 2, ",", ".") ?></td> 
									</tr>
								<?php endfor ?>
							</tbody> 
						</table>
					</div>

					<div class='bills_inferior'>
					<?php if(trim($bill['due_date']) != '00 / 00 / 0000'): ?>
						<div class='date'><?= _("FECHA DE VENCIMIENTO ")."<br />".$bill['due_date'] ?></div>
					<?php endif ?>
					<?php if(trim($bill['payment_method']) != ''): ?>
						<div class='payment'><?= _("FORMA DE PAGO ")."<br />".$bill['payment_method'] ?></div>
					<?php endif ?>
					<?php if(trim($bill['notes']) != ''): ?>
						<div class='ovservacions'><?= _("OBSERVACIONES ")."<br />".$bill['notes'] ?></div>
					<?php endif ?>
					</div>

				</div>

				<div class='floatfix'></div>

			</div>
			
		</div>
	</div>
</body>
</html>