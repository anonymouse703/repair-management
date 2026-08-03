<?php

if (! function_exists('extract_relative_url')) {
    /**
     * Extract the relative URL from then provided URL string
     *
     * @param string $url
     * @return string
     */
    function extract_relative_url(string $url): string
    {
        // Parse the URL and extract the path
        $relativeUrl = parse_url($url, PHP_URL_PATH);

        // Decode the URL-encoded parts
        $relativeUrl = urldecode($relativeUrl);

        return ltrim($relativeUrl, '/\\');
    }
}
