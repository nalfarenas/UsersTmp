<?php
namespace nalfarenas\userstmp;

use JWTAuth;
use Illuminate\Support\Facades\Cache;

class UserTempStorage
{

    const USER_CACHE_NAMESPACE = 'users:temp';

    protected $user;

    public function __construct()
    {

        $this->user = JWTAuth::toUser(JWTAuth::getToken());
    }

    protected function cacheKey($key, $stringCodUsuario)
    {

        if(!is_object($this->user)){

            return null;
        }

        return implode(':', [self::USER_CACHE_NAMESPACE, $this->user->$stringCodUsuario, $key]);
    }

    public function get($key, $stringCodUsuario)
    {

        return Cache::get($this->cacheKey($key, $stringCodUsuario));
    }

    // 1440 = 24 hours * 60 minutes --> cache TTLs for Laravel are in minutes.
    // when the TTL expires, the data won't be returned by the cache service anymore.
    // since it is "temp" data, this should be plenty of time for it to be cached.
    public function set($key, $stringCodUsuario, $value, $ttl = 1440)
    {

        Cache::put($this->cacheKey($key, $stringCodUsuario), $value, $ttl);
    }
}