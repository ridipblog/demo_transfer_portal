<?php

namespace App\Http\Controllers\root_access;

use App\Http\Controllers\Controller;
use App\Models\verification\appointing_authorities;
use App\our_modules\reuse_modules\ReuseModule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RootProcessController extends Controller
{
    public function sendMesssageToAuthrities(Request $request){
        try{
            $authrities=appointing_authorities::where('phone', 'REGEXP', '^[0-9]+$')->get()->pluck('phone');
            $numbers=[];
            dd("No Used");
            foreach($authrities as $auth){
                ReuseModule::sendInfoAuthritesMes($auth);
                $new_array[]=$auth;
            Storage::disk('local')->put('phone_nunbers.json', json_encode($new_array, JSON_PRETTY_PRINT));

            }
            $data=Storage::disk('local')->get('phone_nunbers.json');
            $phone_numbers=json_decode($data,true);
            dd($phone_numbers);
        }catch(Exception $err){
            dd("Server error please try later ");
        }

    }
}
