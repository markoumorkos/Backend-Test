<?php
function compress($input, $index='', $output=array())
{
	foreach($input as $key => $value)
	{
		if(is_array($value))
		{
			$prev_index = $index;
			$index .= "$key/";
			$output = compress($value, $index, $output);
			$index = $prev_index;
		}
		else
			$output["$index$key"] = $value;	
	}
	return $output;
}

function expand($input)
{
	$output = array();
	foreach($input as $key => $value)
	{
		$keys = explode('/', $key);
		$mem_o = &$output;
		foreach($keys as $k)
		{
			if(!isset($mem_o[$k]))
				$mem_o[$k] = array();
			$mem_o = &$mem_o[$k];
			$last_key = $k;
		}
		$mem_o = $value;	
	}
	return $output;
}

// compress Sample run
$arg = array(
    'one' => array(
        'two' => 3,
        'four' => array(5,6,7)
    ),
    'eight' => array(
        'nine' => array(
            'ten' => 11
        ),
        'four' => array(
            'two' => 2,
            'three' => array(
            	'six' => 6,
            	'twelve' => array(
            		'fourteen' => 14,
            		'sixteen' => 16
            	),
            	'one'=>1
            ),
        ),
    ),
);

$output = compress($arg);
echo '<pre>'; print_r($output); echo '</pre>';

// expand sample run
$arg = array(
	'one/two' => 3,
	'one/four/0' => 5,
	'one/four/1' => 6,
	'one/four/2' => 7,
	'eight/nine/ten' => 11,
	'eight/four/two' => 2,
    'eight/four/three/six' => 6,
    'eight/four/three/twelve/fourteen' => 14,
    'eight/four/three/twelve/sixteen' => 16,
    'eight/four/three/one' => 1,
);

$output = expand($arg);
echo '<pre>'; print_r($output); echo '</pre>';
?>