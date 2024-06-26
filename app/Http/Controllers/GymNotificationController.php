<?php

namespace App\Http\Controllers;

use App\Models\GymNotification;
use Illuminate\Http\Request;


class GymNotificationController extends Controller
{
    protected $notification;

    public function __construct(GymNotification $notification)
    {
        $this->notification = $notification;
    }

    public function viewGymNotification(Request $request)
    {
        $status = null;
        $message = null;
        $notifications = $this->notification->all();

        return view('admin.gymNotification', compact('status', 'message','notifications'));
    }

    public function addGymNotification(Request $request)
    {
        
        $data = $request->all();
        $this->notification->create([
            'name'  => $data['name'],
            'description'  => $data['description'],
        ]);
        return redirect()->back()->with('status','success')->with('message','User Notification Added Successfully');
   
    }

    public function deleteGymNotification($uuid)
    {
        $notification = $this->notification->where('uuid', $uuid)->firstOrFail();
        $notification->delete();
        return redirect()->route('viewGymNotification')->with('success', 'Notification deleted successfully!');
    }

}
