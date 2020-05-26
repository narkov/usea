<?

require_once 'cusea.php';

// Unified Search Engine Access Functions for google search engine
class cusea_google extends cusea {

 // Initialize google search
 function cusea_google($query) {
	cusea::cusea($query);

    $this->ref = "www.google.com";
    $this->urltemplate = "http://www.google.com/search?hl=en&ie=UTF-8&oe=UTF-8&q=".$this->query."&btnG=Google+Search";
 }

 // recursive grabbing documents from search engine
 // $start - number of search engine page to start grabbing
 // it must be overriden for each search engine
 function grab($start) {

    $this->url = $this->urltemplate."&start=".$start;

  	$new = $this->parse($this->url, $this->ref);
  	$current_links = array();
  	while (list(,$link) = each($new)) {
     if (substr_count($link, "search?q")==0) {
      if (!strpos($link,"google.com")) {
	   array_push($current_links, $link);
	  }
	 }
  	}

  	if (count(array_diff($current_links, $this->last_links))==0) {
      if ($this->USEA_UNIQUE) $this->links = array_unique($this->links);
	  $this->count = count($this->links);
   	  return 0;
  	}
  	else {
      $this->last_links = $current_links;
	  $this->links = array_merge($this->links, $current_links);
      if ($this->USEA_SHOW) for ($i=0; $i<count($current_links); $i++) print $current_links[$i]."<br/>";
      $start = $start + 10;
      $this->grab($start);
  	}
 }

}

?>