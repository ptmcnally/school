<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WondeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TimetableController extends Controller
{
    public function lessons(Request $request, WondeService $wondeService)
    {
        $date = $request->get('date');
        $userId = $request->get('userId');

        try {
            $this->validate($request, ['userId' => ['required', 'string']]);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 422);
        }

        $startDate = Carbon::parse($date);
        $startDate->setTime(0,0);


        $endDate = clone $startDate;
        $endDate->setTime(23, 59, 59);

        try {
            $lessons = $wondeService->getLessons($userId, $startDate->toISOString(), $endDate->toISOString());
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), $exception->getCode());
        }

        return response()->json($lessons);
    }
}
