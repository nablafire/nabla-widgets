<?php 

function build_font_array($key){

	$url = "https://www.googleapis.com/webfonts/v1/webfonts?key=$key";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_REFERER, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$json = curl_exec($ch);
	curl_close($ch);

	$font_list = json_decode($json);

	var_dump($font_list);

	$result = array();
	foreach($font_list->items as $key => $val){
		$php_key = $val->family;
		$php_val = 'font-family:'.'\''.$php_key.'\','. $val->category.';';
		$result[$php_key] = $php_val;
	}
	file_put_contents("./google-fonts.json", json_encode($result, JSON_PRETTY_PRINT));
}

$key="AIzaSyAAo920u17fAzqqkEotZPU2qblxg5ddB4E";
build_font_array($key);