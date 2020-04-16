<?php
function update_certificateeee(){
    global $wpdb;
	$table_certificate = $wpdb->prefix . 'certificat';
	$id = $_GET["id"];
	$status = $_GET["status"]; // To differentiate between update and delete operation
	$result1 = $wpdb->get_row("SELECT * FROM $table_certificate WHERE idcertificat = '{$id}' ");
    $name = $result1->nom;
	$numero = $result1->numero;
	$datei = $result1->date_creation;
	$datee = $result1->date_expiration;
	 $getidsociete = $result1->idsociete;
	 $idformation = $result1->idformation;
	 $table_name1 = $wpdb->prefix . 'societe';
	 $table_name2 = $wpdb->prefix . 'formation';
     $result3 = $wpdb->get_row("SELECT * FROM $table_name1 WHERE idsociete = '{$getidsociete}' ");
	 $result4 = $wpdb->get_row("SELECT * FROM $table_name2 WHERE idformation = '{$idformation}' ");
     $getcompany = $result3->titre;
	 $getcourse = $result4->titre;
	
		
		// Delete operation takes place if ($status == "delete") condition is met
		
		if($status == "delete") {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_certificate WHERE idcertificat = %s", $id));
		
		  ?>
            <div class="updated"><p>Delegate's details deleted</p>
            <a class="button" href="<?php echo admin_url('admin.php?page=certificate_builder') ?>">&laquo; Back to Certificates dashboard</a>
            </div>
<?php 
     } 
 
 if ( isset( $_POST["form_submit"] ) ) { 
 
    $updatename = trim($_POST["delegate_name"]);
    $updatednumero = trim($_POST["certificate_id"]); 
	$updatedgetcourse = trim($_POST["training_course"]);
	$updatedgetcompany = trim($_POST["company"]);
	$updateddatei = trim($_POST["issuedate"]);
	$updateddatee = trim($_POST["expirationdate"]);
	
	// Update values to database
	
	$wpdb->update($table_certificate, 
		 array('nom' => $updatename,
               'numero' => $updatednumero, 
			   'idformation' => $updatedgetcourse,
	           'idsociete' => $updatedgetcompany,
			   'date_creation' => $updateddatei, 
			   'date_expiration' => $updateddatee), 
			   array('idcertificat' => $id), array('%s','%s','%d','%d','%s','%s'),
         array('%d'));
		
		/** updating company and training course should be reviewed so that company and course field should be drown down fields with values
		from the database just as it is on insert company and training course forms. With that updating the company and training course table
		from the update form will work without issues
		
	$wpdb->update($table_name1, 
		 array('titre' => $updatedgetcompany),
			   array('idsociete' => $getidsociete), 
			   array('%s'),
               array('%d'));
			   
			   **/
	
 ?>
            <div class="updated"><p>Delegate's details updated</p>
            <a class="button" href="<?php echo admin_url('admin.php?page=certificate_builder') ?>">&laquo; Back to Certificates dashboard</a>
            </div>
        <?php }elseif($status == "update") { ?>
			<div class="container">  
  <form id="contact" action="<?php $_SERVER['REQUEST_URI'] ?>" method="post">
    <h3 align ="center">Update Delegate's Credentials</h3>
    <fieldset>
      <input placeholder="Name of Delegate" type="text" name="delegate_name" tabindex="1" value="<?php echo $name; ?>" required autofocus>
    </fieldset>
    <fieldset>
      <input placeholder="Certificate ID" type="text" name="certificate_id" tabindex="2" value="<?php echo $numero; ?>" required>
    </fieldset>
    <fieldset> 
	<select  name="training_course" tabindex="1" required>
	<option disabled selected value="">Please select Course</option>
	<?php
	
	$results = $wpdb->get_results("SELECT titre, idformation FROM wp_formation");
    foreach ($results as $value) {
		?>
            
	<option <?=($value->idformation == $idformation ? 'selected=""' : '')?> value="<?php echo $value->idformation; ?>"><?php echo $value->titre; ?></option>
    <?php } ?>
    </select>
    </fieldset>
    <fieldset>
	<select  name="company"  tabindex="1" required>
	<option disabled selected value="">Please select Company</option>
	
	<?php
	$results = $wpdb->get_results("SELECT titre, idsociete FROM wp_societe");
    foreach ($results as $value) {
       ?>
    <option <?=($value->idsociete == $getidsociete ? 'selected=""' : '')?> value="<?php echo $value->idsociete; ?>"><?php echo $value->titre; ?></option>
    <?php } ?>
    </select>
    </fieldset>
	 <fieldset>
      <input placeholder="Training Start Date" type="text" id="datepicker4" name="startdate" tabindex="4">
    </fieldset>
	<fieldset>
      <input placeholder="Training End Date" type="text" id="datepicker5" name="enddate" tabindex="4">
    </fieldset>
     <fieldset>
      <input placeholder="Date of Issue" type="text" id="datepicker6" name="issuedate" tabindex="4" value="<?php echo $datei; ?>" required>
    </fieldset>
	 <fieldset>
      <input placeholder="Date of Expiration" type="text" id="datepicker7" name="expirationdate" tabindex="4" value="<?php echo $datee; ?>" required>
    </fieldset>
    <fieldset>
      <button name="form_submit" type="submit" id="contact-submit" data-submit="...Sending">Update</button>
    </fieldset>
    
  </form>
</div>
        <?php
		} 		
		}