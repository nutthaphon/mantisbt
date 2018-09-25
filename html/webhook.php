<?php
$mantisbt_key = '5ceb76f3226f3566816ed483';
# Get JSON as a string
$json_str = file_get_contents('php://input');

#$file = '/tmp/svn_rev.txt';
// The new person to add to the file
$svninfo = json_decode($json_str);
// Write the contents to the file, 
// using the FILE_APPEND flag to append the content to the end of the file
// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
//file_put_contents($file, $svninfo->revision . "\n", FILE_APPEND | LOCK_EX);

// create a new cURL resource


$ch = curl_init();

$data = array('repo_name' => $svninfo->repository, 'data' => $svninfo->revision, 'api_key' => $mantisbt_key);

curl_setopt($ch, CURLOPT_URL, 'http://issues.ascii.in.th/plugin.php?page=Source/checkin');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // required as of PHP 5.6.0
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

curl_exec($ch);
?>
