<html>
<body>
<div>
<?php
set_time_limit(0);
require_once 'simple_html_dom.php';
?>
<div style="text-align: center" >
<a href="usdot.php">Go to USDOT Scraper</a><br/>
<a href="usdotkeyword.php">Go to USDOT Keyword Scraper</a><br/>
<a href="craigslist.php">Go to Craigslist Scraper</a>
<h1>US Dot Number Scraper</h1>
<form enctype="multipart/form-data" action="usdot.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
Upload a text file: <br /><input name="uploadedfile" type="file" /><br />
<input type="submit" value="Submit" />
</form>
</div>
<?php
//var_dump($_FILES['uploadedfile']['tmp_name']);
$file = $_FILES['uploadedfile']['tmp_name'];
if($file) {
echo "<table border='1' cellspacing='0' cellpadding='0'>";

//$file = "usdot.txt";

$fo = file($file);
$str = utf8_decode($fo[0]);
$chars = preg_split('/[\s,]+/', $str, 0, PREG_SPLIT_OFFSET_CAPTURE);
$dotNums = array();
$result = array();

$urlDot = "http://safer.fmcsa.dot.gov/query.asp";
$urlString = "searchtype=ANY&query_type=queryCarrierSnapshot&query_param=USDOT&query_string=";
for($i = 0; $i < count($chars); $i++) {
//  for($i = 0; $i < 1 ;$i++) {
   $dotNums[$i] = $chars[$i][0];
    
    //echo trim($dotNums[$i]) . "<br/>";
    $newString = $urlString . $dotNums[$i];
    
    $ch = curl_init($urlDot);

    // set the target url
    curl_setopt($ch, CURLOPT_URL,$urlDot);

    // howmany parameter to post
    //curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, true);
    // the parameter 'username' with its value 'johndoe'
//    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$newString);
    
    //curl_setopt($ch, CURLOPT_HEADER, true); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
   // $a = curl_exec($ch);
    //if(preg_match('#Location: (.*)#', $a, $r))
      //  $l = trim($r[1]);
 
    //echo curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    $result[$i]= curl_exec($ch);
    curl_close($ch);
//}
//var_dump($result[2]);
//var_dump(str_get_html($result[0]));

/* update your path accordingly */

/**get individual data now **/

//for ($i = 0; $i < chars; $i++)
//{
	$html2 = str_get_html($result[$i]);
	$fields = $html2->find("td[class=queryfield]");
	for($j = 3; $j < 10; $j++)
	{
		$fields[$j] = str_replace("<br>", " ", $fields[$j]);
	}
	echo "<tr>";
    //legal name
	echo "$fields[3]";
    //dba name
	echo "$fields[4]";
    //address
	echo "$fields[5]";
    //mailing address
	echo "$fields[7]";
    //phone
	echo "$fields[6]";
    //us dot number
	echo "$fields[8]";
    //number of trucks
	echo "$fields[12]";
    //intermodal
    echo "$fields[41]";
	echo "</tr>";
}
echo "<table>";
}
 
?>
</div>
</body>
</html>