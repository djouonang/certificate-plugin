<?php ?>
<form method="post">
	<div class="button_cont" align="center">
    <input type="submit" name="press" id="press" value="Download" /><br/>
	<input type='hidden' name='delegate_name' value='<?php echo $card_delegate_name;?>'/>
	<input type='hidden' name='certificate' value='<?php echo $certificate_preview;?>'/> 
	<input type="hidden" name="action" value="certificate-sheet" />
	 <?php wp_nonce_field('verify_certificate-sheet','nonce_certificate-sheet'); ?>
	</div>
    </form>
<?php ?>