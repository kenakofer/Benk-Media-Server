<?php
$sources = array(
    "stream.cr" => array(
        "search_url_prefix" => "https://search.stream.cr/y/?query=",
        "links_xpath_pattern" => '//a[@class="rl"]/@href',
        "titles_xpath_pattern" => '//a[@class="rl"]',
        "intermediate_links" => array(),
        "player_xpath_pattern" => '//iframe/@src',
    ),
    "hdm.to" => array(
        "search_url_prefix" => "https://hdm.to/search/",
        "links_xpath_pattern" => '//article/a/@href',
        "titles_xpath_pattern" => '//div[@class="movie-details"]',
        "intermediate_links" => array(),
        "player_xpath_pattern" => '//iframe/@src',
    ),
    /*
     * Before starting to add a new source, make sure that you can find your way
     * to the iframe or video url using the view-source of the pages (not 
     * the console). The vast majoity of sites use obfuscating js to only reveal
     * the source urls after the page has loaded.
     */
);

?>
