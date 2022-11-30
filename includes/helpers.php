<?php

/**
 * -----------------------------------------------------------------------------------------------------------
 * Error.log stuff
 */
function log_stuff($stuff_to_log)
{
    error_log(print_r($stuff_to_log, true));
}

/**
 * -----------------------------------------------------------------------------------------------------------
 * Translitarate non latin text
 * @param string $text
 */
function slugify($text)
{
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    $text = trim($text, '-');
    if (function_exists('transliterator_transliterate')) $text = transliterator_transliterate('Any-Latin; Latin-ASCII', $text);
    $text = iconv('utf-8', 'ASCII//TRANSLIT//IGNORE', $text);
    $text = strtolower($text);
    $text = preg_replace('~[^-\w]+~', '', $text);

    return $text;
}

/**
 * -------------------------------------------------------------------------------------------------------------------------------
 */
function slug_to_name($slug)
{
    $s = explode('_', $slug);
    $s = implode(' ', $s);
    $s = ucfirst($s);

    return $s;
}


/**
 * -----------------------------------------------------------------------------------------------------------
 * Check if number is even or odd
 * @param int $number
 */
function check_if_even($number)
{
    $number = intval($number);

    if ($number % 2 == 0) {
        return true;
    } else {
        return false;
    }
}

/**
 * -------------------------------------------------------------------------------------------------------------------------------
 * Check if is round number
 */
function is_whole_number($number)
{
    return (is_float(($f = filter_var($number, FILTER_VALIDATE_FLOAT))) && floor($f) === $f);
}