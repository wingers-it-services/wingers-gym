<?php

namespace App\Http\Controllers;

use App\Models\UserLebel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LebelController extends Controller
{
    protected $userLebel;

    public function __construct(
        UserLebel $userLebel
    ) {
        $this->userLebel = $userLebel;
    }

    public function viewAddLebel()
    {
        $status = null;
        $message = null;
        $lebels = $this->userLebel->get();
        return view('GymOwner.add-lebel', compact('status', 'message', 'lebels'));
    }

    public function addLebel(Request $request)
    {
        try {
            $request->validate([
                'lebel'  => 'required',
            ]);
            $this->userLebel->addLebel($request->all());
            return redirect()->back()->with('status', 'success')->with('message', 'Level added successfully.');
        } catch (\Throwable $th) {
            Log::error("[LebelController][addLevel] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error adding level. ' . $th->getMessage());
        }
    }

    public function updateLebel(Request $request)
    {
        try {
            $request->validate([
                'lebel' => 'required',
            ]);
           
            $data = $request->all();

            $isLebelUpdate = $this->userLebel->updateLebel($data);

            if (!$isLebelUpdate) {
                return redirect()->back()->with('status', 'error')->with('message', 'Error while updating lebel.');
            }
            return redirect()->back()->with('status', 'success')->with('message', 'Level Updated successfully.');
        } catch (Exception $e) {
            Log::error('[LebelController][updateLevel] Error updating lebel ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'error while updating lebel.');
        }
    }

    public function deleteLebel($uuid)
    {
        $lebel = $this->userLebel->where('uuid', $uuid)->firstOrFail();

        $lebel->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'Lebel deleted successfully!');
    }
}
