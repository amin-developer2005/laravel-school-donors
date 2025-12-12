<?php

namespace App\Services;

use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForgotPasswordRateLimiterService
{
    protected RateLimiter $rateLimiter {
        set => $this->rateLimiter = $value;
        get => $this->rateLimiter;
    }

    private string $throttleKey {
        set => $this->throttleKey = $value;
        get {
            return $this->throttleKey;
        }
    }


    private int $maxAttempts {
        set => $this->maxAttempts = $value;
        get {
            return $this->maxAttempts ?? 3;
        }
    }


    /**
     * Create a new class instance.
     */
    public function __construct(RateLimiter $rateLimiter)
    {
        $this->rateLimiter = $rateLimiter;
    }

    public function hasExceededAttempts(Request $request): bool
    {
        return $this->rateLimiter->tooManyAttempts($this->throttleKey($request), $this->maxAttempts);
    }

    private function throttleKey(Request $request): string
    {
        return Str::transliterate($request->ip());
    }

}
