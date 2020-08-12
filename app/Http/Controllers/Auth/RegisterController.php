<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller

//trait RegistersUsers

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

    //use RegistersUsers;
    use RedirectsUsers;

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function register(Request $request)
    {
       $this->validator($request->all())->validate();
       //dd($request->All());
       

       //event(new Registered($user = $this->create($request->all())));

       event(new Registered($user = $this->create([
        'name' => $request->name,
        'tipo' => 2,
        'email' => $request->email,
        'password' => $request->password,
        'eltoken'=>$request->tokecito,
       ])));

       $this->guard()->login($user);

       return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());

        /*event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());*/
        //dd($request->All());
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        //dd($data);
        return User::create([
            'name' => $data['name'],
            'tipo' => 2,
            'email' => $data['email'],
            'eltoken'=>$data['eltoken'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        //
    }
}
