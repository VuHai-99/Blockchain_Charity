<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Services\UploadImageService;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    private $uploadImageService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UploadImageService $uploadImageService)
    {
        $this->middleware('guest');
        $this->uploadImageService = $uploadImageService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'address' => ['required', 'string'],
            'phone' => ['required']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'phone' => $data['phone'],
            'role' => $data['role'],
            'image_card_front' => $data['image_card_front'],
            'image_card_back' => $data['image_card_back']
        ]);
    }

    public function storeAccount(RegisterRequest $request)
    {

        // $response = Http::get('localhost:3000/create/newAccount'); 
        // $newAccount = $response->json();
        // dd($newAccount);

        $data = $request->only('name', 'email', 'address', 'phone');
        $data['user_address'] = $request->wallet_address;
        $data['password'] = bcrypt($request->password);
        $data['home_address'] = $request->address;
        $data['phone'] = $request->phone;
        $data['role'] = $request->role;
        $data['wallet_type'] = $request->wallet_type;
        // $data['wallet_type'] = 0;
        $data['image_card_front'] =  $this->uploadImageService->upload($request->image_card_front);
        $data['image_card_back'] = $this->uploadImageService->upload($request->image_card_back);
        if ($request->wallet_type == 0) {

            $data['user_address'] = $request->wallet_address;
            User::create($data);
            if ($request->role == 1) {
                return redirect(route('host.home'));
            } else {
                return redirect(route('donator.home'));
            }
        } elseif ($request->wallet_type == 1) {
            $response = Http::get('localhost:3000/create/newAccount');
            $newAccount = $response->json();
            $data['user_address'] = $newAccount['address'];
            $data['private_key'] = substr($newAccount['privateKey'], 2);
            User::create($data);
            if ($request->role == 1) {
                return redirect(route('host.home'));
            } else {
                return redirect(route('donator.home'));
            }
        }
    }
}