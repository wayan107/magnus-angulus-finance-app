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
		if($_POST['plan']==0){
			$url = 'http://www.balilongtermrentals.com/wp-content/plugins/bltrfunc/func/curlfunc.php';
		}else{
			$url = 'http://www.balivillasales.com/wp-content/plugins/villasofbali/func/curlfunc.php';
		}
		$field = 'mode=blast&posts_per_page=10';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,  $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS,  $field);
		//curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		$villas = curl_exec($ch);
		curl_close($ch);
		
		$rent_logo = "http://www.balilongtermrentals.com/wp-content/uploads/2015/03/balilongtermrentals1.jpg";
		$buy_logo = "http://www.balivillasales.com/wp-content/uploads/2015/02/sale-lease.jpg";
		$villas = unserialize($villas);
		$data = array(
					'villas'=> $villas,
					'logo'	=> ($_POST['plan']==0) ? $rent_logo : $buy_logo
				);
		$email = $this->load->view('theme/email-template',$data,true);
		
		$client_email = $this->get_client_email($_POST['plan']);
		
		$proggress_step['step'] = 0;
		$step = 100 / (int) $client_email->num_rows();
		$file = dirname(BASEPATH).'/session/proggress.json';
		foreach($client_email->result_array() as $ce){
			$this->email($email,$ce['email'],$ce['name']);
			$proggress_step['step'] += $step;
			file_put_contents($file,json_encode($proggress_step));
			sleep(1);
		}
	}
	
	public function done(){
		$file = dirname(BASEPATH).'/session/proggress.json';
		file_put_contents($file,'');
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