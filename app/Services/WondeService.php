<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Wonde\Client;
use Wonde\Endpoints\Schools;
use Wonde\ResultIterator;

class WondeService
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
            'students' => collect($result->students->data)->map(function ($item) {
                return [
                    'id' => $item->id,
                    'surname' => $item->surname,
                    'forename' => $item->forename,
                ];
            })->sortBy('surname')->values()->toArray()
        ];
    }

    /**
     * Get the lessons for a user between the specified dates
     * @param string $userId
     * @param string $startDate
     * @param string $endDate
     * @return array
     * @throws \Exception
     */
    public function getLessons(string $userId, string $startDate, string $endDate): array
    {
        try {
            $startDate = Carbon::parse($startDate);
        } catch (InvalidFormatException) {
            throw new \Exception('Invalid format for start date');
        }

        try {
            $endDate = Carbon::parse($endDate);
        } catch (InvalidFormatException) {
            throw new \Exception('Invalid format for end date');
        }

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
                'startDate' => $start->format('Y-m-d'),
                'startTime' => $start->format('H:i'),
                'endDate' => $end->format('Y-m-d'),
                'endTime' => $end->format('H:i'),
            ];
        })->values()->toArray();
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->client, $name], $arguments);
    }
}
