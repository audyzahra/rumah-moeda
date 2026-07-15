<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\VisionMission;
use App\Models\Mission;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        $vision = VisionMission::first();

        $missions = Mission::orderBy('display_order')->get();

        $users = User::orderBy('id')->get();

        return view('admin.pengaturan.pengaturan', compact(
            'setting',
            'vision',
            'missions',
            'users'
        ));
    }
}