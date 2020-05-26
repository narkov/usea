 ----------------------------------------------------------------------
 Unified Search Engine Access - search engine grabber
 Copyright (C) 2003 Voznyak Nazar
 ----------------------------------------------------------------------
 LICENSE
 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License (GPL)
 as published by the Free Software Foundation; either version 2
 of the License, or (at your option) any later version.
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have recieved the lincence included with the disribution.
 If not visit http://www.gnu.org/copyleft/gpl.html
 ----------------------------------------------------------------------

Unified Search Engine Access (USEA)
v.0.0.1

USEA is a suite which can be used for grabbing results from search engine. 
In order to provide flexibility of our software and its compatibility with 
existed search engines we should use some generalized set of subroutines.
It is the highest abstract layer for accessing the search engine results. 
Implementation of these functions may use both page parsing algorythm or 
engine's API.

Requirements:
>> curl_lib


Classes
-------
iusea+
	 |
	 cusea+
		  |
		  cusea_google
		  |
		  cusea_lycos
		  |
		  cusea_rambler


Interface
---------
// Unified Search Engine Access Interface
class iusea {

	// Perform search 
    function find() {}

	// getting page from Internet
	function get_page() {}

	// getting links from page
	function parse() {}

	// recursive grabbing documents from search engine
	// $start - number of search engine page to start grabbing
	// it must be overriden for each search engine
    function grab($start) {}

	// Get total number of found documents
    function get_doc_count() {}

	// Get USEA version
    function get_version() {}

} // end of interface usea


Example
-------
The first thing that has to be added is corresponding search engine class:
require_once '../cusea_google.php'
or
require_once '../cusea_lycos.php'
or
require_once '../cusea_rambler.php'

That needs to be placed before anything else in the page.

The next step is to create object of corresponding class and set
some additionaly parameters:

   	$usea = new cusea_google($search);
    $usea->set_proxy("http://192.168.100.10:3128", "login:password");

Then you should start usea search:
   	$usea->find();

