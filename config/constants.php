<?php

return [

	'timestamp' => ['created_at', 'updated_at'],
	'exclude_cd' => [],
	'Customer'=> [
	    'table' => 'customers',
	    'prefix' => 'c_'
	],
	'Vendor'=> [
	    'table' => 'vendors',
	    'prefix' => 'v_'
	],
	'Inwards'=> [
	    'table' => 'inwards',
	    'prefix' => 'i_'
	],
	'Outwards'=> [
	    'table' => 'outwards',
	    'prefix' => 'o_'
	],
	'Quotation'=> [
	    'table' => 'quotation',
	    'prefix' => 'q_'
	],
	'Purchase'=> [
	    'table' => 'purchase',
	    'prefix' => 'p_'
	],
	'Log'=> [
	    'table' => 'logs',
	    'prefix' => 'l_'
	],
	'Callcomplete'=> [
	    'table' => 'callcomplete',
	    'prefix' => 'cc_'
	],
	'Maintainance'=> [
	    'table' => 'Maintainance',
	    'prefix' => 'm_'
	]

];