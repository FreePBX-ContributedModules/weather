<?php

function weather_get_config($engine) {
	$modulename = 'weather';
	
	// This generates the dialplan
	global $ext;  
	switch($engine) {
		case "asterisk":
			if (is_array($featurelist = featurecodes_getModuleFeatures($modulename))) {
				foreach($featurelist as $item) {
					$featurename = $item['featurename'];
					$fname = $modulename.'_'.$featurename;
					if (function_exists($fname)) {
						$fcc = new featurecode($modulename, $featurename);
						$fc = $fcc->getCodeActive();
						unset($fcc);
						
						if ($fc != '')
							$fname($fc);
					} else {
						$ext->add('from-internal-additional', 'debug', '', new ext_noop($modulename.": No func $fname"));
						var_dump($item);
					}	
				}
			}
		break;
	}
}

function weather_weather($c) {
	global $ext;

	$id = "app-weather"; // The context to be included

	$ext->addInclude('from-internal-additional', $id); // Add the include from from-internal

	$ext->add($id, $c, '', new ext_macro('user-callerid'));
	$ext->add($id, $c, '', new ext_answer('')); // $cmd,1,Answer
	$ext->add($id, $c, '', new ext_wait('1'));
	$ext->add($id, $c, '', new ext_DigitTimeout('7'));
	$ext->add($id, $c, '', new ext_ResponseTimeout('10'));
	$ext->add($id, $c, '', new ext_Flite("At the beep enter the five digit zip code for the weather report you wish to retrieve."));
	$ext->add($id, $c, '', new ext_Read('ZIPCODE,beep,5'));
	$ext->add($id, $c, '', new ext_Flite("Please hold a moment while we contact the National Weather Service for your report."));			
	$ext->add($id, $c, '', new ext_AGI('nv-weather-zip.php|${ZIPCODE}'));
	$ext->add($id, $c, '', new ext_NoOp('Wave file: ${TMPWAVE}'));
	$ext->add($id, $c, '', new ext_Playback('${TMPWAVE}'));	
	$ext->add($id, $c, '', new ext_macro('hangupcall')); // $cmd,n,Macro(user-callerid)
}

?>
