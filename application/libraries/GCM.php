<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GCM {

    function send($pupil_id, $message, $collapse_key) {
			$apiKey = "AIzaSyAM-A6ttQQmkqllswtVu5eHQc01QmVq9gs";

			$CI =& get_instance();
			$CI->load->model('tablemodel', 'table');


			$regIds = $CI->table->getGCMIDs($pupil_id);

			$regIdsArray = array();

			foreach($regIds as $id) {
				$regIdsArray[] = $id['GCM_USERS_REGID'];
			}


			// Replace with the real client registration IDs
			$registrationIDs = $regIdsArray;

			// Set POST variables
		    $url = 'https://android.googleapis.com/gcm/send';

		    $fields = array(
		       'registration_ids' => $registrationIDs,
		       'collapse_key' => $collapse_key,
		       'data' => array("message" => json_encode($message, JSON_UNESCAPED_UNICODE)),
		    );
	 	    $headers = array(
	 	        'Authorization: key=' . $apiKey,
		        'Content-Type: application/json'
		    );

	 	    // Open connection
			$ch = curl_init();

		    // Set the URL, number of POST vars, POST data
			curl_setopt( $ch, CURLOPT_URL, $url);
		    curl_setopt( $ch, CURLOPT_POST, true);
	        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $fields));

			// Execute post
			$result = curl_exec($ch);

			// Close connection
			curl_close($ch);
			//echo $result;
		}

}
