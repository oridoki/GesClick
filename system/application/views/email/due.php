<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Generic Template - Right Sidebar</title>
   <style type="text/css" media="screen">
      body {
         background-color: #eeeeee;
      }

      a img {
         border: none;
      }

      table.bg1 {
         background-color: #eeeeee;
      }

      table.bg2 {
         background-color: #ffffff;
      }

      td.permission {
         background-color: #eeeeee;
         padding: 10px 20px 10px 20px;
      }

      td.permission p {
         font-family: Arial;
         font-size: 11px;
         font-weight: normal;
         color: #333333;
         margin: 0;
         padding: 0;
      }

      td.permission p a {
         font-family: Arial;
         font-size: 11px;
         font-weight: normal;
         color: #333333;
      }

      td.body {
         padding: 0 20px 20px 20px;
         background-color: #ffffff;
      }

      td.sidebar h3 {
         font-family: Arial;
         font-size: 15px;
         font-weight: bold;
         color: #333333;
         margin: 0;
         padding: 0;
      }

      td.sidebar ul {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #333333;
         margin: 6px 0 14px 24px;
         padding: 0;
      }

      td.sidebar ul li a {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #680606;
      }

      td.sidebar h4 {
         font-family: Arial;
         font-size: 13px;
         font-weight: bold;
         color: #680606;
         margin: 6px 0 0 0;
         padding: 0;
      }

      td.sidebar h4 a {
         font-family: Arial;
         font-size: 13px;
         font-weight: bold;
         color: #680606;
         text-decoration: none;
      }

      td.sidebar p {
         font-family: Arial;
         font-size: 12px;
         font-weight: normal;
         color: #333333;
         margin: 0 0 10px 0;
         padding: 0;
      }

      td.sidebar p a {
         font-family: Arial;
         font-size: 12px;
         font-weight: normal;
         color: #680606;
         text-decoration: none;
      }

      td.buttons {
        padding: 20px 0 0 0; 
      }

      td.mainbar h2 {
         font-family: Arial;
         font-size: 16px;
         font-weight: bold;
         color: #680606;
         margin: 0;
         padding: 0;
      }

      td.mainbar h2 a {
         font-family: Arial;
         font-size: 16px;
         font-weight: bold;
         color: #680606;
         text-decoration: none;
         margin: 0;
         padding: 0;
      }

      td.mainbar img.hr {
         margin: 0;
         padding: 0 0 10px 0;
      }

      td.mainbar p {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #333333;
         margin: 0 0 14px 0;
         padding: 0;
      }

      td.mainbar p a {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #680606;
      }

      td.mainbar p.more a {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #680606;
         text-decoration: none;
      }

      td.mainbar ul {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #333333;
         margin: 0 0 14px 24px;
         padding: 0;
      }

      td.mainbar ul li a {
         font-family: Arial;
         font-size: 13px;
         font-weight: normal;
         color: #680606;
      }

      td.footer {
         padding: 0 20px 0 20px;
         background-image: url('footer-bg.gif');
         background-repeat: no-repeat;
         background-position: top center;
         background-color: #333333;
         height: 61px;
         vertical-align: middle;
      }

      td.footer p {
         font-family: Arial;
         font-size: 11px;
         font-weight: normal;
         color: #ffffff;
         line-height: 16px;
         margin: 0;
         padding: 0;
      }
   </style>
</head>
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bg1">
   <tr>
      <td align="center">
         
         <table width="600" border="0" cellspacing="0" cellpadding="0" class="bg2">
            <tr>
               <td class="permission" align="left">
                  <p>Está recibiendo esta notificación, porqué está registrado en GesClick.</p>
                  <p>Modifica tus preferencias <unsubscribe><a href='<?= base_url() ?>'>Accediendo a tu cuenta</a></unsubscribe>.</p> 
               </td>
            </tr>
            <tr>
               <td class="header" align="left">
                  <img src="<?= base_url() ?>system/includes/img/newsletter/header.jpg" alt="GesClick - Herramienta de gestión online" width="600" height="150" />
               </td>
            </tr>
            <tr>
               <td valign="top" class="body">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                        <td width="370" valign="top" class="mainbar" align="left">

							<?php foreach($companies as $company): ?>
							<?php if($company['payments']): ?>
							<h2><?= $company['name'] ?></h2>
                            <img class="hr" src="<?= base_url() ?>system/includes/img/newsletter/hr.gif" alt="Header" width="340" height="3" />

							<?php foreach($company['payments'] as $payment): ?>
								<p>
									<strong><?= $payment['first_name'] ?> <?= $payment['last_name'] ?></strong><br />
									<?= _('Vencido el dia: ').$payment['date'] ?><br />
									<?= _('Total deuda: ').number_format($payment['amount'], 2, ",", ".") ?> &euro;<br />
								</p>
							<?php endforeach ?>
							<?php endif ?>

							<?php endforeach ?>
                           <p class="more"><a href="#">Conocer más</a> <img src="<?= base_url() ?>system/includes/img/newsletter/read-more.gif" alt="Conocer más" width="8" height="8" /></p>




                        </td>
                        
                        <td width="20"></td>
                        
                        <td valign="top" width="170" class="sidebar" align="left">
                           <h3>Novedades GesClick</h3>
                           
                           <h4><a href="#">Envía facturas por email</a></h4>
                           <p>Ahora puedes enviar facturas por email a tus clientes en formato PDF.</p>
                           
                           <h4><a href="#">Gestiona Cobros</a></h4>
                           <p>No te olvides de tus cobros, te recodamos diariamente los cobros vencidos, para que no pierdas ni uno.</p>
                           
                           <br />
                           
                           <h3>Acceder</h3>
                           <p><a href='<?= base_url() ?>'>Accede a tu cuenta</a> para gestionar tus facturas, cobros y de más.</p>
                           
                           <h3>Darse de baja</h3>
                           <p>No quiere recibir más emails <a href='<?= base_url() ?>'>Accede a tu cuenta</a> y entra en el apartado de configuración.</p>
						
							<h3>Ayúdanos a mejorar</h3>
							<p><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="EVQVPS6KLU4NQ">
							<input type="image" src="https://www.paypal.com/es_ES/ES/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal. La forma rápida y segura de pagar en Internet.">
							<img alt="" border="0" src="https://www.paypal.com/es_ES/i/scr/pixel.gif" width="1" height="1">
							</form></p>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td valign="middle" align="left" class="footer" height="61">
                  <p>GesClick y el logo de GesClick son marca registrada de Web Clau S.C.P.<br />
                  <p>Web Clau S.C.P. c/ Barcelona, 40 Tortosa - Tarragona +34 977 443 629</p>
               </td>
            </tr>
         </table>
         
      </td>
   </tr>
</table>

</body>
</html>