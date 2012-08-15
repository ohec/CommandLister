<?php
$path = getenv('PATH');
$path_arr = explode(PATH_SEPARATOR, $path);
// print_r($path_arr);
$path_arr = array_unique(trim_path_array($path_arr));


/* Ignore some paths */
$ignore = json_decode(file_get_contents('ignore.json'), true);
$arr = array();
foreach($path_arr as $line) {
	if(!in_array($line, $ignore['ignore'])) {
		$arr[] = $line;
	}
}
$path_arr = $arr;

//file_put_contents('ignore.json', json_encode(array('ignore' => $path_arr) ));



$command_arr = array();
foreach($path_arr as $path) {
	$files = glob($path . DIRECTORY_SEPARATOR . '{*.exe,*.bat,*.cmd,*.sh,*.php}', GLOB_BRACE);
	$command_arr = array_merge($command_arr, $files);
}
print_r($command_arr);

print_r($path_arr);

function trim_path_array($arr) {
	if (!is_array($arr)) {
		return $arr;
	}

	while (list($key, $value) = each($arr)) {
		if (is_array($value)) {
			$arr[$key] = trim_path_array($value);
		} else {
			$arr[$key] = rtrim($value, '\\/ ');
		}
	}
	return $arr;
}