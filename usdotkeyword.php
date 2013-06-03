<html>
<body>
<div>

<?php
$urlPost = "http://safer.fmcsa.dot.gov/CompanySnapshot.aspx";


/* update your path accordingly */
set_time_limit(0);
require_once 'simple_html_dom.php';
$myKeyword = $_POST['keyword'];
$myKeyword = str_replace(" ", "+", $myKeyword);
?>
<div style="text-align: center" >
<a href="usdot.php">Go to USDOT Scraper</a><br/>
<a href="usdotkeyword.php">Go to USDOT Keyword Scraper</a><br/>
<a href="craigslist.php">Go to Craigslist Scraper</a>
<h1>US DOT Keyword Scraper</h1>
<form action="usdotkeyword.php" method="post">
US DOT Keyword: <input type="text" name="keyword" />
<input type="submit" />
</form>
</div>
<?
if ($_POST['keyword'])
{
$url = "http://safer.fmcsa.dot.gov/keywordx.asp?searchstring=%2a". $myKeyword ."%2A&SEARCHTYPE=";
$html = file_get_html($url);
$data = $html->find('a');


/*scrape name*/
//$data =  $html->find('th[scope=rpw]');
/*scrape location*/
//$data =  $html->find('td[width=20%]');
/*scrape links*/

for($i = 0; $i < count($data); $i++){
	if(isset($data[$i]))
		
		$data[$i] = "http://safer.fmcsa.dot.gov/".$data[$i]->href;
		$data[$i] = str_replace(" ", "%20", $data[$i]);
		
		//echo $data[$i] . "<br />";	  

}

/**get individual data now **/
echo "<table border='1' cellspacing='0' cellpadding='0'>";
for ($i = 171; $i < count($data) - 1; $i++)
{
	$url2 = $data[$i];
	//$url2 = "http://safer.fmcsa.dot.gov/query.asp?searchtype=ANY&query_type=queryCarrierSnapshot&query_param=USDOT&original_query_param=NAME&query_string=2243471&original_query_string=1A%20INTERMODAL";
	$html2 = file_get_html($url2);
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
} else {
    echo "<p style='text-align: center'>Type a keyword to search</p>";
}
?>
</div>

</body>
</html>