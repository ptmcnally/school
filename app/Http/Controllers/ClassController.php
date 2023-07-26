<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ClassController extends Controller
{
    public function show(Request $request, $classId): Response
    {
        return Inertia::render('Class/Show', [
            'classId' => $classId,
        ]);
    }
}
