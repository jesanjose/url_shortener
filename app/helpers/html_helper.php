<?php

function eh($string)
{
    if (!isset($string)) return;
    echo htmlspecialchars($string, ENT_QUOTES);
}

function hasFlash()
{
    if (Session::keyExist("flash-message") && Session::keyExist("flash-level")) {
        return true;
    }

    return false;
}
