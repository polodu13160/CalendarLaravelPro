<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\Meetings;
use Illuminate\Http\JsonResponse;



class FullCalendarController extends Controller

{

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function index(Request $request)

    {



        if ($request->ajax()) {



            $data = Meetings::whereDate('date_start', '>=', $request->start)

                ->whereDate('date_end',   '<=', $request->end)

                ->get(['id', 'name', 'date_start', 'date_end', 'description']);



            return response()->json($data);
        }



        return view('fullcalendar');
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function ajax(Request $request): JsonResponse

    {



        switch ($request->type) {

            case 'add':

                $meeting = Meetings::create([

                    'name' => $request->name,

                    'date_start' => $request->date_start,

                    'date_end' => $request->date_end,

                ]);



                return response()->json($meeting);

                break;



            case 'update':

                $meeting = Meetings::find($request->id)->update([

                    'name' => $request->name,

                    'date_start' => $request->date_start,

                    'date_end' => $request->date_end,

                ]);



                return response()->json($meeting);

                break;



            case 'delete':

                $meeting = Meetings::find($request->id)->delete();



                return response()->json($meeting);

                break;



            default:

                # code...

                break;
        }
    }
}
