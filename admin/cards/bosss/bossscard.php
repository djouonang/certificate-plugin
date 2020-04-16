<?php ?>

<div class="container">
<center>
<div class="header-image4">
<div class="cardpic"><img  alt="" style="width:280px;height:190px;" src="<?php echo $attachment_url; ?>" /></div>
<div class="fontclass position1 fontsize1"><?php echo $card_delegate_name; ?></div>
<div class="fontclass position2 fontsize2"><?php echo $certificate_id_barcode; ?></div>
<div class="fontclass2 position3 fontsize2"><span style="color:#0c4da2">Valid till: <?php echo $expirationdatei; ?></span></div>
<div class="cardbarcode"><img  style='width:120px;height:117px;' src='<?php echo $qrcode; ?>' border='0'/></div>
</div>
</center>
</div>

<?php ?>