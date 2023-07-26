<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WondeService;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function show(Request $request, WondeService $wondeService, string $classId)
    {
        try {
            $class = $wondeService->getClass($classId);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), $exception->getCode());
        }

        return response()->json($class);
    }
}
