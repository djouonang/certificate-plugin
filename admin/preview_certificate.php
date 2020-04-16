<?php

function pdfshift($apiKey, $params) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.pdfshift.io/v2/convert/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($params),
        CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
        CURLOPT_USERPWD => $apiKey.':'
    ));

    $response = curl_exec($curl);
    $error = curl_error($curl);
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if (!empty($error)) {
        throw new Exception($error);
    } elseif ($statusCode >= 400) {
        $body = json_decode($response, true);
        if (isset($body['error'])) {
            throw new Exception($body['error']);
        } else {
            throw new Exception($response);
        }
    }

    return $response;
}

// Get form values for use throughout the script

function get_form_values(){
		
global $wpdb;
	
$delegate_name = ucwords(strtolower(trim($_POST['delegate_name'])));
$certificate_id = trim($_POST['certificate_id']);
$training_course = trim($_POST['training_course']);
$company = trim($_POST['company']);
$startdate = trim($_POST['startdate']);
$enddate = trim($_POST['enddate']);
$expirationdate = trim($_POST['expirationdate']);
$course_code = trim($_POST['course_code']);
$city_name = strtoupper(trim($_POST['city_name']));
$country_name = strtoupper(trim($_POST['country_name']));
$continent_name = strtoupper(trim($_POST['continent_name']));

// Get training course name and company name for further processing. Note that the course name and company name are stored in 2 different db tables.


  $table_name1 = $wpdb->prefix . 'societe';
  $table_name2 = $wpdb->prefix . 'formation';
  $result1 = $wpdb->get_row("SELECT * FROM $table_name1 WHERE idsociete = '{$company}' ");
  $result2 = $wpdb->get_row("SELECT * FROM $table_name2 WHERE idformation = '{$training_course}' ");
  $training_course_name = $result2->titre;
  $company_name = $result1->titre;
  
    $form_array = array();   
  
	$form_array = array(

  "delegate_name" => $delegate_name,
  "certificate_id" => $certificate_id,
  "training_course" => $training_course,
  "company" => $company,
  "expirationdate" => $expirationdate, 
  "startdate" => $startdate,
  "enddate" => $enddate,
  "training_course_name" => $training_course_name,
  "company_name" => $company_name,
  "course_code" => $course_code,
  "city_name" => $city_name,
  "country_name" => $country_name,
  "continent_name" => $continent_name,
   );
	return $form_array;
	
}

// calculate expiration date

function expiration_date(){
	
	$a = get_form_values();
    $training_end_date = $a[enddate];   //get the date the training ended
	$training_course_name = $a[training_course_name];
    if(("BASIC FIRST AID" == $training_course_name) || ("SEA SURVIVAL" == $training_course_name) || ("WORK AT HEIGHT" == $training_course_name) || ("ADVANCED FIRE FIGHTING" == $training_course_name) || ("WORK AT HEIGHT" == $training_course_name) || ("ADVANCED FIRE FIGHTING" == $training_course_name) || ("BASIC FIRE FIGHTING" == $training_course_name) || ("ADVANCED FIRST AID" == $training_course_name) || ("BOSSS" == $training_course_name) || ("CONFINED SPACE ENTRY" == $training_course_name) || ("DEFENSIVE DRIVING" == $training_course_name) || ("WORK AND RESCUE AT HEIGHT" == $training_course_name) || ("CONFINED SPACE ENTRY & RESCUE" == $training_course_name) || ("DANGEROUS GOODS BY SEA" == $training_course_name) || ("FORKLIFT" == $training_course_name))
    {	

    $expiration_date = date('d\<\s\u\p\>S\<\/\s\u\p\> F Y', strtotime('+2 years', strtotime($training_end_date)));

	}else{
		
	$expiration_date = date('d\<\s\u\p\>S\<\/\s\u\p\> F Y', strtotime('+4 years', strtotime($training_end_date)));
		
	}
	return $expiration_date;
}

// generate certificate ID


