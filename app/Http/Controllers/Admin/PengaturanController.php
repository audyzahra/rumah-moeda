<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\VisionMission;
use App\Models\Mission;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        $vision = VisionMission::first();

        $missions = Mission::orderBy('display_order')->get();

        return view('admin.pengaturan.pengaturan', compact(
            'setting',
            'vision',
            'missions'
        ));
    }
    public function updateVisiMisi(Request $request)
{
    $request->validate([
        'vision' => 'required',
        'missions' => 'required|array',
        'missions.*' => 'required'
    ]);

    $vision = VisionMission::first();

    if (!$vision) {
        $vision = new VisionMission();
    }

    $vision->vision = $request->vision;
    $vision->save();

    Mission::where('vision_mission_id', $vision->id)->delete();

    foreach ($request->missions as $index => $mission) {

        Mission::create([
            'vision_mission_id' => $vision->id,
            'mission' => $mission,
            'display_order' => $index + 1,
        ]);

    }

    return redirect()
        ->route('admin.pengaturan')
        ->with('success', 'Visi dan Misi berhasil diperbarui.');
}
}

