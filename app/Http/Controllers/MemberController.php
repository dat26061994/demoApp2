<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function getList()
    {
        $member = new Member();
        return $member->getList();
    }

    public function postAdd(Request $request)
    {
        $member = new Member();
        $randomString = str_random(10);
        $member->name = $request->name;
        $member->age = $request->age;
        $member->address = $request->address;
        if (!empty($request->File('file'))) {
            $fileName = $randomString . '-' . $request->file('file')->getClientOriginalName();
            $member->avatar = $fileName;
            $request->file('file')->move('public/upload/', $fileName);
        } else {
            $member->avatar = "";
        }
        $member->save();
        return "Success";
    }

    public function getEdit($id)
    {
        $member = new Member();
        return $member->findId($id);
    }

    public function postEdit($id, Request $request)
    {
        $memberModel = new Member();
        $member = $memberModel->findId($id);
        $member->avatar = "";
        $member->name = $request->name;
        $member->age = $request->age;
        $member->address = $request->address;
        $member->save();
        return "Success";
    }

    public function getDelete($id)
    {
        $memberModel = new Member();
        $member = $memberModel->findId($id);
        $member->delete();
    }
}
