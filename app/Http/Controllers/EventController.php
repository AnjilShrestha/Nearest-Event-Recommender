<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    //

    public function eventCategories(Request $request)
    {
        $search = $request->input('search', '');
        $query = EventCategory::query();
        if(!empty($search))
            $query->where('categories_name','like','%'.$search.'%');
        // searching
        $event_categories = $query->paginate(5);
        return view('admins.categorylist',['event_categories' => $event_categories,
        'search' => $search]);
    }
    public function storeeventcategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categories_name' => 'required|unique:eventcategories,categories_name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('show_add_modal', true);
        }
        EventCategory::create($request->all());
        return redirect()->back()->with('success', 'Category added successfully!');
    }

    public function updateeventcategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'categories_name' => 'required|string|max:255|unique:eventcategories,categories_name,' . $id,
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('show_edit_modal', $id);
        }
        // Validate the request data
        $validated = $validator->validated();
        $category = EventCategory::findOrFail($id);
        $category->update($validated);

        return redirect()->back()
            ->with('success', 'Category updated successfully!')
            ->with('show_edit_modal', null);

    }
    public function deleteeventcategory($id)
    {
        $category = EventCategory::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully!');
    }

    public function eventlist(){
        $events = Event::with(['organizer', 'category'])
            ->where('organizer_id', auth()->guard('eventorganizer')->user()->id )
            ->latest()
            ->paginate();
            
        return view('eventorganizer.eventlist', compact('events'));
    }

    public function eventCategory()
    {
        $categories = EventCategory::all();
        return view('eventorganizer.addevent', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'starttime' => 'required|date_format:H:i',
            'endtime' => 'required|date_format:H:i',
            'location' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_paid' => 'nullable|boolean',
            'price' => 'nullable|numeric|min:0',
            'category_id' => 'required',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('event_images', 'public');
            $validated['image'] = $imagePath;
        }
        $event=new Event();
        if ($request->has('features')) {
            $event->features = json_encode($request->features);
        }
        if ($request->has('tags')) {
            $event->tags = json_encode($request->tags); 
        }
        $validated['is_paid'] = $request->has('is_paid') ? 1 : 0;
        if (!$validated['is_paid']) {
            $validated['price'] = 0;
        }
        $event->fill($validated);
        //select organizer id 
        $event->organizer_id = auth()->guard('eventorganizer')->user()->id;
        // Save the event
        $event->save();

        return redirect()->back()->with('success', 'Event created successfully!');
    }

    public function eventdetails($id)
    {
        $eventdetails=Event::FindorFail($id);
        $categories=EventCategory::all();
        return view('eventorganizer.editevent',compact('eventdetails','categories'));
    }


    public function updateEvent(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'starttime' => 'required|date_format:H:i',
            'endtime' => 'required|date_format:H:i',
            'location' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_paid' => 'nullable|boolean',
            'price' => 'nullable|numeric|min:0',
            'category_id' => 'required',
        ]);

        $event = Event::findOrFail($id);
        if ($request->has('features')) {
            $event->features = json_encode($request->features);
        }
        if ($request->has('tags')) {
            $event->tags = json_encode($request->tags); 
        }
        // Handling image upload
        if ($request->hasFile('image')) {
            // Deleting the old image
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }

            // Uploading new image
            $imagePath = $request->file('image')->store('event_images', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['is_paid'] = $request->has('is_paid') ? 1 : 0;


        if (!$validated['is_paid']) {
            $validated['price'] = 0;
        }

        
        $event->update($validated);

        return redirect()->route('eventorganizer.events')
                        ->with('success', 'Event updated successfully!');
    }

    public function deleteEvent($id)
    {
        $event=Event::findOrFail($id);
        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }
        $event->delete();
        return redirect()->back()->with('success', 'Event deleted successfully!');
    }


}
