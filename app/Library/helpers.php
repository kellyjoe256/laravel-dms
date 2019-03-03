<?php

/**
 * Searches for a specified character(s) in the given string and replaces it
 * with the given replacement character(s)
 * @param string $string
 * @param string $character
 * @param string $replacement
 * @return string
 */
function replace_character($string, $character = ' ', $replacement = '-')
{
    return str_replace($character, $replacement, $string);
}

/**
 * Set active CSS class on top level link for a multiple level links
 *
 * @param array $paths Paths to check in order to set an active link
 * @param string $active_class Default 'active' CSS class to set on link
 * @return string
 */
function set_multilevel_active(array $paths, $active_class = 'active')
{
    foreach ($paths as $path) {
        if (Request::is($path . '*') || Request::is($path . '/*')) {
            return $active_class . ' ';
        }
    }

    return '';
}

/**
 * Sets CSS class on link if the current url path matches or one of the given keywords exists in the current url path
 *
 * @param string $path Current url path
 * @param string $keywords Default '' Keywords to search for in the current url path
 * @param string $active_class Default 'active' CSS class that will be used to set the active link
 * @return string
 */
function set_active($path, $keywords = '', $active_class = 'active')
{
    $url_path = Request::path();
    // check if our path string and any of the keywords also
    // exist in the full url path
    $temp = strpos($url_path, $path) !== false && check_in_string(
        $url_path, $keywords);

    if (Request::is($path) || $temp) {
        return ' class="' . $active_class . '"';
    }

    return '';
}

/**
 * Takes a string and checks whether any of the keywords exists in the string
 *
 * @param string $str_to_check String that will be checked for keyword
 * @param string $keywords Keywords that will be checked for
 * @param string $delimiter A delimiter is used to separate the keywords
 * @return boolean
 */
function check_in_string($str_to_check, $keywords, $delimiter = ',')
{
    $words = explode($delimiter, $keywords);
    $words = array_map(function ($word) {
        return trim($word);
    }, $words);

    foreach ($words as $word) {
        if ($word && strpos($str_to_check, $word) !== false) {
            return true;
        }
    }

    return false;
}

/**
 * Modify string or one_dimensional array of strings for display
 * @param mixed $input
 * @param array $delimiters
 * @return mixed
 */
function beautify_input($input, array $delimiters = ['_', '-'])
{
    $output = '';

    if (is_array($input)) {
        $output = [];

        foreach ($input as $key => $value) {
            $temp = str_replace($delimiters, ' ', $value);
            $temp = ucwords($temp);
            $output[$key] = $temp;
        }
    } else {
        $output = str_replace($delimiters, ' ', $input);
        $output = ucwords($output);
    }

    return $output;
}

/**
 * Format slug for editing
 * @param string $slug
 * @param string $delimiter Default '-'
 * @return string
 */
function format_slug($slug, $delimiter = '-')
{
    $slug_parts = explode($delimiter, $slug);
    array_pop($slug_parts);
    $formatted_slug = implode(' ', $slug_parts);
    return ucfirst($formatted_slug);
}

/**
 * Format query string for fulltext index searches
 *
 * @param string $query_string
 * @return string
 */
function format_query_string($query_string)
{
    $query_string_parts = explode(' ', $query_string);
    $parts_length = count($query_string_parts);
    for ($i = 0; $i < $parts_length; $i += 1) {
        if ((bool) $query_string_parts[$i]
            && strlen($query_string_parts[$i]) < 4) {
            $query_string_parts[$i] = str_pad(
                $query_string_parts[$i], 4, '*'
            );
        }
    }

    return implode(' ', $query_string_parts);
}

/**
 * Checks if signed user is an administrator
 *  @return boolean
 */
function is_admin()
{
    return auth()->user()->is_admin;
}

/**
 * Sets the appropriate headers and downloads the file
 * 
 * @param string $file file to download
 * @param string $path_to_file Default './' Path to file file for download
 * @param string $name Name that user will receive the file as while downloading
 * @return string
 */
function download_file($file, $path_to_file = './', $name = 'file')
{
    $file_parts = explode('.', $file);
    $file_extension = $file_parts[1];

    $full_path_to_file = '';
    if (substr($path_to_file, -1) != '/') {
        $full_path_to_file = $path_to_file . DIRECTORY_SEPARATOR . $file;
    } else {
        $full_path_to_file = $path_to_file . $file;
    }

    $content_type = '';
    switch (strtolower($file_extension)) {
        case 'pdf':
            $content_type = 'application/pdf';
            break;
        case 'docx':
            $content_type = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            break;
        case 'doc':
            $content_type = 'application/msword';
            break;
    }

    $send_name = $name . '.' . $file_extension;

    header('Content-Type: ' . $content_type);
    header('Content-Disposition: attachment; filename=' . $send_name . '');
    header('Content-Length: ' . filesize($full_path_to_file));
    ob_clean();
    flush();
    readfile($full_path_to_file);
    exit();
}

