<html>
<head>
    <meta content="text/html;" http-equiv="content-type" charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/print.css" />
	<style type='text/css'>

	html, body, div, span, applet, object, iframe,
	h1, h2, h3, h4, h5, h6, p, blockquote, pre,
	a, abbr, acronym, address, big, cite, code,
	del, dfn, em, font, img, ins, kbd, q, s, samp,
	small, strike, strong, sub, sup, tt, var,
	b, u, i, center,
	dl, dt, dd, ol, ul, li,
	fieldset, form, label, legend,
	table, caption, tbody, tfoot, thead, tr, th, td {
		margin: 0;
		padding: 0;
		border: 0;
		outline: 0;
		font-size: 10px;
		vertical-align: baseline;
		background: transparent;
	}
	ol, ul {
		list-style: none;
	}
	blockquote, q {
		quotes: none;
	}
	blockquote:before, blockquote:after,
	q:before, q:after {
		content: '';
		content: none;
	}

	:focus {
		outline: 0;
	}

	ins {
		text-decoration: none;
	}
	del {
		text-decoration: line-through;
	}

	table {
		border-collapse: collapse;
		border-spacing: 0;
	}

	body {
	    font-family:"arial",sans-serif;
	    font-size:10px;
	    /*height:100%;*/
	    background-color:#FFF;
	}
	#cont {
	    display:block;
	    width:90%;
	    /*height:1000px;*/
	    /*height:100%;*/
	    margin-left:auto;
	    margin-right:auto;
	    text-align:left;
		margin-top : 10px;
		padding 	: 1%;
		background : #FFF;
		-ms-border-radius: 5px;
		-moz-border-radius: 5px;  
		-webkit-border-radius: 5px;  
		-khtml-border-radius: 5px;
	}

	.lnk,
	a:link,
	a:visited,
	a:hover {
	    color : #669;
		text-decoration : none;
		cursor 	: pointer;
	}

	input.single {
		height 	: 20px;
		border 		: 1px solid #C0C3C6;
		border-radius: 3px;  
		-ms-border-radius: 3px;
		-moz-border-radius: 3px;  
		-webkit-border-radius: 3px;  
		-khtml-border-radius: 3px;
	}

	textarea.single {
		border 		: 1px solid #C0C3C6;
		border-radius: 3px;  
		-ms-border-radius: 3px;
		-moz-border-radius: 3px;  
		-webkit-border-radius: 3px;  
		-khtml-border-radius: 3px;
	}

	.right {
		text-align 	: right;
	}

	fieldset {
		border 		: 1px dotted #BBB;
		padding 	: 20px;
		margin-bottom: 20px;
		border-radius: 3px;  
		-ms-border-radius: 3px;
		-moz-border-radius: 3px;  
		-webkit-border-radius: 3px;  
		-khtml-border-radius: 3px;
	}

	legend {
		font-size 	: 10px;
		color 		: #666;
	}

	.rounded {
		-ms-border-radius: 2px;
		-moz-border-radius: 2px;  
		-webkit-border-radius: 2px;  
		-khtml-border-radius: 2px;
	}

	.fleft {
		position 	: relative;
		float 		: left;
	}

	.title {
		color 		: #666666;
		font-size 	: 30px;
		margin 		: 10px 0 10px;
		padding 	: 5px 10px 5px 0;
	}
	.description {
		font-size 	: 12px;
		color 		: #999;
		margin 		: 10px 0px 30px 0px;
		text-align 	: left;
	}

	dt, dd {
		padding 	: 10px 0 0px 0;
	}
	dt {
		font-weight 	: bold;
	}

	.bar {
		background 	: #EEE;
		height 		: 35px;
	}
	.bar .option {
		background 	: #FFF;
		margin 		: 4px;
		padding 	: 8px;
		float 		: left;
	}
	.bar .option a {
		color 		: #999;
		font-weight : bold;
	}
	.bar .option:hover a {
		color 		: #000;
	}

	.content {
		padding 	: 25px;
	}

	.floatfix {
		clear 		: both;
	}

	.inOptions {
		padding 	: 0 20px;
	}
	.inOptions ul {
		margin-bottom: 15px;
	}
	.inOptions li {
		padding 	: 7px 15px;
		background 	: url("<?= base_url() ?>system/includes/img/arrow.jpg") no-repeat 0px 8px;
		font-size 	: 13px;
	}
	.dg_fra, .dg_cus {
		position 	: relative;
		width 		: 45%;
		padding 	: 10px 2% 20px 2%;
		float 		: left;
	}
	.dg_cus {
		border-left : 1px solid #CCC;
	}
	.bills .estilo {
		width 		: 100%;
	}
	.bills .estilo td, .bills .estilo th {
		padding 	: 5px 10px;
	}
	.bills .estilo thead {
		border-bottom : 1px solid #000;
	}

	.bills #td_discount, .bills #td_taxes {
		display 	 : none;
	}

	.bills .bills_view {
		position 	: relative;
		float 		: left;
		width 		: 75%;
	}

		.bills .bills_view .bills_superior {
			height 	: 200px;
		}
		.bills .bills_view .bills_superior .billlogo {
			width 		: 300px;
			height 		: 60px;
		}

		.bills .bills_view .bills_superior .number, 
		.bills .bills_view .bills_superior .date, 
		.bills .bills_view .bills_superior .customerData {
			position 	: relative;
			float 		: right;
			width 		: 214px;
			height 		: 25px;
			padding 	: 3px 10px;
			margin 	 	: 0px 0 0 400px;
			border-bottom: 1px dotted #666;
			color 		: #666;
		}
		.bills .bills_view .bills_superior .number {
			border-top: 1px dotted #666;

		}
		.bills .bills_view .bills_superior .number, 
		.bills .bills_view .bills_superior .date {
			background-image 	: url("<?= base_url() ?>system/includes/img/arrow.jpg");
			background-repeat 	: no-repeat;
			background-position : center left;
			padding-left : 10px;
			width 		: 194px;
		}

		.bills .bills_view .bills_superior .date {
		}
		.bills .bills_view .bills_superior .customerData {
			height 		: 76px;
		}
		.bills .bills_view .bills_superior .customerData p {
			height 	: 16px;
		}
		.bills .bills_view .bills_superior .biller {
			float 		: left;
			width 		: 300px;
			line-height : 14px;
			height 		: 100px;
		}
		.bills .bills_view .budgets {
			width 		: 100%;
			height 		: auto;
			background 	: #EEE;
			margin 		: 0 0 50px 0;
			padding 	: 15px 0px 15px 0px;
			-ms-border-radius: 0px 25px 25px 0px;
			-moz-border-radius: 0px 25px 25px 0px;
			-webkit-border-radius: 0px 25px 25px 0px;
			-khtml-border-radius: 0px 25px 25px 0px;
		}
			.bills .bills_view .budgets thead {
				color 		: #666;
				text-transform: uppercase;
				border-bottom: 1px dotted #666;
			}
			.bills .bills_view .budgets thead th {
				height 		: 22px;
				
			}
			.bills .bills_view .budgets tbody td {
				height 		: 5px;
				border-bottom: 1px dotted #666;
			}
			.bills .bills_view .budgets tbody tr {
				border-bottom: 1px dotted #666;
			}
			.bills .bills_view .budgets tfoot td {
					height 		: 5px;
				}

			.btop {
				border-top: 1px dotted #666;
			}

			.bills .bills_view .budgets td.arrowed {
				background : url(<?= base_url() ?>system/includes/img/arrowgrey.jpg) no-repeat 0px 5px;
			}

		.bills_inferior	{
			width 		: 100%;
			border-top  : 1px dotted #666;
		}
		.bills_inferior	div {
			background : url(<?= base_url() ?>system/includes/img/arrow.jpg) no-repeat 0px 5px;
			border-bottom: 1px dotted #666;
			padding 	: 5px 0px 5px 20px;
			color 		: #666;
		}

		.bills_inferior	div.date {
			height 	: 25px;
		}

		.bills_inferior	div.ovservacions, .bills_inferior div.payment {
			height	: 65px;
		}

	.bills .bills_options, .customer .bills_options {
		position 	: relative;
		float 		: right;
		width 		: 20%;
		border-left : 2px dotted #7C2006;
		min-height	: 500px;
	}		
	</style>
