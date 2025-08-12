<?php

if (!function_exists('encode_html')) {
    function encode_html($value)
    {
        return esc($value, 'html');
    }
}

if (!function_exists('encode_attr')) {
    function encode_attr($value)
    {
        return esc($value, 'attr');
    }
}

if (!function_exists('encode_js')) {
    function encode_js($value)
    {
        return esc($value, 'js');
    }
}

if (!function_exists('encode_css')) {
    function encode_css($value)
    {
        return esc($value, 'css');
    }
}

if (!function_exists('encode_url')) {
    function encode_url($value)
    {
        return esc($value, 'url');
    }
}

if (!function_exists('encode_raw')) {
    // Fallback encoder: encodes as HTML by default
    function encode_raw($value)
    {
        return esc($value, 'html');
    }
}
