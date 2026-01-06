<?php

namespace App\Services;

use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginRateLimiterService
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
    private int $decaySeconds {
        set => $this->decaySeconds = $value;
        get {
            return $this->decaySeconds ?? 180;
        }
    }


    /**
     * Create a new class instance.
     */
    public function __construct(RateLimiter $rateLimiter)
    {
        $this->rateLimiter = $rateLimiter;
    }

    public function hasExceededAttempts(string $email): bool
    {
        return $this->rateLimiter->tooManyAttempts($this->throttleKey($email), $this->maxAttempts);
    }

    public function hit(string $email): int
    {
        return $this->rateLimiter->hit($this->throttleKey($email), $this->decaySeconds);
    }

    public function clear(string $email): void
    {
        $this->rateLimiter->clear($this->throttleKey($email));
    }

    public function availableIn(string $email): int
    {
        return $this->rateLimiter->availableIn($this->throttleKey($email));
    }


    private function throttleKey(string $email): string
    {
        return Str::lower(Str::trim($email)) . "|" . request()->ip();
    }

}
