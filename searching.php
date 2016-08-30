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

echo '<ul>';
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
		echo '<li>'.$original_word.'</li>';

}
echo '</ul>';
fclose($fp);