<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['inquiry'] = array('Prospect','Hot Prospect','Inspection','Lost','Deal');
$config['deal'] = 'Deal';
$config['finalized_deal'] = 'Finalized Deal';
$config['lost'] = 'Lost';
$config['status_dropdown_list'] = array(
										''					=> 'Choose',
										'Prospect'			=> 'Prospect',
										'Hot Prospect'		=> 'Hot Prospect',
										'Inspection'		=> 'Inspection',
										'Deal'				=> 'Deal',
										'Lost'				=> 'Lost');

$config['lost_cases'] = array(
								''		=> 'Choose',
								'go with other agent'	=> 'Go with other agent',
								'other'	=> 'Other'
							);