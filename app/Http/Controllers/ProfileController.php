<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function myProfile()
    {
        $data["title"] = "My Profile";
        $data["css"] = "profile";

        return view('/profile/my_profile', $data);
    }

    public function editProfileGet()
    {
        $data["title"] = "Edit Profile";
        $data["css"] = "profile";

        return view("/profile/edit_profile", $data);
    }

    public function editProfilePost(Request $request, User $user)
    {
        $rules = [
            'fullname' => 'required|max:255',
            'phone' => 'required|numeric',
            'address' => 'required',
        ];


        if (auth()->user()->username != $request->username) {
            $rules['username'] = 'required|max:15|unique:users,username';
        } else {
            $rules['username'] = 'required|max:15';
        }

        $validatedData = $request->validate($rules);

        try {
            $user->fill($validatedData);
            if ($user->isDirty()) {
                $user->save();

                $message = "Your profile has been updated!";

                myFlasherBuilder(message: $message, success: true);
                return redirect("/home");
            } else {
                $message = "There is no changes detected!";

                myFlasherBuilder(message: $message, failed: true);
                return redirect("/profile/edit_profile");
            }
        } catch (Exception $exception) {
            return abort(500);
        }
    }
}
