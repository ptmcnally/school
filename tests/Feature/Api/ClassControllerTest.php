<?php

namespace Tests\Feature\Api;

use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ClassControllerTest extends TestCase
{
    public function test_get_class_using_class_id_success()
    {
        $this->wondeServiceMock()
            ->expects('getClass')
            ->andReturn([
                'id' => 'A490481065',
                'name' => '7ORG\/Re',
                'description' => '7ORG\/Re',
                'students' => [
                    [
                        'id' => 'A86103386',
                        'surname' => 'Banin',
                        'forename' => 'Valeriya',
                    ],
                    [
                        'id' => 'A1809850877',
                        'surname' => 'Ferguson',
                        'forename' => 'Alex',
                    ]
                ]
        ]);

        $this->get('api/classes/A490481065')
            ->assertJson([
                'id' => 'A490481065',
                'name' => '7ORG\/Re',
                'description' => '7ORG\/Re',
                'students' => [
                    [
                        'id' => 'A86103386',
                        'surname' => 'Banin',
                        'forename' => 'Valeriya',
                    ],
                    [
                        'id' => 'A1809850877',
                        'surname' => 'Ferguson',
                        'forename' => 'Alex',
                    ]
                ],
            ])->assertStatus(Response::HTTP_OK);

    }

    public function test_class_id_not_found_fails_gracefully()
    {
        $this->wondeServiceMock()
            ->expects('getClass')
            ->andThrow(new ClientException(
                'Not Found',
                new \GuzzleHttp\Psr7\Request('GET', ''),
                new \GuzzleHttp\Psr7\Response(404)
            ));

        $this->get('api/classes/NOT_A_CLASS')->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
