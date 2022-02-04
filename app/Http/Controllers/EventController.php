<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function events()
    {
        $events = Event::all();

        $response = $events->isEmpty() ? ['message' => 'not found'] : $events;

        return json_encode($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function active_events()
    {
        $events = Event::where('startAt', '<=',date("Y-m-d H:i:s"))->where('endAt', '>=',date("Y-m-d H:i:s"))->get();

        $response = $events->isEmpty() ? ['message' => 'not found'] : $events;

        return json_encode($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function events_create(Request $request)
    {
        $response = ['message' => 'fail'];

        if(!empty($request) && $request->has('name')){

            $start = $request->has('startAt') ? $request->startAt : date('Y-m-d H:i:s', strtotime('-1 week', strtotime(date("Y-m-d H:i:s"))));
            $end =  $request->has('endAt') ? $request->endAt : date('Y-m-d H:i:s', strtotime('+1 week', strtotime(date("Y-m-d H:i:s"))));

            $event = Event::create(['name'=>$request->name,'startAt'=>$start,'endAt'=>$end]);

            if(isset($event->id)) {
                $response['message'] = 'success';
                $response['id'] = $event->id;
                $response['slug'] = $event->slug;
                $response['startAt'] = $event->startAt;
                $response['endAt'] = $event->endAt;
            }
        }

        return json_encode($response);

        // Event::all();
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function event_get($id)
    {
        $event = Event::where('id',$id)->first();

        $response = $event === null ? ['message' => 'not found'] : $event;

        return json_encode($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function events_put(Request $request, $id)
    {
        $response = ['message' => 'fail'];

        if(!empty($request) && $id != ""){

            $update = [];

            if($request->has('name')){
                $update['name'] = $request->name;
            }

            if($request->has('startAt')){
                $update['startAt'] = $request->startAt;
            }

            if($request->has('endAt')){
                $update['endAt'] = $request->endAt;
            }

            if(!empty($update)){

                $event = Event::updateOrCreate(['id'=>$id],$update);

                if(isset($event->id)) {
                    $response['message'] = 'success';
                    $response['id'] = $event->id;
                    $response['slug'] = $event->slug;
                    $response['startAt'] = $event->startAt;
                    $response['endAt'] = $event->endAt;
                }
            }
        }

        return json_encode($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function events_patch(Request $request, $id)
    {
        $response = ['message' => 'fail'];

        $event = Event::where('id',$id)->first();

        if ($event !== null && ($request->has('name') || $request->has('startAt') || $request->has('endAt'))) {

            if($request->has('name')){
                $event->name = $request->name;
            }

            if($request->has('startAt')){
                $event->startAt = $request->startAt;
            }

            if($request->has('endAt')){
                $event->endAt = $request->endAt;
            }

            $event->save();

            if(isset($event->id)) {
                $response['message'] = 'success';
                $response['id'] = $event->id;
                $response['slug'] = $event->slug;
                $response['startAt'] = $event->startAt;
                $response['endAt'] = $event->endAt;
            }
        }

        return json_encode($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function events_delele($id)
    {

        $response = ['message' => 'fail'];

        $event = Event::where('id',$id)->first();

        if($event !== null){

            $event->delete();
            $response['message'] = 'success';
            $response['id'] = $event->id;

        }

        return json_encode($response);
    }
}
