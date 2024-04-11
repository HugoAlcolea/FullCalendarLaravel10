<?php
// app/Http/Controllers/EventController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\CreateEventRequest; 
use App\Http\Requests\UpdateEventRequest;
use App\Http\Services\EventService;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('events.list');
    }

    public function refetchEvents(Request $request){
        $eventService = new EventService(auth()->user());
        $eventData = $eventService->allEvents($request->all());
        return response()->json($eventData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonRequest
     */
    public function store(CreateEventRequest $request) 
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $eventService = new EventService(auth()->user());
        $event = $eventService->create($data);
        if($event){
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateEventRequest $request, string $id)
    {
        $data = $request->all();
        $eventService = new EventService(auth()->user());
        $event = $eventService->update($id, $data);
        
        if ($event) {
            return response()->json([
                "success" => true
            ]);
        } else {
            return response()->json([
                "success" => false
            ]);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        try {
            $event->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            return response()->json(['success' => false]);
        }
    }


    public function resizeEvent(Request $request, $id){
        $data = $request->all();
        
        if (isset($data['is_all_day']) && $data['is_all_day'] == 1) {
            $data['end'] = Carbon::createFromTimestamp(strtotime($data['end']))->endOfDay(-1)->toDateTimeString();
        }
        $eventService = new EventService(auth()->user());
        $event = $eventService->update($id, $data);
        if ($event) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }
    


}