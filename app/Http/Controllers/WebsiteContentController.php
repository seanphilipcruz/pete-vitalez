<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Event;
use App\Models\Social;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebsiteContentController extends Controller
{
    public function retrieve_contact(Request $request) {
        $contact = Contact::whereNull('deleted_at')->latest()->count();

        if ($contact > 0) {
            $contact_info = Contact::whereNull('deleted_at')->latest()->first();

            $contact_info->image = $this->verify_photo($contact_info->image, 'about');

            return response()->json($contact_info);
        }

        return response()->json(false);
    }

    public function store_contact(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'min:5|required',
            'address' => 'min:10|required',
            'email' => 'email|required',
            'contact_number' => 'min:11|required',
            'description' => 'required',
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $contact = new Contact($validator->all());
        $contact->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Contact information has been saved'
        ], 201);
    }

    public function update_contact($id, Request $request) {
        $contact = Contact::findOrFail($id);

        $contact->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Contact information has been updated'
        ]);
    }

    public function retrieve_events(Request $request) {
        $events = Event::whereNull('deleted_at')->count();

        if ($events > 0) {
            $events = Event::whereNull('deleted_at')->get();

            foreach ($events as $event) {
                if ($event->start && $event->end) {
                    $year_start = date('Y', strtotime($event->start));
                    $year_end = date('Y', strtotime($event->end));

                    $month_start = date('m', strtotime($event->start));
                    $month_end = date('m', strtotime($event->end));

                    if ($month_start === $month_end && $year_start === $year_end) {
                        $event->start = date('M d', strtotime($event->start));
                        $event->end = date('d, Y', strtotime($event->end));
                    }

                    if ($month_start !== $month_end && $year_start === $year_end) {
                        $event->start = date('M d', strtotime($event->start));
                        $event->end = date('M d, Y', strtotime($event->end));
                    }

                    if ($year_start !== $year_end) {
                        $event->start = date('M d, Y', strtotime($event->start));
                        $event->end = date('M d, Y', strtotime($event->end));
                    }
                } elseif ($event->start) {
                    $event->start = date('M d, Y', strtotime($event->start));
                }
            }

            return response()->json($events);
        }

        return response()->json(false);
    }

    public function retrieve_event($id) {
        $event = Event::findOrFail($id);

        return response()->json($event);
    }

    public function store_event(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'min:4|required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $event = new Event($request->all());
        $event->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Event has been added'
        ], 201);
    }

    public function update_event($id, Request $request) {
        $event = Event::findOrFail($id);

        $event->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Event has been updated'
        ]);
    }

    public function delete_event($id) {
        $event = Event::findOrFail($id);

        $event->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Event has been removed'
        ]);
    }

    public function retrieve_social_accounts(Request $request) {
        $socials = Social::latest()->count();

        if ($socials > 0) {
            $socials = Social::whereNull('deleted_at')
                ->orderBy('order')
                ->get();

            return response()->json($socials);
        }

        return response()->json(false);
    }

    public function retrieve_social_account($id) {
        $social = Social::findOrFail($id);

        return response()->json($social);
    }

    public function store_social_accounts(Request $request) {
        $validator = Validator::make($request->all(), [
            'site' => 'min:4|required',
            'url' => 'url|required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $social = new Social($request->all());
        $social->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Site has been added to your contact information'
        ], 201);
    }

    public function update_social_accounts($id, Request $request) {
        $social = Social::findOrFail($id);

        $social->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Site contact information has been updated'
        ]);
    }

    public function delete_social_accounts($id) {
        $social = Social::findOrFail($id);

        $social->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Site contact information has been removed'
        ]);
    }
}
