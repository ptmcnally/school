<?php

namespace Tests\Unit\Services;

use App\Services\WondeService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use Wonde\Exceptions\InvalidTokenException;

class WondeServiceTest extends TestCase
{
    /**
     * @throws BindingResolutionException
     */
    public function test_creates_service()
    {
        $wondeService = app()->make(WondeService::class);
        $this->assertInstanceOf(WondeService::class, $wondeService);
    }

    public function test_no_token_fails()
    {
        $this->expectException(InvalidTokenException::class);

        Config::set('wonde.school.api_key', '');

        $wondeService = app()->make(WondeService::class);

        $this->assertInstanceOf(WondeService::class, $wondeService);
    }

    // TODO: More low-level API tests
}
