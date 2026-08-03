<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisionMission;
use App\Models\Mission;
use App\Services\SecurityInputService;
use App\Services\Security\DangerousInputException;

class VisionMissionController extends Controller
{
    protected SecurityInputService $security;

    public function __construct(SecurityInputService $security)
    {
        $this->security = $security;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $vision = VisionMission::first();

        $missions = Mission::orderBy('display_order')->get();

        return view('admin.settings.visi-misi', compact(
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
            'vision' => [
                'required',
                function ($attribute, $value, $fail) {

                    $text = trim(strip_tags($value));

                    if ($text === '') {
                        $fail('Visi wajib diisi.');
                    }
                },
            ],
            'missions' => 'required|array|min:1',
            'missions.*' => 'required|string',
        ], [
            'vision.required' => 'Visi wajib diisi.',

            'missions.required' => 'Minimal satu misi wajib diisi.',
            'missions.array' => 'Data misi tidak valid.',
            'missions.min' => 'Minimal satu misi wajib diisi.',

            'missions.*.required' => 'Misi tidak boleh kosong.',
        ]);

        try {

            $visionText = $this->security->cleanHtml($request->vision);

            $missions = [];

            foreach ($request->missions as $mission) {

                $missions[] = $this->security->cleanText($mission);

            }

        } catch (DangerousInputException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());

        }

        $vision = VisionMission::first();

        if (!$vision) {
            $vision = new VisionMission();
        }

        $vision->vision = $visionText;
        $vision->save();

        Mission::where(
            'vision_mission_id',
            $vision->id
        )->delete();

        foreach ($missions as $index => $mission) {

            Mission::create([
                'vision_mission_id' => $vision->id,
                'mission' => $mission,
                'display_order' => $index + 1,
            ]);

        }

        return redirect()
            ->route('admin.settings.visi.index')
            ->with('success', 'Visi dan misi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
