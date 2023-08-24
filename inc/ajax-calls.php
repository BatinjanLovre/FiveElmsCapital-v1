<?php
/**
 *
 * @package WordPress 
 * @subpackage wp_starter
 * Custom ajax calss
 *
**/

add_action('wp_ajax_get_tax_thumb', 'get_tax_thumb');
function get_tax_thumb()
{
	
}

add_action('wp_ajax_send_contact_email', 'send_contact_email');
add_action('wp_ajax_nopriv_send_contact_email', 'send_contact_email');
function send_contact_email()
{
	//wp_mail( 'lukasavic2@gmail.com', 'Poruka sa FED web stranica', 'mdaaaaaaj' );
	$first_name  = $_POST['first_name'];
	$email 		 = $_POST['email' ];
	$tel 		 = $_POST['tel'] ;
	$apartment 	 = $_POST['apartment' ];
	$arival_date = $_POST['arival_date'];
	$days 		 = $_POST['days'];
	$persons 	= $_POST['persons'];
	$message 	 = $_POST['msg'] ;

	//'client_name', 'client_telephone', 'client_address', 'client_email', 'client_msg'
	$errors = array();
	$req_fields = array( 'first_name');

	foreach( $req_fields as $field ) {
		if( !isset( $_POST[ $field ] ) || trim($_POST[ $field ]) == ""  ) {
			$errors[] = $field; 
		}
	}

	if( !empty($errors) ) {
		echo '<p class="report-msg error">' . __('An error occurred when sending email. Try a little later.') . '</p>';
		print_r( $errors );
		die();
	}

	//$mailto = get_option( 'admin_email' );
	$apartment = get_post( $apartment );
	$apartment_name = $apartment->post_title;

	$mailto = 'lukasavic2@gmail.com';
	$msg ="";
	$msg  .= 'Name: ' . $first_name . "<br/>";
	$msg  .= 'Email: ' . $email . "<br/>";
	$msg  .= 'Phone: ' . $tel . "<br/>";
	$msg  .= 'apartment: ' . $apartment_name . "<br/>";
	$msg  .= 'Arrival date: ' . $arival_date . "<br/>";
	$msg  .= 'Days : ' . $days . "<br/>";
	$msg  .= 'Number of people : ' . $persons . "<br/>";
	$msg  .= $message . "<br/>";

	$headers = "From: {$email}" . "\r\n";
	//wp_mail( 'lukasavic2@gmail.com', 'The subject', 'Text text text text' );
	if( wp_mail( $mailto, $subject, $msg, $headers ) ) {
		//wp_mail( 'lukasavic2@gmail.com', 'Fed Mail', $msg );
		echo '<p class="report-msg success">'. __('Your message has been successfully sent.').'</p>';
	} else {
		echo '<p class="report-msg error">' . __('An error occurred when sending email. Try a little later.') . '</p>';
	}
	die();
}


// Clients Ajax calls
add_action('wp_ajax_send_realization_contact', 'send_realization_contact');
add_action('wp_ajax_nopriv_send_realization_contact', 'send_realization_contact');
function send_realization_contact() 
{	
	$name 		= $_POST['name'];
	$surname 	= $_POST['surname'];
	$company 	= $_POST['company'];
	$email 		= $_POST['email'];
	$message 	= $_POST['msg'];
	$have_files = $_POST['have_files'];

	$error_message 	 = '<p class="report-msg error"> Došlo je do pogreške prilikom slanja. Pokušajte malo kanije.</p>';
	$success_message = '<p class="report-msg success"> Vaša poruka uspješno je poslana. Odgovorit ćemo Vam u najkraćem roku. </p>';
	$have_files_return =  ( isset( $have_files )|| trim( $have_files ) != "" ) ? 'no' : 'yes';

	$errors = array();
	$req_fields = array( 'name', 'surname', 'company', 'email' );
	foreach( $req_fields as $field ) {
		if( !isset( $_POST[ $field ] ) || trim($_POST[ $field ]) == ""  ) {
			$errors[] = $field; 
		}
	}

	if( !empty($errors) ) {
		$return = array( 'message' => $error_message, 'success' => 'no' );
		echo json_encode( $return );
		die();
	} else {
		$post_data = array(
			'post_title' 	=> 'Client ' . $name . ' ' . $surname,
			'post_excerpt' 	=> $message,
			'post_status'	=> 'publish',
			'post_type'		=> 'client',
			'post_author'   => 1
		);
		$post_id = wp_insert_post( $post_data );
		if( $post_id ) {
			// Ukoliko je post unjet onda ćemo updejtat meta podatke ( ime, prezime i ostalo )
			$post_metas = array( 'name', 'surname', 'company', 'email' );
			foreach( $post_metas as $meta ) {
				update_post_meta( $post_id, "client_{$meta}", ${$meta} );
			}
			$return = array( 'post_id' => $post_id, 'message' => $success_message, 'success' => 'yes', 'files' => $have_files_return );
		} else {
			$return = array( 'message' => $error_message, 'success' => 'no' );
		}
	}
	echo json_encode( $return );
	die();
}

