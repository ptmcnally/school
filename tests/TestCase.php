<?php

namespace Tests;

use App\Services\WondeService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery\MockInterface;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, RefreshDatabase;

    private MockInterface $wondeServiceMock;

    public function wondeServiceMock(): MockInterface|WondeService
    {
        if (empty($this->wondeService)) {
            $this->wondeServiceMock = $this->mock(WondeService::class)->makePartial();
            app()->bind(WondeService::class, function ()  {
                return $this->wondeServiceMock;
            });
        }
        return $this->wondeServiceMock;
    }
}
