<?php

use Illuminate\Support\Facades\App;

if (!function_exists('c')) {
    function c(string $key)
    {
        return App::make($key);
    }
}

if (! function_exists('formatVND')) {
    function formatVND($money, $type = 'muted'): string
    {
        return number_format($money)."<small class=\"text-$type small\">đ</small>";
    }
}

if (! function_exists('formatCoin')) {
    function formatCoin($money, $coin): string
    {
        if (! str_contains($money, '.')) {
            $money .= '.0';
        }
        [$whole_number, $decimal_part] = explode('.', $money);

        return number_format($whole_number).'.'.$decimal_part.' <small class="text-muted small">'.$coin.'</small>';
    }
}

if (! function_exists('getFullPath')) {
    function getFullPath($path): string
    {
        return $path ? asset('/storage/'.$path) : asset('assets/img/sample/avatar/avatar1.jpg');
    }
}

if (! function_exists('getCoinLogo')) {
    function getCoinLogo($coin): string
    {
        $coin = strtolower($coin);

        return "https://assets.coincap.io/assets/icons/$coin@2x.png";
    }
}

if (! function_exists('addWithPrecision')) {
    function addWithPrecision($a, $b): float
    {
        $a_len = strlen(substr(strrchr($a, '.'), 1));
        $b_len = strlen(substr(strrchr($b, '.'), 1));
        $len = max($a_len, $b_len);

        return (float) bcadd($a, $b, $len);
    }
}

if (! function_exists('showMessage')) {
    function showMessage(): string
    {
        $errors = session()->get('errors');
        if (! empty($errors)) {
            $error_message = is_array($errors) ? implode('<br>', $errors) : $errors;

            return <<<HTML
                <div class="toast d-flex align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body">
                        $error_message
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            HTML;
        }

        $success = session()->get('success');
        if (isset($success)) {
            return <<<HTML
                <div class="toast d-flex align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body">
                        $success
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            HTML;
        }

        return '';
    }
}
