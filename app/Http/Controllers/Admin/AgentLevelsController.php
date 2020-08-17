<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AgentLevelRequest;
use App\Models\AgentLevel;
use App\Http\Controllers\Controller;

class AgentLevelsController extends Controller
{
    public function index()
    {
        $agentLevels = AgentLevel::latest()->get();
        return view("admin.agentLevel.index", compact("agentLevels"));

    }

    public function store(AgentLevelRequest $request)
    {
        if ($request->agent_percent + $request->mabino_percent + $request->admin_percent != 100) {
            flash_message("خطا !!!!مجموع درصد ها باید برابر 100 باشد !", "danger");
            return back();
        }

        /*upload image */
        if ($request->hasFile("image")) {
            $imageFile = $request->file("image");
            $imageName = time();
            $imageName .= "." . $imageFile->getClientOriginalExtension();
            $imagePath = public_path() . config("UploadPath.agent_level_path");
            $imageFile->move($imagePath, $imageName);
        }
        $newLevel = AgentLevel::create([
            'title' => $request->title,
            'price' => $request->price / 10,
            "image" => $imageName,
            'my_percent' => $request->agent_percent,
            'mabino_percent' => $request->mabino_percent,
            'pageowner_percent' => $request->admin_percent,
        ]);

        if ($newLevel) {
            flash_message("با موفقیت ثبت شد !", "success");
        } else {
            flash_message("خطا !!!!!", "danger");
        }

        return back();
    }


    public function edit(AgentLevel $agentLevelItem)
    {
        $agentLevels = AgentLevel::latest()->get();
        return view("admin.agentLevel.index", compact("agentLevels", "agentLevelItem"));
    }

    public function update(AgentLevel $agentLevelItem, AgentLevelRequest $request)
    {

        if ($request->hasFile("image")) {
            $imageFile = $request->file("image");
            $imageName = time();
            $imageName .= "." . $imageFile->getClientOriginalExtension();
            $imagePath = public_path() . config("UploadPath.agent_level_path");
            $imageFile->move($imagePath, $imageName);
        }else{
            $imageName = $agentLevelItem->image;
        }
        $result = $agentLevelItem->update([
            'title' => $request->title,
            'price' => $request->price / 10,
            'my_percent' => $request->agent_percent,
            "image" => $imageName,
            'mabino_percent' => $request->mabino_percent,
            'pageowner_percent' => $request->admin_percent
        ]);

        if ($result) {
            flash_message("با موفقیت بروزرسانی شد !", "success");
        } else {
            flash_message("خطا !!!!!", "danger");
        }

        return redirect()->route('admin.agentLevel.index');

    }

    public function changeStatus(AgentLevel $agentLevelItem)
    {
        $oldStatus = $agentLevelItem->status;
        if($oldStatus == AgentLevel::ACTIVE){
            $newStatus = AgentLevel::INACTIVE;
        }else{
            $newStatus = AgentLevel::ACTIVE;
        }
        $result = $agentLevelItem->update([
            'status'=>$newStatus,
        ]);

        if ($result) {
            flash_message("با موفقیت بروزرسانی شد !", "success");
        } else {
            flash_message("خطا !!!!!", "danger");
        }
        return back();
    }
}
