<?php
function certificate_display_table(){
  	   if(isset($_POST['search-box']) ){
	   global $wpdb;
	   $searchvalue = htmlspecialchars($_POST['search-box']);
	   $table_certificate = $wpdb->prefix . 'certificat';
	   $customPaged     = "";
	   $db_query        = "SELECT * FROM $table_certificate WHERE nom LIKE '%{$searchvalue}%'";
	   $total_certificate_query     = "SELECT COUNT(1) FROM (${db_query}) AS combined_table";
	   $total             = $wpdb->get_var( $total_certificate_query );
	   $items_per_page = 10;
	   $page             = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
	   $offset         = ( $page * $items_per_page ) - $items_per_page;
       $result         = $wpdb->get_results( $db_query."  LIMIT ${offset}, ${items_per_page}" );
	   $totalPage         = ceil($total / $items_per_page);
					
?>


<div class="limiter">
		<div class="container-table100">
		<h1 style ="color:white;text-align:center;">Certificates</h1>
			<div class="wrap-table100">
			<div class="header-column-box">
			<h3 style ="color:white;text-align:center;">Trainee's  <b>Details</b></h3>
			</div>
			
			<div class="search-box">
			<form  action="<?php $_SERVER['REQUEST_URI'] ?>" method="post" id="searchindiv">
			
                            <input  type="text" class="form-control" name="search-box" placeholder="Search&hellip;"/>
							<input type="hidden" name="action" value="searchindividual"/>
			  <button type="submit" class="btn-search" >
                <i class="material-icons">&#xE8B6;</i>
              </button>
              </form>
                 
			  
                        </div>
				<div class="table100 ver1 m-b-110">
				
						<div class="table100 ver3 m-b-110">
						
					<table data-vertable="ver3">
						<thead>
							<tr class="row100 head">
								<th class="column100 column1" data-column="column1"><b><span style="font-family: Roboto;">Name</span></b></th>
								<th class="column100 column2" data-column="column2"><b><span style="font-family: Roboto;">Training Course</span></b></th>
								<th class="column100 column3" data-column="column3"><b><span style="font-family: Roboto;">Certificate ID</span></b></th>
								<th class="column100 column4" data-column="column4"><b><span style="font-family: Roboto;">Company</span></b></th>
								<th class="column100 column5" data-column="column5"><b><span style="font-family: Roboto;">Expiration Date</span></b></th>
								<th class="column100 column6" data-column="column6"><b><span style="font-family: Roboto;">Actions</span></b></th>
							</tr>
						</thead>
						<tbody>
						<?php
				
					    if(!empty($result)){
						
	                    foreach($result as $query){
		                global $wpdb;
		                $getcompany = $query->idsociete;
		                $getcourse = $query->idformation;
		                $table_name1 = $wpdb->prefix . 'societe';
		                $table_name2 = $wpdb->prefix . 'formation';
		                $result1 = $wpdb->get_row("SELECT * FROM $table_name1 WHERE idsociete = '{$getcompany}' ");
		                $result2 = $wpdb->get_row("SELECT * FROM $table_name2 WHERE idformation = '{$getcourse}' ");

						
						?>
							<tr class="row100">
								<td class="column100 column1" data-column="column1"><span style="font-family: Roboto;"><?php echo $query->nom; ?></span></td>
								<td class="column100 column2" data-column="column2"><span style="font-family: Roboto;"><?php echo $result2->titre; ?></span></td>
								<td class="column100 column3" data-column="column3"><span style="font-family: Roboto;"><?php echo $query->numero; ?></span></td>
								<td class="column100 column4" data-column="column4"><span style="font-family: Roboto;"><?php echo $result1->titre; ?></span></td>
								<td class="column100 column5" data-column="column5"><button type="button" class="btn btn-danger btn-sm btn-block"><?php echo $query->date_expiration; ?></button></td>
								<td class="column100 column6" data-column="column6">
								<a href="<?php echo admin_url('admin.php?page=preview_certificate&id=' . $query->idcertificat.'&status=preview'); ?>" class="view" title="View" data-toggle="tooltip" ><i class="material-icons">&#xE417;</i></a>
                                <a href="<?php echo admin_url('admin.php?page=update_certificate&id=' . $query->idcertificat.'&status=update'); ?>" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                <a href="<?php echo admin_url('admin.php?page=update_certificate&id=' . $query->idcertificat.'&status=delete'); ?>" onclick="return confirm('Are you sure you want to delete?')" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
								
								</td>
							</tr>
                         <?php 

                        }
						}elseif(empty($result)){	
						?>
						<tr class="row100">
								<td class="column100 column1" data-column="column1"><span style="font-family: Roboto;">No results found...</span></td>
							
								
								</td>
							</tr>
							<?php 

                        }
						?>
						</tbody>
					</table>
				</div>		
</div>
 <?php

   if($totalPage > 1){
   $paginate = paginate_links( array(
   'base' => add_query_arg( 'cpage', '%#%' ),
   'format' => '',
   'prev_text' => __('&laquo;'),
   'next_text' => __('&raquo;'),
   'total' => $totalPage,
   'current' => $page
    ));
   }
  $customPaged      =  '<div class="hint-text"><span style="color:white; font-family:Roboto;">Showing Page <b>'.$page.'</b> out of <b>'.$totalPage.'</b> Pages</span></div>';
   ?>
<div class="clearfix">
                <?php if($totalPage > 1){  echo $customPaged;  } ?>
                <ul class="pagination">
				<?php 
                   echo '<li class="page-item disabled">'. $paginate .'</li>';
					?>
                </ul>
            </div>
</div>
</div>
</div>
<?php
}elseif(!isset($_POST['search-box']) || empty($_POST['search-box']) ){
	
	// changes characters used in html to their equivalents, for example: < to &gt;
   global $wpdb;
   $table_certificate = $wpdb->prefix . 'certificat';
   $customPaged     = "";
   $db_query        = "SELECT * FROM $table_certificate";
   $total_certificate_query     = "SELECT COUNT(1) FROM (${db_query}) AS combined_table";
   $total             = $wpdb->get_var( $total_certificate_query );
   $items_per_page = 10;
   $page             = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
   $offset         = ( $page * $items_per_page ) - $items_per_page;
   $result         = $wpdb->get_results( $db_query."  LIMIT ${offset}, ${items_per_page}" );
   $result21         = $wpdb->get_results( $db_query );
   $totalPage         = ceil($total / $items_per_page);
   ?>

<div class="limiter">
		<div class="container-table100">
		<h1 style ="color:white;text-align:center;">Certificates</h1>
			<div class="wrap-table100">
			<div class="header-column-box">
			<h3 style ="color:white;text-align:center;">Trainee's  <b>Details</b></h3>
			</div>
			
			<div class="search-box">
			<form  action="<?php $_SERVER['REQUEST_URI'] ?>" method="post" id="searchindiv">
			
                            <input  type="text" class="form-control" name="search-box" placeholder="Search&hellip;"/>
							<input type="hidden" name="action" value="searchindividual"/>
			  <button type="submit" class="btn-search" >
                <i class="material-icons">&#xE8B6;</i>
              </button>
              </form>
                        </div>
				<div class="table100 ver1 m-b-110">
				
						<div class="table100 ver3 m-b-110">
						
					<table data-vertable="ver3">
						<thead>
							<tr class="row100 head">
								<th class="column100 column1" data-column="column1"><b><span style="font-family: Roboto;">Name</span></b></th>
								<th class="column100 column2" data-column="column2"><b><span style="font-family: Roboto;">Training Course</span></b></th>
								<th class="column100 column3" data-column="column3"><b><span style="font-family: Roboto;">Certificate ID</span></b></th>
								<th class="column100 column4" data-column="column4"><b><span style="font-family: Roboto;">Company</span></b></th>
								<th class="column100 column5" data-column="column5"><b><span style="font-family: Roboto;">Expiration Date</span></b></th>
								<th class="column100 column6" data-column="column6"><b><span style="font-family: Roboto;">Actions</span></b></th>
							</tr>
						</thead>
						<tbody>
						
						<?php
						
	                    foreach($result as $query){
		                global $wpdb;
		                $getcompany = $query->idsociete;
		                $getcourse = $query->idformation;
		                $table_name1 = $wpdb->prefix . 'societe';
		                $table_name2 = $wpdb->prefix . 'formation';
		                $result1 = $wpdb->get_row("SELECT * FROM $table_name1 WHERE idsociete = '{$getcompany}' ");
		                $result2 = $wpdb->get_row("SELECT * FROM $table_name2 WHERE idformation = '{$getcourse}' ");

						
						?>
						
							<tr class="row100">
								<td class="column100 column1" data-column="column1"><span style="font-family: Roboto;"><?php echo $query->nom; ?></span></td>
								<td class="column100 column2" data-column="column2"><span style="font-family: Roboto;"><?php echo $result2->titre; ?></span></td>
								<td class="column100 column3" data-column="column3"><span style="font-family: Roboto;"><?php echo $query->numero; ?></span></td>
								<td class="column100 column4" data-column="column4"><span style="font-family: Roboto;"><?php echo $result1->titre; ?></span></td>
								<td class="column100 column5" data-column="column5"><button type="button" class="btn btn-danger btn-sm btn-block"><?php echo $query->date_expiration; ?></button></td>
								<td class="column100 column6" data-column="column6">
								<a href="<?php echo admin_url('admin.php?page=preview_certificate&id=' . $query->idcertificat.'&status=preview'); ?>" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
                                <a href="<?php echo admin_url('admin.php?page=update_certificate&id=' . $query->idcertificat.'&status=update'); ?>" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                <a href="<?php echo admin_url('admin.php?page=update_certificate&id=' . $query->idcertificat.'&status=delete'); ?>"  onclick="return confirm('Are you sure you want to delete?')" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
								
								</td>
							</tr>
                         <?php 

                        }
						?>
						</tbody>
					</table>
				</div>		
</div>
 <?php

   if($totalPage > 1){
   $paginate = paginate_links( array(
   'base' => add_query_arg( 'cpage', '%#%' ),
   'format' => '',
   'prev_text' => __('&laquo;'),
   'next_text' => __('&raquo;'),
   'total' => $totalPage,
   'current' => $page
    ));
   }
  $customPaged      =  '<div class="hint-text"><span style="color:white; font-family:Roboto;">Showing Page <b>'.$page.'</b> out of <b>'.$totalPage.'</b> Pages</span></div>';
   ?>
<div>
                <?php  echo $customPaged; ?>
                <ul class="pagination">
				<?php 
                   echo '<li class="page-item disabled">'. $paginate .'</li>';
					?>
                </ul>
            </div>
</div>
</div>
</div>
<?php
  }
   }