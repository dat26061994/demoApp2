<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';

    protected $fillable = ['avatar', 'name', 'age', 'address'];

    public $timestamps = true;

    public function getList()
    {
        $member = Member::orderBy('id', 'desc')->get();
        return $member;
    }

    public function findId($id)
    {
        $member = Member::find($id);
        return $member;
    }
}
