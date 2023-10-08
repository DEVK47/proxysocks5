<?php

// URL of the website to scrape
$url = "https://trafficnow.xyz/ghostproxy.txt";

// Fetch the contents of the webpage
$html = file_get_contents($url);

// Regular expression pattern to match server host:port pairs
$pattern = '/(\b(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}\b:\d+)/';

// Match server host:port pairs in the HTML content
preg_match_all($pattern, $html, $matches);

// Get unique server list
$servers = array_unique($matches[0]);

// Generate PAC file content
$pacContent = "function FindProxyForURL(url, host) {\n";
$pacContent .= "    var server = ";

// Select a random server from the list
$randomIndex = array_rand($servers);
$randomServer = $servers[$randomIndex];

$pacContent .= "'HTTPS $randomServer';\n";
$pacContent .= "    return server;\n";
$pacContent .= "}\n";

// Output the PAC content
header("Content-Type: application/x-ns-proxy-autoconfig");
header("Content-Disposition: attachment; filename=servers.pac");
echo $pacContent;

?>
