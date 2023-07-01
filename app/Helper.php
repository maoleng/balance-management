<?php

if (! function_exists('formatVND')) {
    function formatVND($money): string
    {
        return number_format($money).' VND';
    }
}
