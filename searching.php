<?php
// LOAD DICTIONARY
$dictionary = array();
$target_filename = 'database.bin';
$fp = fopen($target_filename, "r") or die("Unable to open file!");


// LOAD RACKS
$racks =trim($_REQUEST['racks']);
$limit =trim($_REQUEST['limit']);
$racks_length = strlen($_REQUEST['racks']);
$characters =array();
for($i=0;$i<$racks_length;$i++)
{
	$characters[] = $racks{$i};
}
echo '
        <form method="POST">
        Racks : <input type="text" value="'.$racks.'" name="racks"/>
        Limit : <input type="text" value="'.(($limit > 0)? $limit : 9).'" name="limit"/>
        <input type="submit"/></form>
    ';
echo '<table><head><th width="180">Addition Characters</th><th width="180">Words</th><th width="180">Word length</th></head><tbody>';
$lists = array();
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
	    if(strlen($original_word) <= $limit)
        {
            if($word === '')
                $word ='-';
            $lists[] = array($word,$original_word,strlen($original_word));
        }

	}


}

usort($lists, function ($a, $b)
{
    if ($a[2] == $b[2]) {
        return 0;
    }
    return ($a[2] < $b[2]) ? -1 : 1;
});

foreach($lists as $row)
{
    echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td></tr>';
}

echo '</tbody></table>';
fclose($fp);