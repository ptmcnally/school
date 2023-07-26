<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class ClassControllerTest extends TestCase
{
    public function test_get_class_using_id()
    {
        $response = $this->get('api/classes/A490481065');

        dd($response->content());

    }

    public function test_class_id_not_found()
    {

    }

    public function test_api_error()
    {

    }
}
