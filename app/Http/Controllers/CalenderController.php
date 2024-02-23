<?php

namespace App\Http\Controllers;

use App\Models\Meetings;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Meetings::whereDate('date_start', '>=', $request->start)
                ->whereDate('date_end', '<=', $request->end)
                ->get(['id', 'name', 'date_start', 'date_end']);
            return response()->json($data);
        }
        return view('welcome');
    }

    public function calendarEvents(Request $request)
    {
        switch ($request->type) {
            case 'create':
                $event = Meetings::create([
                    'name' => $request->name,
                    'date_start' => $request->date_start,
                    'date_end' => $request->date_end,
                ]);

                return response()->json($event);
                break;

            case 'edit':
                $event = Meetings::find($request->id)->update([
                    'name' => $request->name,
                    'date_start' => $request->date_start,
                    'date_end' => $request->date_end,
                ]);

                return response()->json($event);
                break;

            case 'delete':
                $event = Meetings::find($request->id)->delete();

                return response()->json($event);
                break;

            default:
                # ...
                break;
        }
    }
}
