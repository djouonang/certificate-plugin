<?php ?>

<link rel='stylesheet' id='custom-fonts-css'  href='<?php echo plugin_dir_url( __FILE__ ) ; ?>css/card.css' type='text/css' />
<link rel='stylesheet' id='certificates_style-css'  href='https://training.noiaa.com/wp-content/plugins/certificate%20Builder/admin/css/card.css?ver=5.2.5' type='text/css' media='all' />


<div class="container">
 <center>
<div class="header-image7">
<div class="cardpic"><img  alt="" style="width:280px;height:190px;" src="<?php echo $attachment_url; ?>" /></div>
<div class="fontclass position1 fontsize1"><?php echo $card_delegate_name; ?></div>
<div class="fontclass position2 fontsize2"><?php echo $certificate_id_barcode; ?></div>
<div class="fontclass2 position3 fontsize2"><span style="color:#f8981d">Valid till: <?php echo $expirationdate; ?></span></div>
<div class="cardbarcode"><img  style='width:120px;height:117px;' src='<?php echo $qrcode; ?>' border='0'/></div>
</div>
 </center>
</div>

<?php ?>