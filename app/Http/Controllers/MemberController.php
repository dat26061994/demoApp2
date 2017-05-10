<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Member;
use Illuminate\Http\Request;
use File;

class MemberController extends Controller
{
    public function getList()
    {
        $member = new Member();
        return $member->getList();
    }

    public function postAdd(MemberRequest $request)
    {
        $member = new Member();
        $randomString = str_random(10);
        $member->name = $request->name;
        $member->age = $request->age;
        $member->address = $request->address;
        if (!empty($request->file('file'))) {
            $this->validate($request, [
                'file' => 'mimes:jpg,jpeg,png,gif|max:10240'
            ],
                [
                    'file.mimes' => 'Please choose file image(jpg,jpeg,png,gif).',
                    'file.max' => 'File too larg.'
                ]);
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

    public function postEdit($id, MemberRequest $request)
    {

        $memberModel = new Member();
        $member = $memberModel->findId($id);
        $randomString = str_random(10);
        $member->name = $request->name;
        $member->age = $request->age;
        $member->address = $request->address;
        $imgCurrent = 'public/upload/' . $request->currentImage;
        if (!empty($request->file('file'))) {
            $this->validate($request, [
                'file' => 'mimes:jpg,jpeg,png,gif|max:10240'
            ],
                [
                    'file.mimes' => 'Please choose file image(jpg,jpeg,png,gif).',
                    'file.max' => 'File too larg.'
                ]);
            $fileName = $randomString . '-' . $request->file('file')->getClientOriginalName();
            $member->avatar = $fileName;
            $request->file('file')->move('public/upload/', $fileName);
            if (File::exists($imgCurrent)) {
                File::delete($imgCurrent);
            }
        }
        $member->save();
        return "Success";
    }

    public function getDelete($id)
    {
        $memberModel = new Member();
        $member = $memberModel->findId($id);
        File::delete('public/upload/' . $member->avatar);
        $member->delete();
    }
}
