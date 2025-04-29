<?php

namespace App\Http\Controllers;

use Stevebauman\Location\Facades\Location;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventCategory;


class EventRecommender extends Controller
{
    //

    public function eventlist(Request $request)
    {
        // Step 1: Get location from session or query string 
        $userLocation = session('user_location', [
            'lat' => $request->query('lat', 28.6139),
            'lng' => $request->query('lng', 77.2090)
        ]);

        $userLat = $userLocation['lat'];
        $userLng = $userLocation['lng'];

        if (!$userLat || !$userLng) {
            return response()->json(['error' => 'Location not set'], 400);
        }

        // Step 2: Define the Haversine formula
        $haversine = function ($lat1, $lng1, $lat2, $lng2, $earthRadius = 6399) {
            $latFrom = deg2rad($lat1);
            $lngFrom = deg2rad($lng1);
            $latTo = deg2rad($lat2);
            $lngTo = deg2rad($lng2);

            $latDelta = $latTo - $latFrom;
            $lngDelta = $lngTo - $lngFrom;

            $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +cos($latFrom) * cos($latTo) * pow(sin($lngDelta / 2), 2)));
            return $angle * $earthRadius;
        };

        $radiusInKm = 50;

        // Step 3: Fetch all events with relationships
        $allEvents = Event::with(['category', 'organizer'])->get();

        // Step 4: Filter and add distance using the closure
        $events = $allEvents->filter(function ($event) use ($userLat, $userLng, $radiusInKm, $haversine) {
            if (!$event->latitude || !$event->longitude) return false;

            $distance = $haversine($userLat, $userLng, $event->latitude, $event->longitude);
            $event->distance = $distance;

            return $distance <= $radiusInKm;
        })->sortBy('distance')->values();

        return view('welcome',["events"=>$events]);
    }

    public function details($id)
    {
        $today=now()->toDateString();
        $event = Event::with(['category', 'organizer'])->findOrFail($id);

        $otherEvents = Event::with(['category', 'organizer'])
            ->where('id', '!=', $event->id)
            ->where('event_date', '>', $today)
            ->get();

        $similarEvents = [];

        foreach ($otherEvents as $otherEvent) {
            $similarity = $this->cosineSimilarity(
                json_decode($event->tags, true),
                json_decode($otherEvent->tags, true)
            );
            $similarEvents[] = [
                'event' => $otherEvent,
                'similarity' => $similarity,
            ];
        }
        usort($similarEvents, function ($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });
        $similarEvents = array_filter($similarEvents, function ($item) {
            return $item['similarity'] > 0.5;
        });
        return view('eventdetails',['event' => $event,'events'=>$similarEvents]);
    }
    private function cosineSimilarity($tags1, $tags2)
    {
        $tags1 = array_map('strtolower', $tags1);
        $tags2 = array_map('strtolower', $tags2);
    
        $allWords = array_unique(array_merge($tags1, $tags2));
    
        $vec1 = [];
        $vec2 = [];
    
        foreach ($allWords as $word) {
            $vec1[] = in_array($word, $tags1) ? 1 : 0;
            $vec2[] = in_array($word, $tags2) ? 1 : 0;
        }
    
        $dotProduct = array_sum(array_map(fn($a, $b) => $a * $b, $vec1, $vec2));
        $magnitude1 = sqrt(array_sum(array_map(fn($x) => $x ** 2, $vec1)));
        $magnitude2 = sqrt(array_sum(array_map(fn($x) => $x ** 2, $vec2)));
    
        return ($magnitude1 * $magnitude2) == 0 ? 0 : $dotProduct / ($magnitude1 * $magnitude2);
    }
    
    public function eventsearch(Request $request)
    {
        
        $userLat = $request['latitude']?$request['latitude']:27.7172;
        $userLng = $request['longitude']?$request['longitude']:85.3240;
        $search = $request->input('search', '');

        $query = Event::with(['category', 'organizer']);


        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->whereHas('category', function($catQuery) use ($search) {
                    $catQuery->where('name', 'like', '%'.$search.'%');
                })
                ->orWhere('title', 'like', '%'.$search.'%');
            });
        }

        if (!$userLat || !$userLng) {
            return response()->json(['error' => 'Location not set'], 400);
        }

        // Haversine formula (closure)
        $haversine = function ($lat1, $lng1, $lat2, $lng2, $earthRadius = 6371) {
            $latFrom = deg2rad($lat1);
            $lngFrom = deg2rad($lng1);
            $latTo = deg2rad($lat2);
            $lngTo = deg2rad($lng2);

            $latDelta = $latTo - $latFrom;
            $lngDelta = $lngTo - $lngFrom;

            $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +cos($latFrom) * cos($latTo) * pow(sin($lngDelta / 2), 2)));
            return $angle * $earthRadius;
        };

        $radiusInKm = 50;

        $allEvents = $query->paginate(10); 

        $filteredEvents = $allEvents->filter(function ($event) use ($userLat, $userLng, $radiusInKm, $haversine) {
            if (!$event->latitude || !$event->longitude) return false;

            $distance = $haversine($userLat, $userLng, $event->latitude, $event->longitude);
            $event->distance = $distance; 

            return $distance <= $radiusInKm;
        })->sortBy('distance')->values();

        return view('events', ["events" => $filteredEvents]);
    }

}
