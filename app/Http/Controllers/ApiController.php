<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function checkDomain(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'expiring_date' => 'required'
        ]);

        $name = strtolower($request->name);

        $count = Domain::where('name', $name)->count();
        if ($count == 0) {
            Domain::create([
                'name' => $name,
                'expiring_date' => $request->expiring_date,
            ]);

            return true;
        } else {
            $data = Domain::where('name', $name)->first();

            return response()->json([
                'Domain' => $data->name,
                'Expiring_date' => $data->expiring_date,
                'status' => 'isBusy'
            ], 200);
        }
    }
}
