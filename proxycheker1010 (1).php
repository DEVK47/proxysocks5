<?php
// Function to scrape proxies from a website
function scrapeProxies($url) {
    $content = file_get_contents($url);
    $pattern = '/\b(?:[0-9]{1,3}\.){3}[0-9]{1,3}\:[0-9]{2,5}\b/';
    preg_match_all($pattern, $content, $matches);
    return $matches[0];
}

// Function to check if a proxy is valid
function checkProxy($proxy) {
    $timeout = 10; // Timeout value in seconds
    $testUrl = 'https://www.bing.com'; // URL to test the proxy
    
    $context = stream_context_create([
        'http' => [
            'proxy' => 'tcp://' . $proxy,
            'timeout' => $timeout,
        ],
    ]);
    
    // Try to access the test URL using the proxy
    $result = @file_get_contents($testUrl, false, $context);
    
    return ($result !== false);
}

// URL of the website to scrape proxies from
$proxyUrl = 'https://api.nucleusvpn.com/api/proxy';

// Scrape the proxies
$proxies = scrapeProxies($proxyUrl);

// Array to store valid proxies
$validProxies = [];

// Check each proxy for validity
foreach ($proxies as $proxy) {
    if (checkProxy($proxy)) {
        $validProxies[] = $proxy;
    }
}

// Save the valid proxies to a file
$validProxiesFile = 'valid_proxies2.txt';
file_put_contents($validProxiesFile, implode(PHP_EOL, $validProxies));

echo "Valid proxies saved to $validProxiesFile.";

?>
