<?php
add_action('admin_menu', 'cert_page_create');
add_action( 'admin_print_styles', 'dashboard_custom_css' );

function cert_page_create() {
	
	 $page_title = 'Certificates Dashboard';
	 $menu_title = 'Certificates Dashboard';
	 $capability = 'edit_posts';
     $menu_slug = 'certificate_builder';
     $function = 'certificate_display_table';
     $icon_url = '';
     $position = 24;
	 
	 /* could be used later
	 
	 $page_title_certificatesdashboard = 'Certificates Dashboard';
	 $submenu_title_certificatesdashboard = 'Certificates Dashboard';
	 $submenucertificatesdashboard_slug = 'certificates_page';
	 $page_callback__certificatesdashboard = 'certificates_dashboard';
	*/
	
	 $page_title_create_certificate = 'Create Certificate';
	 $submenu_title_create_certificate = 'Create Certificate';
	 $submenucreatecertificate_slug = 'create_certificate';
	 $page_callback__create_certificate = 'create_certificate';
	 
	 $page_title_create_certificate1 = 'Update Certificate';
	 $submenu_title_create_certificate1 = 'Update Certificate';
	 $submenucreatecertificate_slug1 = 'update_certificate';
	 $page_callback__create_certificate1 = 'update_certificateeee';
	 
	  $page_title_create_certificate2 = 'Certificate Preview';
	 $submenu_title_create_certificate2 = 'Certificate Preview';
	 $submenucreatecertificate_slug2 = 'preview_certificate';
	 $page_callback__create_certificate2 = 'preview_certificate';
	
	 add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
  // add_submenu_page( $menu_slug, $page_title_certificatesdashboard, $submenu_title_certificatesdashboard, 'edit_posts', $submenucertificatesdashboard_slug, $page_callback__certificatesdashboard );
	 add_submenu_page( $menu_slug, $page_title_create_certificate, $submenu_title_create_certificate, 'edit_posts', $submenucreatecertificate_slug, $page_callback__create_certificate );
	 //this submenu is HIDDEN, however, we need to add it anyways
	 add_submenu_page(null, $page_title_create_certificate1, $submenu_title_create_certificate1, 'edit_posts', $submenucreatecertificate_slug1, $page_callback__create_certificate1 );
	 add_submenu_page(null, $page_title_create_certificate2, $submenu_title_create_certificate2, 'edit_posts', $submenucreatecertificate_slug2, $page_callback__create_certificate2 );
	
	}
	
  // function to enqueue javascript file to our wordpress system

