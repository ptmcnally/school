<?php

namespace Tests\Feature\Api;

use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TimetableControllerTest extends TestCase
{
    public function test_loads_lessons_for_a_given_date(): void
    {
        $startDate = Carbon::parse('2022-09-05T10:35:20.021Z');
        $startDate->setTime(0,0);

        $endDate = clone $startDate;
        $endDate->setTime(23, 59, 59);

        $this->wondeServiceMock()
            ->expects('getLessons')
            ->withArgs(['A1725316986', $startDate->toISOString(), $endDate->toISOString()])
            ->andReturn([
                [
                    'id' => 'A993769494',
                    'classId' => 'A490481065',
                    'className' => '7ORG/Re',
                    'startDate' => '2022-09-05',
                    'startTime' => '08:15',
                    'endDate' => '2022-09-05',
                    'endTime' => '09:15',
                ],
                [
                    'id' => 'A1794150478',
                    'classId' => 'A2083078873',
                    'className' => '8F/Co',
                    'startDate' => '2022-09-05',
                    'startTime' => '09:15',
                    'endDate' => '2022-09-05',
                    'endTime' => '10:15',
                ]
            ]);

        $this->get('api/timetable?date=2022-09-05T10:35:20.021Z&userId=A1725316986')
            ->assertJson([
                [
                    'id' => 'A993769494',
                    'classId' => 'A490481065',
                    'className' => '7ORG/Re',
                    'startDate' => '2022-09-05',
                    'startTime' => '08:15',
                    'endDate' => '2022-09-05',
                    'endTime' => '09:15',
                ],
                [
                    'id' => 'A1794150478',
                    'classId' => 'A2083078873',
                    'className' => '8F/Co',
                    'startDate' => '2022-09-05',
                    'startTime' => '09:15',
                    'endDate' => '2022-09-05',
                    'endTime' => '10:15',
                ]
            ])->assertStatus(Response::HTTP_OK);
    }

    public function test_no_date_loads_current_date(): void
    {
        $this->travelTo('2023-07-25 10:00:00');

        $startDate = Carbon::now();
        $startDate->setTime(0,0);

        $endDate = clone $startDate;
        $endDate->setTime(23, 59, 59);

        $this->wondeServiceMock()
            ->expects('getLessons')
            ->withArgs(['A1725316986', $startDate->toISOString(), $endDate->toISOString()])
            ->andReturn([]);

        $this->get('api/timetable?userId=A1725316986')
            ->assertJson([])
            ->assertStatus(Response::HTTP_OK);
    }

    public function test_no_user_id_fails(): void
    {
        $response = $this->get('api/timetable');
        $response->assertStatus(422);
    }
}
