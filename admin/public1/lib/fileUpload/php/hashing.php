<?php
	function do_encrypt($key,$string) {
		$iv = mcrypt_create_iv(32,MCRYPT_RAND);
		$encoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB, $iv));
		$brokestring = str_replace(array('+', '/'), array(',', '-'), $encoded);
		return $brokestring;
	}
	
	function do_decrypt($key,$string) {
		$iv = mcrypt_create_iv(32,MCRYPT_RAND);
		$fixedstring = base64_decode(str_replace(array(',', '-'), array('+', '/'), $string));
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $fixedstring, MCRYPT_MODE_ECB, $iv));
	}
?>