<?php
/**
 * MIT License
 * ===========
 *
 * Copyright (c) 2012 Marco Troisi <hello@marcotroisi.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @package    Ping
 * @author     Marco Troisi <hello@marcotroisi.com>
 * @copyright  2012 Marco Troisi.
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    1.0
 * @link       http://www.marcotroisi.com
 *
 * Credits/Sources: http://www.wrichards.com/blog/2009/05/php-check-if-a-url-exists-with-curl/
 */

/**
 * Ping class
 **/
class Ping
{
    protected $email;

    function __construct($email = null) {
        $this->email = $email;
    }

    function checkUrl($url = null) 
    {
        $url = $url;
        $check = $this->urlExists($url);
        $time = new DateTime();
        if($check) {
            $message = $url." is up - ".$time->format("d-m-Y H:i:s");
        } else {
            $message = $url." is down - ".$time->format("U");
            mail($this->email, "Ping.php alert", $message);
        }

        /**
        * Logging Ping results
        */
        $file = 'log.txt';
        $current = file_get_contents($file);
        $current .= $message."\n";
        file_put_contents($file, $current);
    }

    function urlExists($url = null)
    {
        if ($url == NULL) 
            return false;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpcode>=200 && $httpcode<300) {
            return true;
        } else {
            return false;
        }
    }
} // END class 
