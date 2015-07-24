<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Emailblast extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$data['_page_title'] = 'Send Email';
		$this->myci->display_adm('theme/emailblast',$data);
	}
	
	public function sendemail(){
		$url = 'http://www.balilongtermrentals.com/wp-content/plugins/bltrfunc/func/curlfunc.php';
		$field = 'mode=blast';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,  $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS,  $field);
		//curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		$villas = curl_exec($ch);
		curl_close($ch);
		
		$villas = unserialize($villas);
		$email = $this->load->view('theme/email-template',array('villas'=>$villas),true);
		
		$client_email = $this->get_client_email(0);
		
		/*echo '<pre>';
		print_r($client_email->result_array());
		echo '</pre>';
		
		exit();*/
		foreach($client_email->result_array() as $ce){
			$this->email($email,$ce['email'],$ce['name']);
		}
	}
	
	private function email($msg,$to,$nameto){
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		$subject = 'Newest Yearly Rental Villas';
		// Additional headers
		$headers .= 'To: '.$nameto.' <'.$to.'>' . "\r\n";
		$headers .= 'From:  Bali Long Term Rentals <info@balilongtermrentals.com>' . "\r\n";

		// Mail it
		mail($to, $subject, $msg, $headers);
	}
	
	private function get_client_email($plan){
		$query = $this->db->query('SELECT email,c.name from fn_client c
									inner join fn_deals d on c.id=d.client
									where d.plan="'.$plan.'" and c.email<>""');
		return $query;
	}
}