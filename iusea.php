<?

// Unified Search Engine Access Interface
class iusea {

	// Perform search 
    function find() {}

	// getting page from Internet
	function get_page() {}

	// getting links from page
	function parse() {}

	// recursive grabbing documents from search engine
	// $start - number of search engine page for grabbing
	// it must be overriden for each search engine
    function grab($start) {}

	// Get total number of found documents
    function get_doc_count() {}

	// Get USEA version
    function get_version() {}

} // end of interface usea

?>