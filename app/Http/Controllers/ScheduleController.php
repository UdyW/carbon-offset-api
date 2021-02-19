<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function carbonOffsetSchedule(Request $request)
    {
        $this->validate($request,[
            'subscriptionStartDate' => 'required|date_format:Y-m-d|before_or_equal:today',
            'scheduleInMonths' => 'required|integer|between:0,36'
        ]);

        $startdate =  \DateTime::createFromFormat('Y-m-d', $request->query('subscriptionStartDate'));

        $response_array = [];
        for($i=$startdate->format('m')+1;$i<=$request->query('scheduleInMonths')+1;$i++){

            if(checkdate($i,$startdate->format('d'),$startdate->format('Y'))) {
                array_push($response_array, $startdate->format('Y') . '-' . $i . '-' . $startdate->format('d'));
            }
            else{
                $nextdate =  \DateTime::createFromFormat('Y-m-d',$startdate->format('Y') . '-' . $i . '-1') ;
                array_push($response_array, $nextdate->format( 'Y-m-t' ));
            }
        }

        return response()->json($response_array);
    }
}
