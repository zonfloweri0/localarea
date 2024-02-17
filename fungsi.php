<?php
function lapor($psn, $lok = 'log/')
{
    $tulis = "";
    $tanggal['event_datetime'] = '[' . date('D Y-m-d h:i:s A') . ']';
    if (is_array($psn)) {
        foreach ($psn as $msg)
            $tulis.= $tanggal['event_datetime']. " " . $msg."\n";
    } else {
        $tulis.= $tanggal['event_datetime']. " " . $psn."\n";
    }
    $fileName = 'log_' . date('Ymd').'.txt';
    $fHandler = fopen($lok.$fileName,'a+');
    fwrite($fHandler,$tulis);
    fclose($fHandler);
}
