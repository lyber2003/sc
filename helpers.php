<?php

function dd()
{
    call_user_func_array('var_dump', func_get_args());
    die;
}

// code taken from https://github.com/laravel/framework/blob/master/src/Illuminate/Support/helpers.php#L734
if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

// code taken from https://github.com/laravel/framework/blob/master/src/Illuminate/Foundation/helpers.php#L618
if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        if ($value === '' && $value[0] === '"' && '"' === substr($value, -1)) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}
