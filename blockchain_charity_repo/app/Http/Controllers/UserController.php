<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function profile()
    {
        return view('layouts.profile');
    }

    public function updateProfile(UserRequest $request)
    {
        $notification = array(
            'message' => 'Update Profile Successfully',
            'alert-type' => 'success'
        );
        $data = $request->only('name', 'email', 'home_address', 'phone', 'image_card_front', 'image_card_back');
        $userAddress = Auth::user()->user_address;
        $this->userRepository->updateUser($userAddress, $data);
        return back()->with($notification);
    }

    public function changePassword(Request $request)
    {
        $userAddress = Auth::user()->user_address;
        $password = $request->new_password;
        $this->userRepository->updateUser($userAddress, [
            'password' => bcrypt($password)
        ]);
        $notification = array(
            'message' => 'Change Password Successfully',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }
}