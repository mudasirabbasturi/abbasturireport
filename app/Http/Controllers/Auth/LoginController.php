<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Hash;
  
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
  
    use AuthenticatesUsers;
  
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo() {
        if (auth()->user()->type == 'admin') {
            return '/admin';
        } 
        else if(auth()->user()->type == 'employee') {
            return route('employee.index');
        }
    }
    
    /**
     * Create a new controller instance.
     *
     * @return RedirectResponse
     */

    public function login(Request $request): RedirectResponse {   
        $input = $request->all();
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = ['email' => $input['email'],
            'password' => $input['password'],
        ];

        if(auth()->attempt($credentials)) {


            if (auth()->user()->type == 'admin') {

                return redirect()->route('admin.index');
            } 
            
            else if(auth()->user()->type == 'employee'){
                
                return redirect()->route('employee.index');
            }

        }
        
        else {

            if(!User::where('email', $input['email'])->exists()) {
                return redirect()->route('login')
                    ->with('EmailNotFoundError','Email-Address not found.')
                    ->withInput();
            }

            $user = User::where('email', $input['email'])->first();

            if($user && !Hash::check($input['password'], $user->password)) {
                return redirect()->route('login')
                    ->with('PasswordError','Incorrect password.')
                    ->withInput();
            }

            return redirect()->route('login')
                ->with('error', 'Email-Address or Password is incorrect.')
                ->withInput();
        }
    }
}