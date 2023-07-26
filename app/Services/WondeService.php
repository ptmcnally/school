<?php

namespace App\Services;

use Carbon\Carbon;
use Wonde\Client;
use Wonde\Endpoints\Schools;
use Wonde\ResultIterator;

final class WondeService
{
    protected Schools $schools;

    public function __construct(
        private Client $client,
    ) {
        // Set the school ID
        $this->schools = $this->client->school(config('wonde.school.id'));
    }

    /**
     * Load details for a class
     * @param string $classId
     * @return array
     */
    public function getClass(string $classId): array
    {
        $result = $this->schools->classes->get($classId, ['students']);

        return [
            'id' => $result->id,
            'name' => $result->name,
            'description' => $result->description,
            'students' => collect($result->students->data)->sortBy('surname')->values()->toArray()
        ];
    }

    /**
     * Get the lessons for a user between the specified dates
     * @param string $userId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    public function getLessons(string $userId, Carbon $startDate, Carbon $endDate): array
    {
        /* @var ResultIterator $resultIterator */
        $resultIterator = $this->schools->lessons->all(['employee', 'class'],
            [
                'lessons_start_after' => $startDate->toISOString(),
                'lessons_start_before' => $endDate->toISOString(),
            ]
        );

        $lessons = [];

        do {
            $lessons[] = $resultIterator->current();
            $resultIterator->next();
        } while ($resultIterator->valid());

        $lessons = collect($lessons);

        $filtered = $lessons->filter(function ($item) use ($userId) {
            return !empty($item->employee) && $item->employee->data->id == $userId;
        })->sortBy('start_at');

        return $filtered->map(function ($item) {
            $start = Carbon::parse($item->start_at->date);
            $end = Carbon::parse($item->end_at->date);

            return [
                'id' => $item->id,
                'classId' => $item->class->data->id,
                'className' => $item->class->data->name,
                'start_date' => $start->format('Y-m-d'),
                'start_time' => $start->format('H:i'),
                'end_date' => $end->format('Y-m-d'),
                'end_time' => $end->format('H:i'),
            ];
        })->values()->toArray();
    }
}
