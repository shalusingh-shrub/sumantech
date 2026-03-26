<?php

if (!function_exists('active_route')) {
    function active_route($route)
    {
        return request()->routeIs($route) ? 'active' : '';
    }
}
