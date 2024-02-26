<?php



namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Http\Request;

use App\Models\Event;

use Illuminate\Http\JsonResponse;



class FullCalenderController extends Controller

{

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function index(Request $request)

    {



        if ($request->ajax()) {



            $data = Event::whereDate('start', '>=', $request->start)

                ->whereDate('end',   '<=', $request->end)

                ->get(['id', 'title', 'start', 'end']);



            return response()->json($data);
        }



        return view('fullcalender');
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

                $event = Event::create([

                    'title' => $request->title,

                    'start' => $request->start,

                    'end' => $request->end,

                ]);



                return response()->json($event);

                break;



            case 'update':

                $event = Event::find($request->id)->update([

                    'title' => $request->title,

                    'start' => $request->start,

                    'end' => $request->end,

                ]);



                return response()->json($event);

                break;



            case 'delete':

                $event = Event::find($request->id)->delete();



                return response()->json($event);

                break;



            default:

                # code...

                break;
        }
    }
    public function getTest(){
        // $evenement=new Evenement();
        // $evenement->title="test2";
        // $evenement->content="Lorem ipsum dolor sit amet consectetur, adipisicing elit. Adipisci quidem distinctio delectus beatae facere perspiciatis sint eligendi aperiam porro. Dolores quod vitae ullam similique eveniet, laborum fuga reiciendis tenetur in.";
        // $evenement->startTime = "09:00:00"; // Format heure HH:MM:SS
        // $evenement->endTime = "10:00:00"; // Format heure HH:MM:SS
        // $evenement->startDay = "2024-02-27"; // Format date YYYY-MM-DD
        // $evenement->endDay = "2024-02-28"; // Format date YYYY-MM-DD
        // $evenement->save();
        // dd(session()->all());
        return view('test');
    }
    public function postTest(Request $request){
        // dd($request->all());
        $evenement= Evenement::create([
            'title'=> $request->input('title'),
            'content' => $request->input('content'),
            'startDay' => $request->input('startDay'),
            'endDay' => $request->input('endDay'),
            'startTime' => $request->input('startTime'),
            'endTime' => $request->input('endTime'),
        ]);
        return redirect()->route('test')->with('success',"l'event est bien créé");
    }
}
