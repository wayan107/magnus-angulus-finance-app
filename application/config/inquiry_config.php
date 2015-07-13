<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['inquiry'] = array('Prospect','Hot Prospect','Inspection','Lost','Deal');
$config['deal'] = 'Deal';
$config['finalized_deal'] = 'Finalized Deal';
$config['lost'] = 'Lost';
$config['status_dropdown_list'] = array(
										'Prospect'			=> 'Prospect',
										'Hot Prospect'		=> 'Hot Prospect',
										'Inspection'		=> 'Inspection',
										'Deal'				=> 'Deal',
										'Lost'				=> 'Lost');

$config['lost_cases'] = array(
			''										=> 'Choose',
			'Price objection'						=> 'Price objection',
			'Go with another agent'					=> 'Go with another agent',
			'Lack of options'						=> 'Lack of options',
			'Not Find villa at certain location'	=> 'Not Find villa at certain location',
			'other'									=> 'Other'
		);