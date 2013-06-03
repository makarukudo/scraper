<?php
require_once 'simple_html_dom.php';
var_dump(file_get_html("http://safer.fmcsa.dot.gov/query.asp?searchtype=ANY&query_type=queryCarrierSnapshot&query_param=USDOT&original_query_param=NAME&query_string=2243471&original_query_string=1A%20INTERMODAL"));

?>