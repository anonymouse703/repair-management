<?php

if (! function_exists('generate_code')) {
    /**
     * Generate a unique code.
     *
     * @param  int  $length
     */
    function generate_code(int $length = 15): string
    {
        $cleanNumber = preg_replace( '/[^0-9]/', '', microtime(false) );
        $preg_code = strtoupper(base_convert($cleanNumber, 10, 36));

        $time_code = strtoupper(base_convert(time(), 10, 36));

        return substr($preg_code . $time_code, 0, $length);
    }
}
