<?php
class Sendsms{
	
	
	function validate_msisdn($msisdn)
	{
	  $msisdn = trim(preg_replace("/[^0-9]+/", "", $msisdn));
	  $msisdn = preg_replace("/^(00)?(88)?0/", "", $msisdn);
	  if (strlen($msisdn) != 10 || strncmp($msisdn, "1", 1) != 0)
		return false;

	  $msisdn = "880" . $msisdn;
	  return $msisdn;
	}
	
	function send_ayub_sms($sms_text, $recipients, $ta='pv', $mask='', $type='text')
		{
			
		  $destination = '';
		  if ($ta == 'pv') { # private message (to numbers)
			if (!is_array($recipients)) { # one or more numbers specified in string, comma delimited
			  $recipients = explode(',', $recipients); # make array of numbers
			}
			//print_r(array_filter($recipients, array($this,"validate_msisdn")));die;
			$destination = implode(',', array_filter($recipients, array($this,"validate_msisdn"))); # filter out invalid numbers
			
		  } else { # broadcast message (to group)
			$destination = strtoupper(trim($recipients));
		  }

		
		  if ($destination == '') return false;
		  if ($type != 'flash') $type = 'text';

		  $url = "https://sms.nixtecsys.com/index.php?app=webservices&ta=pv&u=nimtola&h=be5bedfab5e7c97b30bbda0e46976f135b940afe&to=" . rawurlencode($destination)
			. "&msg=" . rawurlencode($sms_text) . "&mask=" . rawurlencode($mask)
			. "&type=$type";
		  return @file_get_contents($url);
		}
}