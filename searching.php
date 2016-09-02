<?php
// LOAD DICTIONARY
$dictionary = array();
$target_filename = 'database.bin';
$fp = fopen($target_filename, "r") or die("Unable to open file!");


// LOAD RACKS
$racks =trim($_REQUEST['racks']);
$racks_length = strlen($_REQUEST['racks']);
$characters =array();
for($i=0;$i<$racks_length;$i++)
{
	$characters[] = $racks{$i};
}
echo '<form method="POST">Racks : <input type="text" value="'.$racks.'" name="racks"/><input type="submit"/></form>';
echo '<table><head><th>Addition Characters</th><th>Words</th></head><tbody>';
while (!feof($fp))
{
	$all_match = true;
	$word = fgets($fp);
	$original_word=$word;
	foreach($characters as $character)
	{
		$position = strpos($word,$character);

		if($position===false)
		{
			$all_match = false;
		}
		else
		{
			$word = substr_replace($word, '', $position, 1);
		}
	}
	if($all_match)
	{
		echo '<tr><td>'.$word.'</td><td>'.$original_word.'</td>';
	}


}
echo '</tbody></table>';
fclose($fp);