function dashboard_custom_js(){
	
wp_register_script('search_js_certificate_script', plugins_url('/js/ajax-search.js', __FILE__), array('jquery'),'1.1', true);
wp_register_script('multistep_certificate_script', plugins_url('/js/multistepform.js', __FILE__), array('jquery'),'1.1', true);


 wp_enqueue_script('search_js_certificate_script');
 wp_enqueue_script('multistep_certificate_script');

 wp_localize_script( 'search_js_certificate_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

}
 add_action( 'admin_enqueue_scripts', 'dashboard_custom_js' );
	
function noiaa_admin_scripts() {
  wp_enqueue_script( 'jquery-ui-datepicker' );
}
add_action('admin_enqueue_scripts', 'noiaa_admin_scripts');

// This function registers our style sheet

function dashboard_custom_css(){
	
	wp_register_style( 'certificates_stylesheet3', plugins_url( '/css/bootstrap.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet10', plugins_url( '/css/material-icons.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet6', plugins_url( '/css/font-awesome.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet4', plugins_url( '/css/animate.css' , __FILE__ ) );
	wp_register_style( 'dashboard_stylesheet', plugins_url( '/css/dashboard-form.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet', plugins_url( '/css/certificates-table.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet5', plugins_url( '/css/perfect-scrollbar.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet2', plugins_url( '/css/certificate-main.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet1', plugins_url( '/css/certificate-util.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_tab', plugins_url( '/css/certificate.css' , __FILE__ ) );
	wp_register_style( 'custom-fonts', plugins_url( '/css/fonts.css' , __FILE__ ) );
	wp_register_style( 'remote_font', 'https://fonts.googleapis.com/css?family=Great Vibes' );
	wp_register_style( 'remote_font_titillium', 'https://fonts.googleapis.com/css?family=Titillium Web' );
	wp_register_style( 'certificates_style', plugins_url( '/css/card.css' , __FILE__ ) );

	
	//Register styles for THUET certificate template
	
    wp_register_style( 'certificates_stylesheet_base', plugins_url( '/certificates/thuet/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_fancy', plugins_url( '/certificates/thuet/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_tab3', plugins_url( '/certificates/thuet/css/main.css' , __FILE__ ) );

    
	//Register styles for HUET certificate template
	
	wp_register_style( 'certificates_stylesheet_huet1', plugins_url( '/certificates/huet/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_huet2', plugins_url( '/certificates/huet/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_huet3', plugins_url( '/certificates/huet/css/main.css' , __FILE__ ) );
    
	//Register styles for BOSIET certificate template
	
	wp_register_style( 'certificates_stylesheet_bosiet1', plugins_url( '/certificates/bosiet/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_bosiet2', plugins_url( '/certificates/bosiet/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_bosiet3', plugins_url( '/certificates/bosiet/css/main.css' , __FILE__ ) );
    
	//Register styles for Basic First AID certificate template
	
	wp_register_style( 'certificates_stylesheet_bfa1', plugins_url( '/certificates/bfa/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_bfa2', plugins_url( '/certificates/bfa/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_bfa3', plugins_url( '/certificates/bfa/css/main.css' , __FILE__ ) );
    
	//Register styles for Sea Survival certificate template
	
	wp_register_style( 'certificates_stylesheet_surv1', plugins_url( '/certificates/sea-survival/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_surv2', plugins_url( '/certificates/sea-survival/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_surv3', plugins_url( '/certificates/sea-survival/css/main.css' , __FILE__ ) );
    
	//Register styles for Work at Height certificate template
	
	wp_register_style( 'certificates_stylesheet_wah1', plugins_url( '/certificates/wah/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_wah2', plugins_url( '/certificates/wah/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_wah3', plugins_url( '/certificates/wah/css/main.css' , __FILE__ ) );
    
	//Register styles for Advanced Fire Fighting certificate template
	
	wp_register_style( 'certificates_stylesheet_aff1', plugins_url( '/certificates/aff/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_aff2', plugins_url( '/certificates/aff/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_aff3', plugins_url( '/certificates/aff/css/main.css' , __FILE__ ) );

	//Register styles for Advanced First AID certificate template
	
	wp_register_style( 'certificates_stylesheet_afa1', plugins_url( '/certificates/afa/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_afa2', plugins_url( '/certificates/afa/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_afa3', plugins_url( '/certificates/afa/css/main.css' , __FILE__ ) );

	//Register styles for Basic Fire Fighting certificate template
	
	wp_register_style( 'certificates_stylesheet_bff1', plugins_url( '/certificates/bff/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_bff2', plugins_url( '/certificates/bff/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_bff3', plugins_url( '/certificates/bff/css/main.css' , __FILE__ ) );
    
	//Register styles for BOSSS certificate template
	
	wp_register_style( 'certificates_stylesheet_bosss1', plugins_url( '/certificates/bosss/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_bosss2', plugins_url( '/certificates/bosss/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_bosss3', plugins_url( '/certificates/bosss/css/main.css' , __FILE__ ) );
    
	//Register styles for CSE certificate template
	
	wp_register_style( 'certificates_stylesheet_cse1', plugins_url( '/certificates/cse/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_cse2', plugins_url( '/certificates/cse/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_cse3', plugins_url( '/certificates/cse/css/main.css' , __FILE__ ) );
    	
	//Register styles for Defensive Driving certificate template
	
	wp_register_style( 'certificates_stylesheet_ddc1', plugins_url( '/certificates/ddc/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_ddc2', plugins_url( '/certificates/ddc/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_ddc3', plugins_url( '/certificates/ddc/css/main.css' , __FILE__ ) );
    	
	//Register styles for WARH certificate template
	
	wp_register_style( 'certificates_stylesheet_warh1', plugins_url( '/certificates/warh/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_warh2', plugins_url( '/certificates/warh/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_warh3', plugins_url( '/certificates/warh/css/main.css' , __FILE__ ) );
    	
		//Register styles for CSER certificate template
	
	wp_register_style( 'certificates_stylesheet_cser1', plugins_url( '/certificates/cser/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_cser2', plugins_url( '/certificates/cser/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_cser3', plugins_url( '/certificates/cser/css/main.css' , __FILE__ ) );
 	
			//Register styles for Dangerous goods by sea(IMDG) certificate template
	
	wp_register_style( 'certificates_stylesheet_imdg1', plugins_url( '/certificates/imdg/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_imdg2', plugins_url( '/certificates/imdg/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_imdg3', plugins_url( '/certificates/imdg/css/main.css' , __FILE__ ) );
 	
			//Register styles for Forklift certificate template
	
	wp_register_style( 'certificates_stylesheet_forklift1', plugins_url( '/certificates/forklift/css/base.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_forklift2', plugins_url( '/certificates/forklift/css/fancy.min.css' , __FILE__ ) );
	wp_register_style( 'certificates_stylesheet_forklift3', plugins_url( '/certificates/forklift/css/main.css' , __FILE__ ) );
 	

	
	 if(($_GET["page"] == "certificate_builder")) // this will test if it is the particular settings page to print out the CSS style.
    {
	wp_enqueue_style( 'certificates_stylesheet3');
	wp_enqueue_style( 'certificates_stylesheet10'); 
	wp_enqueue_style( 'certificates_stylesheet6'); 
	wp_enqueue_style( 'certificates_stylesheet4');
	wp_enqueue_style( 'certificates_stylesheet'); 
	wp_enqueue_style( 'certificates_stylesheet5'); 
	wp_enqueue_style( 'certificates_stylesheet2'); 
	wp_enqueue_style( 'certificates_stylesheet1'); 
	wp_enqueue_style( 'certificates_stylesheet_tab'); 
	
	}
	
	 if(($_GET["page"] == "preview_certificate")) // Load custom fonts
    {
		
		wp_enqueue_style( 'custom-fonts');
		wp_enqueue_style( 'remote_font');
		wp_enqueue_style( 'remote_font_titillium');
		wp_enqueue_style( 'certificates_style');
		}
	
	//load 
	
	
	 if(($_GET["page"] == "create_certificate")  || ($_GET["page"] == "update_certificate")) // this will test if it is the particular settings page to print out the CSS style.
    {
	wp_enqueue_style( 'jquery-ui-datepicker-style' , 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css');
	wp_enqueue_style( 'dashboard_stylesheet'); 
	}
	
	
   
	}

// done differently to do some ajax handling
require_once("update_certificate.php");
require_once("preview_certificate.php");
require_once("trainee.php");
require_once("certificates.php");