</head>

<body>
	<div id="cont" style='width: 650px;'>
		<div class='content'>
		
			<div class='bills'>
	
				<div class='bills_view' style='width:100%'>
		
					<div class='bills_superior'>
						<table>
							<tr>
								<td>
									<div class='billlogo'>
										<img src='<?= base_url().$company['company_logo'] ?>' />
									</div>
									<div class='biller'>
									    <p><strong><?= $company['name'] ?></strong></p><br />
									    <p><?= $company['vat_number'] ?></p>
									    <p><?= $company['address'] ?> </p>
									    <p><?= $company['postal_code']." ".$company['city'] ?> </p>
									    <p><?= $company['region']." - ".$company['country'] ?> </p>
									    <p><?= $company['phone1']." - ".$company['email'] ?> </p>
									</div>
								</td>
								<td>
									<div class='number'><?= strtoupper($bill['bill_name'])._(" nº ").$bill['serie'].$bill['number'] ?></div>
									<div class='date'><?= _("FECHA:")." ".$bill['date'] ?></div>
									<div class='customerData'>
									    <p style='text-transform:uppercase'><?= $customer['first_name']." ".$customer['last_name'] ?></p>
									    <p><?= $customer['vat_number'] ?></p>
									    <?php if($customer['address'] != ''): ?><p><?= $customer['address'] ?> </p><?php endif ?>
									    <?php if($customer['postal_code'] != ''): ?><p><?= $customer['postal_code']." ".$customer['city'] ?> </p><?php endif ?>
									    <?php if($customer['country'] != '' || $customer['region'] != ''): ?><p><?= $customer['region']." - ".$customer['country'] ?> </p><?php endif ?>
									</div>
								</td>
							</tr>
						</table>

					</div>
		
					<div class='budgets'>
						<table class="estilo" border=0>
							<thead> 
								<tr> 
									<th scope="col" id="description" align='left' width=<?php if($descuento > 0): ?>200<?php else: ?>320<?php endif ?>><?= _("Descripción") ?></th> 
									<th scope="col" id="qty" width=20><acronym title="<?= _("Cantidad") ?>">Q.</acronym></th>			
									<th scope="col" id="amount" width=20><?= _("Precio") ?></th> 
									<?php if($descuento > 0): ?>
									<th scope="col" id="discount" width=20><?= _("Dto.") ?></th> 
									<?php endif ?>
									<th scope="col" id="item_total" width=60 class="right"><?= _("Subtotal") ?></th> 
								</tr> 
							</thead> 

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
							
							<tfoot> 
								<tr><td colspan=<?php if($descuento > 0): ?>5<?php else: ?>4<?php endif ?> class='separator'>&nbsp;</td></tr>
								<tr> 
									<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
									<td scope="row" class="right"><p><?= _("SUBTOTAL") ?>:</p></td> 
									<td scope="row" class="right"><p id="subtotal"><strong><?= number_format($subtotal, 2, ",", ".") ?></strong></p></td> 
								</tr> 
								<tr> 
									<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
									<td scope="row" class="right"><p><?= _("DESCUENTO") ?>:</p></td> 
									<td scope="row" class="right"><p id="total_discount"><?= number_format($descuento, 2, ",", ".") ?></p></td> 
								</tr> 
								<tr> 
									<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
									<td scope="row" class="right"><p><?= _("IMPUESTOS") ?>:</p></td> 
									<td scope="row" class="right"><p id="total_taxes"><?= number_format($impuesto1, 2, ",", ".") ?></p></td> 
								</tr> 

								<?php if($impuesto2 != 0): ?>
								<tr> 
									<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
									<td scope="row" class="right"><p><?= _("IMPUESTOS") ?>:</p></td> 
									<td scope="row" class="right"><p id="total_taxes"><?= number_format($impuesto1, 2, ",", ".") ?></p></td> 
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
						</table>
					</div>

					<div class='bills_inferior'>
						<?php if($bill['due_date'] != ' 00 / 00 / 0000'): ?>
						<div class='date'>
							<p><?= _("FECHA DE VENCIMIENTO ") ?><?= $bill['due_date'] ?>
						</div>
						<?php endif ?>
						<?php if(trim($bill['payment_method']) != ''): ?>
						<div class='payment'>
							<p><?= _("FORMA DE PAGO: ") ?> <?= $bill['payment_method'] ?></p>
								</tr>
							</table>
						</div>
						<?php endif ?>
						<?php if(trim($bill['notes']) != ''): ?>
						<div class='ovservacions'>
							<p><?= _("OBSERVACIONES: ") ?></p>
							<p>
								<?= $bill['notes'] ?>
							</p>
						</div>
						<?php endif ?>
					</div>

				</div>

				<div class='floatfix'></div>

			</div>
			
		</div>
	</div>
</body>
</html>