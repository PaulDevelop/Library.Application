<?php

namespace Com\PaulDevelop\Library\Application;

/**
 * Quarantine
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
abstract class Quarantine
{
    // #region methods
    public static function clean(
        $string = '',
        $datatype = 'string'
    ) {
        // init
        setlocale(LC_ALL, 'en_US');
        $result = $string;

        if (is_array($result)) {
            for ($i = 0; $i < count($result); $i++) {
                $result[$i] = Quarantine::clean($result[$i], $datatype);
            }
        } else {
            // cast data
            if ($datatype == 'string') {
                $result = (string)$result;
            } else {
                if ($datatype == 'int') {
                    $result = (int)$result;
                } else {
                    if ($datatype == 'double') {
                        $result = (double)$result;
                    } else {
                        if ($datatype == 'boolean') {
                            $result = (
                                (string)$result == 'false'
                                || (string)$result == '0'
                                || (string)$result == 'off'
                                || (string)$result == ''
                            ) ? 0 : 1;
                        }
                    }
                }
            }

            // split before null byte
            $result = (stripos(urlencode($result), "%00")) ?
                urldecode(substr(urlencode($result), 0, stripos(urlencode($result), "%00"))) : $result;

            // remove white space
            $result = trim($result);

            // remove tags
            //$result = strip_tags($result);

            // convert special characters to html entities
            $result = htmlentities($result, ENT_QUOTES, 'UTF-8');

            // recode hex strings
            $result = (substr($result, 0, 2) == '0x') ? Quarantine::hexToStr($result) : $result;
        }

        // return
        setlocale(LC_ALL, 'de_DE');
        return $result;
    }

    /**
     * @param string $hex
     *
     * @return string
     */
    private static function hexToStr($hex = '')
    {
        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i].$hex[$i + 1]));
        }
        return $string;
    }

}
