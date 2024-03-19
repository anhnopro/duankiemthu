<?php

namespace App\Models\client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class UserClientModel extends Model
{
    use HasFactory;
    public function getDataUser($email, $pass) {
        $result = DB::table('user')
            ->where('email', $email)
            ->where('password',$pass)->first();
        return $result;
    }
    public function checkExistUser($email) {
        $result = DB::table('user')->where('Email',$email)->first();

        return ($result ? 1 : 0);
    }
    public function registerUser($Email, $nickName, $password) {
        $data = [
            'Email' => $Email,
            'nickName' => $nickName,
            'password' => $password
        ];
        DB::table('user')->insert($data);
    }
    
}