/**
 * Sets the appropriate headers and previews the file
 * 
 * @param string $file file to preview
 * @param string $path_to_file Default './' Path to file file for download
 * @param string $name Name that user will receive the file as while downloading
 * @return string
 */
function preview_file($file, $path_to_file = './', $name = 'file')
{
    $file_parts = explode('.', $file);
    $file_extension = $file_parts[1];

    $full_path_to_file = '';
    if (substr($path_to_file, -1) != '/') {
        $full_path_to_file = $path_to_file . DIRECTORY_SEPARATOR . $file;
    } else {
        $full_path_to_file = $path_to_file . $file;
    }

    $content_type = '';
    switch (strtolower($file_extension)) {
        case 'pdf':
            $content_type = 'application/pdf';
            break;
        case 'png':
            $content_type = 'image/png';
            break;
        case 'jpeg':
        case 'jpg':
            $content_type = 'image/jpeg';
            break;
        case 'gif':
            $content_type = 'image/gif';
            break;
    }

    $send_name = $name . '.' . $file_extension;

    header('Content-Type: ' . $content_type);
    header('Content-Disposition: inline; filename=' . $send_name . '');
    header('Content-Length: ' . filesize($full_path_to_file));
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    ob_clean();
    flush();
    readfile($full_path_to_file);
    exit();
}

/**
 * Returns the breadcrumbs for each page without the last one
 * @return array
 */
function get_breadcrumbs()
{
    $segments = request()->segments();
    // remove the last segment because page title will be used instead
    array_pop($segments);

    $breadcrumbs = ['home' => '/'];

    foreach ($segments as $index => $segment) {
        // Ignore numbers, because they may indicate ids of an Entity
        // being edited, deleted or otherwise
        if (is_numeric($segment)) {continue;}
        $link = implode('/', array_slice($segments, 0, $index + 1));
        // Add forward slash at the beginning of the link
        $link = substr_replace($link, '/', 0, 0);
        $breadcrumbs[$segment] = $link;
    }

    return $breadcrumbs;
}

/**
 * Generates a string to a certain length of characters
 *
 * @param string $string
 * @param int $length Optional Default 150
 * @param string $append_chars Optional Default ...
 * @return string
 */
function get_string_brief($string, $length = 150, $append_chars = '...')
{
    $brief = trim(substr($string, 0, $length));
    $brief_last_character = substr($brief, -1, 1);

    if ($brief_last_character == '.') {
        $brief = rtrim($brief, '.');
    }

    $brief .= ' ' . $append_chars;

    return $brief;
}

/**
 * Upload a file
 *
 * @param \Illuminate\Http\UploadedFile $upload
 * @param string $destination uploaded file destination
 * @param string $name Optional name for file to be stored as
 * @return array
 */
function upload_file(\Illuminate\Http\UploadedFile $upload, $destination, $name = '')
{
    $filename_with_ext = $upload->getClientOriginalName();
    $filename = pathinfo($filename_with_ext, PATHINFO_FILENAME);
    $extension = $upload->getClientOriginalExtension();
    if ((bool) $name) {
        $filename_to_store = $name . '_' . time();
    } else {
        $filename_to_store = $filename . '_' . time();
    }
    $filename_to_store .= '.' . $extension;

    try {
        $uploaded = $upload->move($destination, $filename_to_store);
    } catch (\Exception $e) {
        $uploaded = false;
    }

    return [(bool) $uploaded, $filename_to_store];
}

/**
 * Modify a date or time
 *
 * @param string $date_string date/datetime string to modify
 * @param string $modification_string string to modify the date/datetime
 * @return \DateTime
 */
function modify_date($date_string, $modification_string)
{
    $date = new \DateTime($date_string);
    return $date->modify($modification_string);
}

/**
 * Check whether the values of a one-dimensional array contain a specific value
 *
 * @param array $arr array to be checked
 * @param mixed value to check for
 * @return boolean
 */
function check_array_values(array $arr, $value)
{
    $out = false;

    $combined_string_of_values = implode('/', $arr);
    if (strpos($combined_string_of_values, '' . $value, 0) !== false) {
        $out = true;
    }

    return $out;
}
