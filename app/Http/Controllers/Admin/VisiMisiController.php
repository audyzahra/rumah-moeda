<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisionMission;
use App\Models\Mission;

class VisiMisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $vision = VisionMission::first();

        $missions = Mission::orderBy('display_order')->get();

        return view('admin.pengaturan.visi-misi', compact(
            'vision',
            'missions'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
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
        ->route('admin.pengaturan.visi.index')
        ->with('success', 'Visi dan Misi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
