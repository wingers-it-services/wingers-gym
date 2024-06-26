<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserNotificationController extends Controller
{
    protected $notification;

    public function __construct(UserNotification $notification)
    {
        $this->notification = $notification;
    }

    public function viewNotification(Request $request)
    {
        $status = null;
        $message = null;
        $notifications = $this->notification->all();

        return view('admin.userNotification', compact('status', 'message','notifications'));
    }

    public function addNotification(Request $request)
    {
        
        $data = $request->all();
        $this->notification->create([
            'name'  => $data['name'],
            'description'  => $data['description'],
        ]);
        return redirect()->back()->with('status','success')->with('message','User Notification Added Successfully');
   
    }

    public function deleteNotification($uuid)
    {
        $notification = $this->notification->where('uuid', $uuid)->firstOrFail();
        $notification->delete();
        return redirect()->route('viewNotification')->with('success', 'Notification deleted successfully!');
    }
       

}
