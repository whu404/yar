--TEST--
Check for yar concurrent client with exit in callback
--SKIPIF--
<?php 
if (!extension_loaded("yar")) {
    print "skip";
}
?>
--FILE--
<?php 
include "yar.inc";

yar_server_start();

function callback($return, $callinfo) {
    global $sequence;

    if ($callinfo) {
        exit("exit");
    }
}

Yar_Concurrent_Client::call(YAR_API_ADDRESS, "normal", array("xxx", "3.8"));
Yar_Concurrent_Client::call(YAR_API_ADDRESS, "normal", array("xxx", "3.8"));
Yar_Concurrent_Client::call(YAR_API_ADDRESS, "normal", array("xxx", "3.8"));

try {
    Yar_Concurrent_Client::loop("callback");
} catch (Exception $e) {
    var_dump($e->getMessage());
}

--EXPECTF--
exit
