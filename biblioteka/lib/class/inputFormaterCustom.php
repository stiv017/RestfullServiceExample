<?php

/**
 * Methods for cleaning inputs
 * @author Predrag Pecev
 */

function formatInput($input) 
{
    $formatedInput = $input;
    // html tags
    $formatedInput = strip_tags($formatedInput);
    // javascript
    $formatedInput = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $formatedInput);
    // mysql injection
    $formatedInput = mysql_escape_mimic($formatedInput);

    return $formatedInput;
}

function mysql_escape_mimic($inp) {
    if (is_array($inp))
        return array_map(__METHOD__, $inp);

    if (!empty($inp) && is_string($inp)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a", ';', '%', '_'), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z', '', '', ''), $inp);
    }

    return $inp;
}

?>