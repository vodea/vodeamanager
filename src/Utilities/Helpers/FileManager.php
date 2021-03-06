<?php

if (!function_exists('get_json_from_path')) {
    /**
     * @param string $path
     *
     * @return array|mixed
     */
    function get_json_from_path(string $path) {
        if (!file_exists($path)) {
            return [];
        }

        return json_decode(file_get_contents($path), true);
    }
}

