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
	]

];