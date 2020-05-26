<?
  require_once 'cusea_google.php';
  require_once 'cusea_rambler.php';

  $search = stripslashes($search);
  $usea = new cusea("");
  print "<h1>".$usea->get_version()."</h1>";
  $result = array();

  // grab google results
  if (isset($google)) {
    print "<h3>Google</h3>";
   	$usea = new cusea_google($search);
   	$usea->find();
	print "Totally found: ".$usea->get_doc_count();
	$result = array_merge($result, $usea->links);
  }	

  // grab rambler results
  if (isset($rambler)) {
  	print "<h3>Rambler</h3>";
   	$usea = new cusea_rambler($search);
  	$usea->find();
	print "Totally found: ".$usea->get_doc_count();
	$result = array_merge($result, $usea->links);
  }

  print "<h3>Search results for $search</h3>";
  $result = array_unique($result);
  sort($result);
  for ($i=0; $i<count($result); $i++) print $result[$i]."<br/>";
  print "<b>Totally found:</b> ".count($result);

?>
<hr/>
<a href="search.html"><< Back</a>
