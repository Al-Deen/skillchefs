<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/payments/verify/sslcommerz*',
        '/api/payments/verify/sslcommerz*',
        '/admin-payments/verify/sslcommerz*',
        '/package_payments/verify/sslcommerz*',
        '/event_payments/verify/sslcommerz*',
        '/config_content',
        '/stripe*',
    ];
}
