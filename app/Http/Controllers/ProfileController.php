<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    public function list(){
        return view('profile.list', [
            'users' => User::all(),
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request, User $user = null): View
    {
        if(empty($user)){
            $user = $request->user();
        }
            
        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, User $user = null): RedirectResponse
    {
        if(empty($user)){
            $user = $request->user();
        }
        if($this->accessible($user)){
            $user->fill($request->all());

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            // return Redirect::route('profile.edit')->with('status', 'profile-updated');
        }
        return back();
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

    private function accessible($user){
        $current_user = auth()->user();
        if('admin' === $current_user->role || $current_user === $user){
            return true;
        }
        return false;
    }
}
