<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Bio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{   
    function uploadToSupabase($file)
    {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $bucket = env('SUPABASE_BUCKET');
        $url = env('SUPABASE_URL') . "/storage/v1/object/$bucket/$fileName";

        $client = new Client();
        $response = $client->put($url, [
            'headers' => [
                'apikey' => env('SUPABASE_API_KEY'),
                'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
                'Content-Type' => $file->getMimeType(),
            ],
            'body' => fopen($file->getRealPath(), 'r'), // lebih aman dari pada file_get_contents
        ]);

        if ($response->getStatusCode() === 200) {
            return env('SUPABASE_URL') . "/storage/v1/object/public/$bucket/$fileName";
        }

        return null;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $bio = Bio::where('user_id', auth()->id())->first();
        return view('profile.edit', [
            'user' => $request->user(),
            'bio' => $bio,
        ]);        
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = auth()->user();

        // Simpan email ke User
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function settingEdit(Request $request): View
    {
        return view('profile.usersetting', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function settingUpdate(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($request->hasFile('avatar')) {
            $avatarUrl = $this->uploadToSupabase($request->file('avatar'));
            $user->avatar = $avatarUrl;
        }


        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('setting.edit')->with('status', 'profile-updated');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