function certificate_id_generator(){
	
	$a = get_form_values();	
	$company_name = str_replace(' ','', $a[company_name]);
	$delegate_name = $a[delegate_name];
	$certificate_id = $a[certificate_id];
    $current_year = date('Y');
    $training_end_date = $a[enddate];
    $enddate_convert =  date("d-m-Y", strtotime($training_end_date));
    $date = str_replace('-', '', $enddate_convert );
    $company_issue = 'NOIAA';
	
	if('INDIVIDUAL' !== $company_name){
	
	// Generate Certificate ID top
		
$certificate_id_top = "Cert. N°&nbsp;{$current_year}/{$company_issue}/{$date}{$course_code}/{$company_name}/{$certificate_id}";
		
	// Generate certificate ID with spaces for barcode font
		
$certificate_id_barcode = "{$current_year}{$company_issue} {$date}{$course_code} {$company_name} {$certificate_id}";

    // Generate certificate ID for database
	
$certificate_id_db = "{$current_year}/{$company_issue}/{$date}{$course_code}/{$company_name}/{$certificate_id}";
	}else{
		
		
	$certificate_id_top = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cert. N° {$current_year}/{$company_issue}/{$date}{$course_code}/{$certificate_id}";
		
	// Generate certificate ID with spaces for barcode font
		
$certificate_id_barcode = "{$current_year}{$company_issue} {$date}{$course_code} {$certificate_id}";

    // Generate certificate ID for database
	
$certificate_id_db = "{$current_year}/{$company_issue}/{$date}{$course_code}/{$certificate_id}";
	
		
	}
$certificate_id_array = array();

$certificate_id_array = array(

  "certificate_id_top" => $certificate_id_top,
  "certificate_id_barcode" => $certificate_id_barcode,
  "certificate_id_db" => $certificate_id_db,
   );
return $certificate_id_array;
}


add_action( 'admin_print_styles', 'custom_css_files' );

// Load css files for the various certificates

