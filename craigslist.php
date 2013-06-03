<html>
<body>
<div>
<?php
//craigslist scraper
/* update your path accordingly */
set_time_limit(0);
require_once 'simple_html_dom.php';
$myUrl = $_POST['url'];
?>
<div style="text-align: center" >
<a href="usdot.php">Go to USDOT Scraper</a><br/>
<a href="usdotkeyword.php">Go to USDOT Keyword Scraper</a><br/>
<a href="craigslist.php">Go to Craigslist Scraper</a>
<h1>Craigslist Email Scraper</h1>
<form action="craigslist.php" method="post">
Craigslist Category:
	<input type="radio" name="url" value="http://sfbay.craigslist.org/trp/"> Transport 
	<input type="radio" name="url" value="http://sfbay.craigslist.org/spa/"> Salon & Spa 
	<input type="radio" name="url" value="http://sfbay.craigslist.org/fbh/"> Food & Bev 
	<input type="radio" name="url" value="http://sfbay.craigslist.org/thp/"> Theraputic 
	<input type="radio" name="url" value="http://sfbay.craigslist.org/bts/"> Beauty Services 
	
<!--Craigslist URL: <input type="text" name="url" />-->
<input type="submit" />
</form>
</div>
<?
if ($_POST['url'])
{
	echo "<table>";
	for ($j = 0; $j <= 7; $j++)
	{
		$url = $_POST['url']. "index".$j."00.html";
		
		$html = file_get_html($url);
		 
		/*
		Get all table rows having the id attribute named 'rhsline'.
		As the list of sponsored links is in the 'ol' tag; as can be
		seen from the DOM tree above; we use the 'children' function
		on the $data object to get the sponsored links.
		*/
		$data = $html->find('p');
		
		for($i = 0; $i < count($data); $i++){
			if(isset($data[$i]))
				$data[$i] = $data[$i]->children(0)->href;
		/*		$data[$i] = str_replace(" ", "%20", $data[$i]);*/
				
				//echo $data[$i] . "<br />";	  
		
		}
		
		/**get individual data now **/
		
		for ($i = 0; $i < count($data) - 1; $i++)
		{
			
			$url2 = $data[$i];
			$html2 = file_get_html($url2);
			$fields = $html2->find("a");
			echo "<tr>";
			
			if(preg_match("/mailto/", $fields[10]->href)){
				echo "<td>".$fields[10]."</td>";
			} else if(preg_match("/mailto/", $fields[11]->href)){
				echo "<td>".$fields[11]."</td>";
			} else if(preg_match("/mailto/", $fields[5]->href)){
				echo "<td>".$fields[5]."</td>";
			} else if(preg_match("/mailto/", $fields[6]->href)){
				echo "<td>".$fields[6]."</td>";
			}else if(preg_match("/mailto/", $fields[7]->href)){
				echo "<td>".$fields[7]."</td>";
			}else if(preg_match("/mailto/", $fields[8]->href)){
				echo "<td>".$fields[8]."</td>";
			}else if(preg_match("/mailto/", $fields[9]->href)){
				echo "<td>".$fields[9]."</td>";
			}else if(preg_match("/mailto/", $fields[12]->href)){
				echo "<td>".$fields[12]."</td>";
			}
			echo "</tr>";
		}
		
		
	}
	echo "<table>";	
} else {
    echo "<p style='text-align: center'>Select a craigslist category to get emails</p>";
}
?>
</div>

</body>
</html>