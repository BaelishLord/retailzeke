<?php

function excludeColumn($array, $list) {
    return array_values(array_diff( $array, $list ));
}

function removePrefix(array $input, $prefix) {
    $return = array();
    foreach ($input as $str) {
        $return[] = str_replace($prefix, '', $str);       
    }
    return $return;
}

function getIndex($arr, $check) {
    $res = [];
    foreach ($arr as $key => $value) {
        if (in_array($value, $check)) {
            array_push($res, $key);
        }
    }
    return $res;
}