function custom_css_files(){
    $a = get_form_values();
    $training_course_name = $a[training_course_name];
	if(($_GET["page"] == "preview_certificate") && ("T-HUET" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_base');
	wp_enqueue_style( 'certificates_stylesheet_fancy'); 
	wp_enqueue_style( 'certificates_stylesheet_tab3'); 
    }elseif(($_GET["page"] == "preview_certificate") && ("HUET" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_huet1');
	wp_enqueue_style( 'certificates_stylesheet_huet2'); 
	wp_enqueue_style( 'certificates_stylesheet_huet3'); 
	
	}elseif(($_GET["page"] == "preview_certificate") && ("BASIC FIRST AID" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_bfa1');
	wp_enqueue_style( 'certificates_stylesheet_bfa2'); 
	wp_enqueue_style( 'certificates_stylesheet_bfa3');
	
	}elseif(($_GET["page"] == "preview_certificate") && ("BOSIET" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_bosiet1');
	wp_enqueue_style( 'certificates_stylesheet_bosiet2'); 
	wp_enqueue_style( 'certificates_stylesheet_bosiet3');
	
	}elseif(($_GET["page"] == "preview_certificate") && ("SEA SURVIVAL" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_surv1');
	wp_enqueue_style( 'certificates_stylesheet_surv2'); 
	wp_enqueue_style( 'certificates_stylesheet_surv3');
	
	}elseif(($_GET["page"] == "preview_certificate") && ("WORK AT HEIGHT" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_wah1');
	wp_enqueue_style( 'certificates_stylesheet_wah2'); 
	wp_enqueue_style( 'certificates_stylesheet_wah3');
	
	}elseif(($_GET["page"] == "preview_certificate") && ("ADVANCED FIRE FIGHTING" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_aff1');
	wp_enqueue_style( 'certificates_stylesheet_aff2'); 
	wp_enqueue_style( 'certificates_stylesheet_aff3');
	
	}elseif(($_GET["page"] == "preview_certificate") && ("ADVANCED FIRST AID" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_afa1');
	wp_enqueue_style( 'certificates_stylesheet_afa2'); 
	wp_enqueue_style( 'certificates_stylesheet_afa3');
	
	}elseif(($_GET["page"] == "preview_certificate") && ("BASIC FIRE FIGHTING" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_bff1');
	wp_enqueue_style( 'certificates_stylesheet_bff2'); 
	wp_enqueue_style( 'certificates_stylesheet_bff3');
	
	}elseif(($_GET["page"] == "preview_certificate") && ("BOSSS" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_bosss1');
	wp_enqueue_style( 'certificates_stylesheet_bosss2'); 
	wp_enqueue_style( 'certificates_stylesheet_bosss3');
	
	}elseif(($_GET["page"] == "preview_certificate") && ("CONFINED SPACE ENTRY" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_cse1');
	wp_enqueue_style( 'certificates_stylesheet_cse2'); 
	wp_enqueue_style( 'certificates_stylesheet_cse3');
	
	}elseif( "DEFENSIVE DRIVING" == $training_course_name)
    {
	wp_enqueue_style( 'certificates_stylesheet_ddc1');
	wp_enqueue_style( 'certificates_stylesheet_ddc2'); 
	wp_enqueue_style( 'certificates_stylesheet_ddc3');
	
	}elseif(($_GET["page"] == "preview_certificate") && ("WORK AND RESCUE AT HEIGHT" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_warh1');
	wp_enqueue_style( 'certificates_stylesheet_warh2'); 
	wp_enqueue_style( 'certificates_stylesheet_warh3');
	
	}elseif(($_GET["page"] == "preview_certificate") && ("CONFINED SPACE ENTRY & RESCUE" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_cser1');
	wp_enqueue_style( 'certificates_stylesheet_cser2'); 
	wp_enqueue_style( 'certificates_stylesheet_cser3');
	
	}elseif(($_GET["page"] == "preview_certificate") && ("DANGEROUS GOODS BY SEA" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_imdg1');
	wp_enqueue_style( 'certificates_stylesheet_imdg2'); 
	wp_enqueue_style( 'certificates_stylesheet_imdg3');
	
	}elseif(($_GET["page"] == "preview_certificate") && ("FORKLIFT" == $training_course_name))
    {
	wp_enqueue_style( 'certificates_stylesheet_forklift1');
	wp_enqueue_style( 'certificates_stylesheet_forklift2'); 
	wp_enqueue_style( 'certificates_stylesheet_forklift3');
	
	}

	
}

//Get training period

function training_period(){
	
	$a = get_form_values(); 
	$training_start_date = date("d F Y", strtotime($a[startdate]));
	$training_end_date = date("d F Y", strtotime($a[enddate]));
	// $training_start_datefinal = date("d\<\s\u\p\>S\<\/\s\u\p\> F Y", strtotime($a[startdate])); // add superscript english ordinal suffix
	$training_start_datefinal = date("d F Y", strtotime($a[startdate])); // add superscript english ordinal suffix
	// $training_end_datefinal = date("d\<\s\u\p\>S\<\/\s\u\p\> F Y", strtotime($a[enddate]));	 // add superscript english ordinal suffix
	$training_end_datefinal = date("d F Y", strtotime($a[enddate]));	 // add superscript english ordinal suffix
	$startdate_month =  date("F", strtotime($training_start_date));
	// $training_start_datefinali = date("d\<\s\u\p\>S\<\/\s\u\p\> M Y", strtotime($a[startdate])); // add superscript english ordinal suffix
	$training_start_datefinali = date("d M Y", strtotime($a[startdate])); // add superscript english ordinal suffix
	// $training_end_datefinali = date("d\<\s\u\p\>S\<\/\s\u\p\> M Y", strtotime($a[enddate]));	 // add superscript english ordinal suffix
	$training_end_datefinali = date("d M Y", strtotime($a[enddate]));	 // add superscript english ordinal suffix
	$startdate_month =  date("F", strtotime($training_start_date));
	$enddate_month =  date("F", strtotime($training_end_date));
	$year_and_month =  date("F Y", strtotime($training_end_date));
	// $startdate_day =  date("d\<\s\u\p\>S\<\/\s\u\p\>", strtotime($training_start_date));
	$startdate_day =  date("d", strtotime($training_start_date));
	// $enddate_day =  date("d\<\s\u\p\>S\<\/\s\u\p\>", strtotime($training_end_date));
	$enddate_day =  date("d", strtotime($training_end_date));

	if(($training_start_date == $training_end_date))
    {
		
	$str = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Held on the&nbsp;{$training_end_datefinal}";
	
	}elseif(($training_start_date !== $training_end_date) && ($startdate_month !== $enddate_month))
    {

     $str = "Held from the&nbsp;{$training_start_datefinali}&nbsp;to&nbsp;{$training_end_datefinali}";	
	
	
	}elseif(($training_start_date !== $training_end_date) && ($startdate_month == $enddate_month))
    {

     $str = "Held from the&nbsp;{$startdate_day}&nbsp;-&nbsp;{$enddate_day}&nbsp;{$year_and_month}";	
	
	}
	
	return $str;
}

// generate QR code

function generate_qr_code(){
	
    $page = get_page_by_title('search certificates');
    $page_url = get_permalink($page->ID);
	$a = get_form_values();
	$delegate_name = $a[delegate_name];
	$delegate_name = str_replace(' ', '+', $delegate_name );
	$c = certificate_id_generator();
	$certificate_code = $c[certificate_id_db];
	$certificate_code = str_replace('/', '%2F', $certificate_code );
	$arg = array(
	 'trainee_title' => $delegate_name,
     'cert_title' => $certificate_code,
	 'submit' => 'verify'
	);
	
	$add_arg = esc_url(add_query_arg( $arg, $page_url ));
	
	include("qrcode.php");
    
    $qr = new qrcode();
    $qr->text($add_arg);
    $html = $qr->get_link();
	$content .= $html;

	return $content;
   
}


// abbreviate last name

function abbreviatelastname($name) {
    $names = explode(' ', $name);
    $last_name = array_pop($names);
    $last_initial = $last_name[0];
    return implode(' ', $names).' '.$last_initial.'.';
}

// generate certificate


require_once 'dompdf/autoload.inc.php';

require_once 'dompdf/lib/html5lib/Parser.php';
require_once 'dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
require_once 'dompdf/lib/php-svg-lib/src/autoload.php';
require_once 'dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();

 use Dompdf\Dompdf;

function generate_certificate($training_course_name,$card_delegate_name, $cert_variables)
{
	
	
global $dompdf;

// instantiate and use the dompdf class
 
$dompdf = new Dompdf(array('enable_remote' => true));


extract($cert_variables);

  if(("T-HUET" == $training_course_name))
    {

    include "certificates/thuet/thuet-buffer.php";
  
    }elseif(("HUET" == $training_course_name))
    {

	include "certificates/huet/huet-buffer.php";
	
	}elseif(("BASIC FIRST AID" == $training_course_name))
    {

   include "certificates/bfa/bfa-buffer.php";
	
	}elseif(("BOSIET" == $training_course_name))
    {

    include "certificates/bosiet/bosiet-buffer.php";
	
	}elseif(("SEA SURVIVAL" == $training_course_name))
    {

   include "certificates/sea-survival/seasurvival-buffer.php";
  
	
	}elseif(("WORK AT HEIGHT" == $training_course_name))
    {

     include "certificates/wah/wah-buffer.php";
	
	}elseif(("ADVANCED FIRE FIGHTING" == $training_course_name))
    {

     include "certificates/aff/aff-buffer.php";
	
	}elseif(("ADVANCED FIRST AID" == $training_course_name))
    {

     include "certificates/afa/afa-buffer.php";
	
	}elseif(("BASIC FIRE FIGHTING" == $training_course_name))
    {

     include "certificates/bff/bff-buffer.php";
	
	}elseif(("BOSSS" == $training_course_name))
    {

     include "certificates/bosss/bosss-buffer.php";
	
	}elseif(("CONFINED SPACE ENTRY" == $training_course_name))
    {

  	 include "certificates/cse/cse-buffer.php";
	
	}elseif(("DEFENSIVE DRIVING" == $training_course_name))
    {
		
	 include "certificates/ddc/ddc-buffer.php";
	
	}elseif(("WORK AND RESCUE AT HEIGHT" == $training_course_name))
    {

   include "certificates/warh/warh-buffer.php";
  
	
	}elseif(("CONFINED SPACE ENTRY & RESCUE" == $training_course_name))
    {

  include "certificates/cser/cser-buffer.php";
	
	}elseif(("DANGEROUS GOODS BY SEA" == $training_course_name))
    {

   include "certificates/imdg/imdg-buffer.php";
	
	}elseif(("FORKLIFT" == $training_course_name))
    {

   include "certificates/forklift/forklift-buffer.php";
	
	}
	
	$dompdf->set_option('isHtml5ParserEnabled', true);

$dompdf->loadHtml($certificate_preview);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
ob_end_clean();
echo $dompdf->stream($card_delegate_name, array("Attachment" => true));
}

//generate success card_delegate_name

function generate_card($training_course_name,$card_delegate_name, $cert_variables){
	
global $dompdf;

$dompdf = new Dompdf(array('enable_remote' => true));


extract($cert_variables);

if(("T-HUET" == $training_course_name))
    {

    include "cards/thuet/thuetcard-buffer.php";
  
    }elseif(("HUET" == $training_course_name))
    {

	include "cards/huet/huetcard-buffer.php";
	
	}elseif(("DEFENSIVE DRIVING" == $training_course_name))
    {
		
	include "cards/ddc/ddcard-buffer.php";
	
	}elseif(("BOSIET" == $training_course_name))
    {

    include "cards/bosiet/bosietcard-buffer.php";
	
	}elseif(("SEA SURVIVAL" == $training_course_name))
    {

   include "cards/sea-survival/seasurvivalcard-buffer.php";
  
	
	}elseif(("BOSSS" == $training_course_name))
    {

     include "cards/bosss/bossscard-buffer.php";

	
	}elseif(("DANGEROUS GOODS BY SEA" == $training_course_name))
    {

     include "cards/imdg/imdgcard-buffer.php";
	
	}

$dompdf->set_option('isHtml5ParserEnabled', true);

$dompdf->loadHtml($card_preview);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
ob_end_clean();
echo $dompdf->stream($card_delegate_name, array("Attachment" => true));
}

// certificate preview

function preview_certificate(){
	
	
	// Upload image into media library and generate image urldecode
	
	require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php'); 

if($_FILES['trainee_image']['name']) {
  if(!$_FILES['trainee_image']['error']) {
	  
    //validate the file
	
    $new_file_name = strtolower($_FILES['trainee_image']['tmp_name']);
	
    //can't be larger than 200 KB 
    if($_FILES['trainee_image']['size'] > (200000)) {
      //wp_die generates a visually appealing message element
      wp_die('Your file size is to large.');
    }
    else {
      //the file has passed the test
      //These files need to be included as dependencies when on the front end.
      require_once( ABSPATH . 'wp-admin/includes/image.php' );
      require_once( ABSPATH . 'wp-admin/includes/file.php' );
      require_once( ABSPATH . 'wp-admin/includes/media.php' );
       
      // Let WordPress handle the upload.
      // Remember, 'upload' is the name of our file input in our form above.
      $file_id = media_handle_upload( 'trainee_image', 0 );
	  $attachment_url = wp_get_attachment_url($file_id);
    
      if( is_wp_error( $file_id ) ) {
         wp_die('Error loading file!');
      } 
    }
  }
  else{
    //set that to be the returned message
    wp_die('Error: '.$_FILES['trainee_image']['error']);
  }
}
	
	
	?>
	 <h3 align ="center">Certificate Preview</h3>
	 <br>
	 <span align ="center">The delegate's details has been recorded and will be used to generate its certificate...</span>
   
   <br>
   <br>

<script>
try{
theViewer.defaultViewer = new theViewer.Viewer({});
}catch(e){}
</script>

<?php
    global $wpdb;
	
  	$a = get_form_values();
	$card_delegate_name = $a[delegate_name];
  	$expirationdate = expiration_date();
    $c = certificate_id_generator();
	$certificate_id_top = $c[certificate_id_top];
	$certificate_id_barcode = $c[certificate_id_barcode];
    $training_course_name = $a[training_course_name];
	$training_period = training_period();
	
	//insert record to database
	
     $table_name = $wpdb->prefix . 'certificat';
     $wpdb->insert( $table_name, array(
     'nom' => $a[delegate_name],
     'numero' => $c[certificate_id_db],
	 'idformation' => $a[training_course],
	 'idsociete' => $a[company],
	 'date_formation' => $a[enddate],
	 'date_expiration' => $expirationdate,
	 'profile' => $attachment_url	
 ) );


	if((strlen($a[delegate_name]) > 15 )){
	
	// abbreviate last name if it exceeds 15 characters
	
	$name = abbreviatelastname($a[delegate_name]);
	$card_delegate_name = $name;
	$delegate_name = '&nbsp;&nbsp'.$name;
	
	}elseif((strlen($a[delegate_name]) <= 15 ) && (strlen($a[delegate_name]) >= 13 ) ){
	
	$delegate_name = '&nbsp'.$a[delegate_name];
	}elseif((strlen($a[delegate_name]) < 13 ) && (strlen($a[delegate_name]) >= 10 ))
    {
	$delegate_name = '&nbsp;&nbsp;&nbsp;'.$a[delegate_name];
		}elseif( (strlen($a[delegate_name]) < 10 ))
    {
	$delegate_name = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$a[delegate_name];
		}
	
	$city_name = $a[city_name];
	$country_name = $a[country_name];
	$continent_name = $a[continent_name];
    $venue = "{$city_name},  {$country_name} - {$continent_name}";
	$qrcode =  generate_qr_code();
	
	// Certficate variables
	$cert_variables = [];
	$cert_variables['certificate_id_top'] = $certificate_id_top;
	$cert_variables['training_period'] = $training_period;
	$cert_variables['venue'] = $venue;
	$cert_variables['attachment_url'] = $attachment_url;
	$cert_variables['delegate_name'] = $delegate_name;
	$cert_variables['expirationdate'] = $expirationdate;
	$cert_variables['certificate_id_barcode'] = $certificate_id_barcode;
	$cert_variables['qrcode'] = $qrcode;

	
  if(("T-HUET" == $training_course_name))
    {
				
  $certificate_preview = require_once("certificates/thuet/thuet.php");
  $gadget = require_once("cards/thuet/thuetcard.php");
  
    }elseif(("HUET" == $training_course_name))
    {

    $certificate_preview = require_once("certificates/huet/huet.php");
	$gadget = require_once("cards/huet/huetcard.php");
	}elseif(("BASIC FIRST AID" == $training_course_name))
    {

  $certificate_preview = require_once("certificates/bfa/bfa.php");
	
	}elseif(("BOSIET" == $training_course_name))
    {

  $certificate_preview = require_once("certificates/bosiet/bosiet.php");
  $gadget = require_once("cards/bosiet/bosietcard.php");
	
	}elseif(("SEA SURVIVAL" == $training_course_name))
    {

  $certificate_preview = require_once("certificates/sea-survival/seasurvival.php");
  $gadget = require_once("cards/ss/seasurvivalcard.php");
	
	}elseif(("WORK AT HEIGHT" == $training_course_name))
    {

  $certificate_preview = require_once("certificates/wah/wah.php");
	
	}elseif(("ADVANCED FIRE FIGHTING" == $training_course_name))
    {

  $certificate_preview = require_once("certificates/aff/aff.php");
	
	}elseif(("ADVANCED FIRST AID" == $training_course_name))
    {

  $certificate_preview = require_once("certificates/afa/afa.php");
	
	}elseif(("BASIC FIRE FIGHTING" == $training_course_name))
    {

  $certificate_preview = require_once("certificates/bff/bff.php");
	
	}elseif(("BOSSS" == $training_course_name))
    {

  $certificate_preview = require_once("certificates/bosss/bosss.php");
  $gadget = require_once("cards/bosss/bossscard.php");
	
	}elseif(("CONFINED SPACE ENTRY" == $training_course_name))
    {

  $certificate_preview = require_once("certificates/cse/cse.php");
	
	}elseif(("DEFENSIVE DRIVING" == $training_course_name))
    {
		
	$certificate_preview = require_once("certificates/ddc/ddc.php");
	
     $gadget = require_once("cards/ddc/ddcard.php"); 
	
	}elseif(("WORK AND RESCUE AT HEIGHT" == $training_course_name))
    {

  $certificate_preview = require_once("certificates/warh/warh.php");
  
	
	}elseif(("CONFINED SPACE ENTRY & RESCUE" == $training_course_name))
    {

  $certificate_preview = require_once("certificates/cser/cser.php");
	
	}elseif(("DANGEROUS GOODS BY SEA" == $training_course_name))
    {

  $certificate_preview = require_once("certificates/imdg/imdg.php");
  $gadget = require_once("cards/imdg/imdgcard.php");
	
	}elseif(("FORKLIFT" == $training_course_name))
    {

  $certificate_preview = require_once("certificates/forklift/forklift.php");
	
	}
	
	?>
	
	<form method="post">
	<div class="button_cont" align="center">
    <input type="submit" name="press" id="press" value="Download" />
	<input type='hidden' name='delegate_name' value='<?php echo $card_delegate_name; ?>' />
	<input type='hidden' name='certificate' value='<?php echo $training_course_name; ?>' /> 
	<input type="hidden" name="action" value="certificate-sheet" />
	<?php foreach ($cert_variables as $k => $v) { ?>
	<input type="hidden" name="cert_variables[<?php echo $k; ?>]" value="<?php echo $v; ?>" />
	<?php } ?>
	
	
	</div>
    </form>
	
    
 <div id="myCanva" >
         <h2 class="my-medium"> Where does it come from?</h2>
      </div>
	  


	<?php
	
	
	 if(("T-HUET" == $training_course_name) || ("SEA SURVIVAL" == $training_course_name) || ("HUET" == $training_course_name) || ("DEFENSIVE DRIVING" == $training_course_name) || ("BOSIET" == $training_course_name) || ("BOSSS" == $training_course_name) || ("DANGEROUS GOODS BY SEA" == $training_course_name))
    {  ?>	

    <form method="post">
	<div class="button_cont" align="center">
    <input type="submit" name="card" id="card" value="Download Card" />
	<input type='hidden' name='delegate_name' value='<?php echo $card_delegate_name; ?>' />
	<input type='hidden' name='certificate' value='<?php echo $training_course_name; ?>' /> 
	<input type="hidden" name="action" value="certificate-sheet" />
	<?php foreach ($cert_variables as $k => $v) { ?>
	<input type="hidden" name="cert_variables[<?php echo $k; ?>]" value="<?php echo $v; ?>" />
	<?php } ?>
	
	
	</div>
    </form>


	<?php
}


	
	if(array_key_exists('press', $_POST)){
    $var = $_POST['delegate_name'];
	$certificate = $_POST['certificate'];
	$cert_variables = $_POST['cert_variables'];
    generate_certificate($certificate,$var,$cert_variables);
   }
   
   if(array_key_exists('card', $_POST)){
	$var = $_POST['delegate_name'];
	$certificate = $_POST['certificate'];
	$cert_variables = $_POST['cert_variables'];
    generate_card($certificate,$var,$cert_variables);   

   }
}
?>