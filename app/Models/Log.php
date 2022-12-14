<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    static public function logCreate($message){
        Log::create([
            'message' => $message,
            'user_id' => \Auth::user()->id
        ]);
    }

    static public function logCreateApi($message, $request){
        $token = $request->header('Authorization');
        $token = explode(' ', $token)[1];
        $user = User::where('api_token', $token)->first();

        Log::create([
            'message' => $message,
            'user_id' => $user->id
        ]);
    }
}
