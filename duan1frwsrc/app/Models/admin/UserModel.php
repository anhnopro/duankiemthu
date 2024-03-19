<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class UserModel extends Model
{
    use HasFactory;

    public function checkAdmin($userName, $pass) {
        $result = DB::table('user')->select('vaiTro')
            ->where('userName', $userName)
            ->where('password',$pass)->first();
        return $result;
    }
}
