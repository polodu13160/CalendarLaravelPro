<?php

namespace App\Http\Services;

use App\Models\Event;
use Carbon\Carbon;

class EventService
{
    protected $user;
    public function __construct($user)
    {
        $this->user = $user;
    }
    public function create($data) {

        $event = new Event($data);
        $event->save();
        return $event;
    }

    public function update($id, $data) {

        $event = Event::find($id);
        $event->fill($data);
        $event->save();
        return $event;
    }

    public function allEvents($filters) {

        $eventQuery = Event::query();
        $eventQuery->where('user_id', $this->user->id);
        if ($filters['start']) {
            $eventQuery->where('start', '>=', $filters['start']);
        }
        if ($filters['end']) {
            $eventQuery->where('end', '<=', $filters['end']);
        }
        $events = $eventQuery->get();
        $data = [];
        foreach ($events as $event) {
            if (!(int)$event['is_all_day']) {
                $event['allDay'] = false;
                $event['start'] = Carbon::createFromTimeStamp(strtotime($event['start']))->toDateTimeString();
                $event['end'] = Carbon::createFromTimeStamp(strtotime($event['end']))->toDateTimeString();
                $event['endDay'] = $event['end'];
                $event['startDay'] = $event['start'];
            }
            else {
                $event['allDay'] = true;
                $event['endDay'] = Carbon::createFromTimeStamp(strtotime($event['end']))->toDateString();
                $event['end'] = Carbon::createFromTimeStamp(strtotime($event['end']))->addDay()->toDateString();
                $event['startDay'] = $event['start'];
            }
            $event['event_id'] = $event['id'];
            $event['borderColor'] = "#D2D5B7";
            $event['backgroundColor'] = "#3C6F27";
            array_push($data, $event);
        }
        return $data;
    }
}
