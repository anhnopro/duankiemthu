<?php

namespace App\Models\client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class CommentModel extends Model
{
    use HasFactory;
    public function insertComment($ndCm, $idUser, $idLoaiSp) {
        DB::table('comment')->insert([
            'ndComment' => $ndCm,
            'idUser' => $idUser,
            'idLoaiSp' => $idLoaiSp
        ]);
    }
    public function getInfoCommentIdLoaiSp($idLoaiSp) {
        $result = DB::table('loaisanpham')->select(
            'user.Avatar',
            'user.nickName',
            'comment.ndComment',
            'comment.ngayComment',
        )
            ->join('comment', 'loaisanpham.idLoaiSp', '=', 'comment.idLoaiSp')
            ->join('user', 'comment.idUser', '=', 'user.idUser')
            ->where('loaisanpham.idLoaiSp', $idLoaiSp)
            ->get()
            ->toArray();
    
        return array_map(function ($currentVal) {
            return (array) $currentVal;
        }, $result);
    }
    
}
