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
        if (isset($request->file) && $request->file !== 'undefined' && $request->file && $request->file !== 'null') {
            $fileType = $request->file->getClientMimeType();
            if ($fileType === 'image/png' || $fileType === 'image/jpg' || $fileType === 'image/jpeg' || $fileType === 'image/gif') {
                $fileSize = $request->file->getSize();
                if ($fileSize < 10485760) {
                    $fileName = $randomString . '-' . $request->file('file')->getClientOriginalName();
                    $member->avatar = $fileName;
                    $request->file('file')->move('public/upload/', $fileName);
                } else {
                    return response('File to larg', 500);
                }
            } else {
                return response('File not form format', 500);
            }
        } else {
            $member->avatar = "default_avatar.png";
        }
        $member->save();
        $data = $member->getList();
        return response()->json($data);
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
        $imgCurrent = 'public/upload/' . $member->avatar;
        if (isset($request->file) && $request->file !== 'undefined' && $request->file && $request->file !== 'null') {
            $fileType = $request->file->getClientMimeType();
            if ($fileType === 'image/png' || $fileType === 'image/jpg' || $fileType === 'image/jpeg' || $fileType === 'image/gif') {
                $fileSize = $request->file->getSize();
                if ($fileSize < 10485760) {
                    $fileName = $randomString . '-' . $request->file('file')->getClientOriginalName();
                    $member->avatar = $fileName;
                    $request->file('file')->move('public/upload/', $fileName);
                    if (File::exists($imgCurrent) && $imgCurrent !== 'public/upload/default_avatar.png') {
                        File::delete($imgCurrent);
                    }
                } else {
                    return response('File to large', 500);
                }
            } else {
                return response('File not form format', 500);
            }
        }
        $member->save();
        $data = $memberModel->getList();
        return response()->json($data);
    }

    public function getDelete($id)
    {
        $memberModel = new Member();
        $member = $memberModel->findId($id);
        if ($member->avatar !== 'default_avatar.png') {
            File::delete('public/upload/' . $member->avatar);
        }
        $member->delete();
        $data = $memberModel->getList();
        return response()->json($data);
    }
}
