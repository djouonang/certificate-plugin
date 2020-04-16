<?php
function create_certificate(){

?>

  <div class="container">  
  <form id="contact"  action="<?php  echo admin_url('admin.php?page=preview_certificate');  ?>" onsubmit="return validateForm()"  method="post" enctype="multipart/form-data">
    <h3>Delegates' Credentials</h3>
  <!-- One "tab" for each step in the form: -->
  <div class="tab"><h4>Personal Info:</h4>
    <p><input placeholder="Name of Delegate" oninput="this.className = ''"  name="delegate_name" value="<?php echo $_POST['delegate_name']; ?>" required autofocus></p>
    <p><input placeholder="Certificate ID(Ex: D01,D02...)" oninput="this.className = ''" name="certificate_id" value="<?php echo $_POST['certificate_id']; ?>" required autofocus></p>
	<p><select oninput="this.className = ''"  name="company" value="<?php echo $_POST['company']; ?>" ></p>
	<option disabled selected value="">Please select Company(Don't choose any if N/A)</option>
	<?php
	
	global $wpdb;
	$results = $wpdb->get_results("SELECT titre, idsociete FROM wp_societe");
    foreach ($results as $value) {
    echo '<option value="' .$value->idsociete . '">' .$value->titre. '</option>';
    }
    ?>
    </select>
  </div>
    <div class="tab">Course Details:
	<p><select oninput="this.className = ''"  name="training_course" value="<?php echo $_POST['training_course']; ?>" required autofocus></p>
	<option disabled selected value="">Please select Course</option>
	<?php
	
	global $wpdb;
	$results = $wpdb->get_results("SELECT titre, idformation FROM wp_formation");
    foreach ($results as $value) {
            echo '<option value="' .$value->idformation . '">' .$value->titre. '</option>';
    }
    ?>
    </select>
	<p><select oninput="this.className = ''"  name="course_code" value="<?php echo $_POST['course_code']; ?>" required autofocus></p>
	<option disabled selected value="">Select Course Code</option>
	<option value="BOSIET">BOSIET</option>
	<option value="HUET">HUET</option>
	<option value="BFA">BFA</option>
	<option value="AFA">AFA</option>
	<option value="DDC">DDC</option>
	<option value="BFF">BFF</option>
	<option value="AFF">AFF</option>
	<option value="SEASURVIVAL">SEASURVIVAL</option>
	<option value="THUET">THUET</option>
	<option value="BOSSS">BOSSS</option>
	<option value="WAH">WAH</option>	
    <option value="WARH">WARH</option>
    <option value="CSE">CSE</option>
    <option value="CSER">CSER</option>
	<option value="FORKLIFT">FORKLIFT</option>
	<option value="MEWP">MEWP</option>
	<option value="MEWP">IMDG</option>
    </select>
  </div>
  <div class="tab"><h4>Training Details:</h4>
    <p><input placeholder="Training Start Date" oninput="this.className = ''" id="datepicker2" name="startdate" value="<?php echo $_POST['startdate']; ?>" required autofocus></p>
    <p><input placeholder="Training End Date" oninput="this.className = ''" id="datepicker3" name="enddate" value="<?php echo $_POST['enddate']; ?>" required autofocus></p>
	<p><input placeholder="Venue - City" oninput="this.className = ''" name="city_name" value="<?php echo $_POST['city_name']; ?>" required autofocus></p>
    <p><input placeholder="Venue - Country" oninput="this.className = ''" name="country_name" value="<?php echo $_POST['country_name']; ?>" required autofocus></p>
	<p><input placeholder="Venue - Continent" oninput="this.className = ''" name="continent_name" value="<?php echo $_POST['continent_name']; ?>" required autofocus></p>
  </div>

  <div class="tab"><h4>Upload trainee's image:</h4>
    <p><input type="file"  oninput="this.className = ''" name="trainee_image" value="<?php echo $_POST['trainee_image']; ?>" accept="image/*" required autofocus></p>
  </div>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
	<span class="step"></span>
  </div>
  </form>
</div>
<?php
}