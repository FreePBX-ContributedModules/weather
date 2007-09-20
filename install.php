<?php

$ampwebroot_path = (isset($amp_conf['AMPWEBROOT']) && !empty($amp_conf['AMPWEBROOT'])) ?  $amp_conf['AMPWEBROOT'] : '/var/www/html'; 

$fd = fopen($ampwebroot_path.'/admin/modules/weather/zipcodes.sql','r'); while ($fd && !feof($fd)) { $line = fgets($fd, 4096); $db->query($line); } fclose($fd);

// Register FeatureCode - Weather using flite
$fcc = new featurecode('weather', 'weather');
$fcc->setDescription('Weather Report');
$fcc->setDefault('*61');
$fcc->update();
unset($fcc);

?>
