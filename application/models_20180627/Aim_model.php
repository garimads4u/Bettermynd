<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Aim_model extends CI_Model {



    function __construct() { // Constructor

        parent::__construct();

    }

	

	function ChargeCreditCard($ccdata,$email)

	{

		$this->load->library('authorize_net');

		$auth_net = array(

			'x_card_num'			=> $ccdata['card_number'], // Visa

			'x_exp_date'			=> $ccdata['expiration_date'],

			'x_card_code'			=> $ccdata['cvv_code'],

			'x_description'			=> ucwords(strtolower($ccdata['package_mode'])).' payment on Brandize',

			'x_amount'				=> $ccdata['amount'],

			'x_first_name'			=> $ccdata['first_name'],

			'x_last_name'			=> $ccdata['last_name'],

			'x_address'				=> $ccdata['address'],

			'x_city'				=> ' ',

			'x_state'				=> ' ',

			'x_zip'					=> $ccdata['zip_code'],

			'x_country'				=> 'US',

			'x_phone'				=> '',

			'x_email'				=> $email,

			'x_customer_ip'			=> $_SERVER['REMOTE_ADDR'],

			);

			$array_2=$auth_net;

			$return=array();

			

			$this->authorize_net->setData($auth_net);
		
			if( $this->authorize_net->authorizeAndCapture() )

			{

				$return['code']="success";

				$return['transaction_id']=$this->authorize_net->getTransactionId();

				$return['approval_code']=$this->authorize_net->getApprovalCode();

				$return['data']=$auth_net;

			}

			else

			{
				

			$return['code']="error";

				$return['message']=$this->authorize_net->getError();

			}

			return $return;

			exit;

	}

}

