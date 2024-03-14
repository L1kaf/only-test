<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CarController extends Controller
{
    public function getAvailableCars(Request $request)
{
    $user = $request->user();
    $startTime = $request->input('start_time');
    $endTime = $request->input('end_time');
    $model = $request->input('model');
    $comfortCategory = $request->input('comfort_category');

    $availableCars = User::find($user->id)
        ->cars()
        ->whereDoesntHave('users', function ($query) use ($startTime, $endTime) {
            $query->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime]);
            });
        });

    if ($model) {
        $availableCars = $availableCars->where('model', $model);
    }

    if ($comfortCategory) {
        $availableCars = $availableCars->where('comfort_category', $comfortCategory);
    }

    return $availableCars->get();
}
}