// MailChimp Subscribe
add_action('wp_ajax_send_mc_subscribe', 'send_mc_subscribe');
add_action('wp_ajax_nopriv_send_mc_subscribe', 'send_mc_subscribe');
function send_mc_subscribe() {
	/*echo "hello";
	die();
	return false;*/
	$apiKey = '612ae7409e99c78f68888aa071c31c08-us5';
	$listId = '7f89080664';
	$double_optin = false;
	$send_welcome = false;
	$email_type = 'html';
	$email = $_POST['email'];
	//replace us2 with your actual datacenter
	$submit_url = "http://us5.api.mailchimp.com/1.3/?method=listSubscribe";

	
	$data = array(
	    'email_address'=>$email,
	    'apikey'=>$apiKey,
	    'id' => $listId,
	    'double_optin' => $double_optin,
	    'send_welcome' => $send_welcome,
	    'email_type' => $email_type
	);
	$payload = json_encode($data);
	 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $submit_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
	 
	$result = curl_exec($ch);
	curl_close ($ch);
	$data = json_decode($result);
	if ($data->error){
	  /*  if( $data->code == 214 ) {
	    	echo "Već ste prijavljeni!"
	    } else if( $data->code == 502 ) {
	    	echo "Unesite ispravnu e-mail adresu!"
	    } */
	    echo $data->code;
	} else {
	    //echo "Uspješno ste prijavljeni";
	    echo "true";
	}
	die();
}

add_action('wp_ajax_get_atatched_file', 'get_attached_file_ea');
function get_attached_file_ea()
{
	$attachment_id = $_POST['attachment_id'];
	$attachment = get_post( $attachment_id );

	$otp  = '<tr id="attachment-' . $attachment->ID . '" valign="top" style="background:#fff;">';
	$otp .= ' <input name="attach_file[]" type="hidden" value="' . $attachment_id . '">';
    $otp .=  '<td class="post-title page-title column-title">';
    $otp .=    '<strong>';
    $otp .=       $attachment->post_title . ' | ' . $attachment->post_content;
    $otp .=    '</strong>';
    $otp .=    '<div class="row-actions">';
    $otp .=      '<span class="edit-file">';
    $otp .=        '<a href="' . get_edit_post_link( get_the_ID() ) . '" title="Edit this item">';
    $otp .=          'Edit';
    $otp .=        '</a>';
    $otp .=        ' | '; 
    $otp .=      '</span>';
    $otp .=      '<span class="trash">';
    $otp .=        '<a class="submitdelete-file" title="Remove this file" href="#">';
    $otp .=          'Remove';
    $otp .=        '</a>';
    $otp .=        ' | ';
    $otp .=      '</span>';
    $otp .=      '<span class="view-file">';
    $otp .=        '<a href="' . $attachment->guid . '" title="View “All about Southwest Florida”" rel="permalink">';
    $otp .=          'View';
    $otp .=        '</a>';
    $otp .=      '</span>';
    $otp .=    '</div>';
    $otp .=  '</td>';
      
    $otp .=  '<td class="author column-mime-type" style="width:120px">';
    $otp .=    '<span>';
    $otp .=       strtoupper( pathinfo($attachment->guid, PATHINFO_EXTENSION) );
    $otp .=    '</span>';
    $otp .=  '</td>';
    $otp .=  '<td class="date column-date">';
    $otp .=    '<abbr >';
    $otp .=       mysql2date('Y/m/d', $attachment->post_date);
    $otp .=    '</abbr>';
    $otp .=    '<br>';
    $otp .=     $attachment->post_status;
    $otp .=  '</td>';
    $otp .= '</tr>';

	echo $otp;

	die();
}