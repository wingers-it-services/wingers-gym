<?php

namespace App\Traits;

use App\Models\Gym;
use Illuminate\Support\Facades\Session;

trait SessionTrait
{

    public function storeGymSession(Gym $gym)
    {
        session(['uuid' => $gym->uuid]);
    }

    public function getGymSession()
    {
        $uuid = Session::get('uuid');

        return
            [
                'uuid' => $uuid
            ];
    }

}
