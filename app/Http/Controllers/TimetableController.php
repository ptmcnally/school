<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TimetableController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('TimeTable/Index', [
            'date' => $request->input('date'),
        ]);
    }
}
