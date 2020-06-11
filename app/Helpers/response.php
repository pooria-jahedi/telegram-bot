<?php

/**
 * Respond 200 OK with an optional
 * This is used to return an acknowledgement response indicating that the request has been accepted and then the script can continue processing
 * ref: http://keepcoding.ehsanabbasi.com/php/processing-php-after-sending-200-ok/
 *
 * @param null $text
 */
function http_respond_200($text = null)
{
    // check if fastcgi_finish_request is callable
    if (is_callable('fastcgi_finish_request')) {
        if ($text !== null) {
            echo $text;
        }
        /*
         * http://stackoverflow.com/a/38918192
         * This works in Nginx but the next approach not
         */
        session_write_close();
        fastcgi_finish_request();

        return;
    }

    ignore_user_abort(true);

    ob_start();

    if ($text !== null) {
        echo $text;
    }

    $serverProtocol = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL', FILTER_SANITIZE_STRING);
    header($serverProtocol . ' 200 OK');
    // Disable compression (in case content length is compressed).
//    header('Content-Encoding: none');
//    header('Content-Length: ' . ob_get_length());

    // Close the connection.
    header('Connection: close');

    ob_flush();
    @ob_end_flush();
    @ob_flush();
    @flush();

    // fixme anton
    // wait for a sec
    sleep(1);
}