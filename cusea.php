<?

require_once 'iusea.php';


// Unified Search Engine Access Functions
class cusea extends iusea {

	var $version = "USEA 0.0.1";
    var $query; 		// search query
    var $count; 		// number of found documents
	var $links; 		// array of found documents
  	var $last_links; 	// temporarily array contains last found documents
	// flags
	var $USEA_UNIQUE = false; // delete non-unique documents from array
	var $USEA_SHOW = false;   // show found documents
	// curl settings
	var $proxy;  		// proxy IP: "http://192.168.100.10:3128"
	var $proxypasswd;	// proxy account: "login:password"
	var $ref;	 		// server url: "www.google.com"
	var $urltemplate;	// resource url: "http://www.google.com/search?hl=en&ie=UTF-8&oe=UTF-8&q=query&btnG=Google+Search"
	var $url;	 		

	// Initialize search
    function cusea($query) {
		$this->query = $query;
		$this->links = array();
		$this->count = 0;
	}

	// Free search session 
    function free() {
		$this->query = "";
		$this->free_res();
	}

	// Free search result 
    function free_res() {
		$this->links = array();
		$this->count = 0;
	}

	// Get total number of found documents
    function get_doc_count() {
		return $this->count;
	}

	// Get USEA version
    function get_version() {
		return $this->version;
	}

	// Set proxy values
    function set_proxy($proxy, $proxypasswd) {
		$this->proxy = $proxy;
		$this->proxypasswd = $proxypasswd;
	}

	// use cURL_lib for getting page throu http
	function get_page() {
    	$agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)";

    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $this->url);
    	curl_setopt($ch, CURLOPT_REFERER, $this->ref);
    	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		if (isset($this->proxy)) {
		  curl_setopt ($ch, CURLOPT_PROXY, $this->proxy); 
		  curl_setopt ($ch, CURLOPT_PROXYUSERPWD, $this->proxypasswd); 
		  curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		}	

    	$result = curl_exec ($ch);

		if (curl_error($ch)) { 
	  		printf("Error %s: %s", curl_errno($ch), curl_error($ch)); 
	  		die ("There has been an error"); 
		} 

    	curl_close ($ch);
		return $result;
	}

	// callback function for function parse: array_filter
	function filter($var) {
		return (substr($var, 0, 4) == "http");
	}

    // getting links from page
	function parse() {
  		$parsed = parse_url($this->ref);
  		$host = $parsed['host'];
  		$parts = explode(".", $host);
  		$count = count($parts);
  		$page = $this->get_page();
  		preg_match_all("|href=\"?([^\"' >]+)|i", $page, $aLinks);
  		$new = array_filter($aLinks[1], array($this, "filter")); 
  		return $new;
	}

	// Perform search 
    function find() {
		$this->last_links = array();
		$this->grab(0);
		
	}

	// recursive grabbing documents from search engine
	// $start - number of search engine page for grabbing
	// it must be overriden for each search engine
    function grab($start) {
		return 0;
	}

/*
errno - Get search error number 
error - Get search error message 
*/

} // end of class usea

?>