<?php

if (!function_exists('isPhone')) {
	/**
	 * 驗證台灣手機號碼
	 * @param $phone_number
	 * @return bool
	 */
	function isPhone($phone_number)
	{
		if (preg_match("/^09[0-9]{2}-[0-9]{3}-[0-9]{3}$/", $phone_number)) {
			return true;    // 09xx-xxx-xxx
		} else if (preg_match("/^09[0-9]{2}-[0-9]{6}$/", $phone_number)) {
			return true;    // 09xx-xxxxxx
		} else if (preg_match("/^09[0-9]{8}$/", $phone_number)) {
			return true;    // 09xxxxxxxx
		} else if (preg_match("/^0[0-9]{8,9}$/", $phone_number)) {
			return true;    // 09xxxxxxxx
		} else {
			return false;
		}
	}


}

if (!function_exists("isEmail")) {
	/**
	 * 驗證信箱
	 * @param $email_string
	 * @return bool
	 */
	function isEmail($email_string)
	{
		if (filter_var($email_string, FILTER_VALIDATE_EMAIL)) {
			return true;    // valid
		} else {
			return false;   // invalid
		}
	}
}

if (!function_exists("isIPv4")) {
	/**
	 * 驗證IPv4
	 * @param $ip_string
	 * @return bool
	 */
	function isIPv4($ip_string)
	{
		if (filter_var($ip_string, FILTER_VALIDATE_IP)) {
			return true;    // valid
		} else {
			return false;   // invalid
		}
	}

}

if (!function_exists("isJSON")) {
	/**
	 * 檢查是否為合法 JSON 資料
	 * @param $str
	 * @return bool|mixed
	 */
	function isJSON($str)
	{
		$json_str = str_replace('＼＼', '', $str);
		$out_array = [];
		preg_match('/{.*}/', $json_str, $out_array);
		if (!empty($out_array)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}


//yyyy-MM-dd'T'HH:mm:ss.SSSZ

if (!function_exists("transToTimeString")) {
	/**
	 * 轉換時間
	 * @param $micro_timestamp
	 * @return bool|mixed
	 */
	/*	function transToTimeString($micro_timestamp)
		{
			date_default_timezone_set('Asia/Taipei');
			if (!is_numeric($micro_timestamp)) {
				return false;
			}
			if (strlen(strval($micro_timestamp)) <= 10) {
				$timestamp = $micro_timestamp;
			} else {
				$timestamp = $micro_timestamp / 1000;
			}
			$time_string = date('c', strtotime(date("Y-m-d H:i:s", $timestamp)));
			return $time_string;
		}
	}*/

	function transToTimeString($micro_timestamp)
	{
		if ($micro_timestamp) {
			if (is_numeric($micro_timestamp)) {
				return $micro_timestamp;
			} else {
				if (!is_string($micro_timestamp)) {
					return false;
				} else {
					$formate_string = str_replace('/', '-', $micro_timestamp);
					list($y, $m, $d, $h, $i, $s, $SS, $Z) = sscanf($formate_string, "%04d-%02d-%02dT%02d:%02d:%02d.%03d+%03dZ");
					if (empty($Z)) {
						list($y, $m, $d, $h, $i, $s, $SS, $Z) = sscanf($formate_string, "%04d-%02d-%02dT%02d:%02d:%02d.%03d-%03dZ");
						$Z = -$Z;
					}
					$timestamp = mktime($h, $i, $s, $m, $d, $y);
					$timestamp = $timestamp - ($Z / 10) * 60 * 60;
					$mocro_timestamp = $timestamp * 1000 + $SS;
					return $mocro_timestamp;
				}
			}
		} else {
			return '0';
		}
	}
}

if (!function_exists("stringTransToMicroTimestamp")) {
	/**
	 * 轉換時間
	 * @param $string
	 * @return bool|mixed
	 */
	function stringTransToMicroTimestamp($string)
	{
		if ($string) {
			if (is_numeric($string)) {
				return $string;
			} else {
				if (!is_string($string)) {
					return false;
				} else {
					$formate_string = str_replace('/', '-', $string);
					list($y, $m, $d, $h, $i, $s, $SS, $Z) = sscanf($formate_string, "%04d-%02d-%02dT%02d:%02d:%02d.%03d+%03dZ");
					if (empty($Z)) {
						list($y, $m, $d, $h, $i, $s, $SS, $Z) = sscanf($formate_string, "%04d-%02d-%02dT%02d:%02d:%02d.%03d-%03dZ");
						$Z = -$Z;
					}
					$timestamp = mktime($h, $i, $s, $m, $d, $y);
					$timestamp = $timestamp - ($Z / 10) * 60 * 60;
					$mocro_timestamp = $timestamp * 1000 + $SS;
					return $mocro_timestamp;
				}
			}
		}else{
			return '0';
		}
	}
}
