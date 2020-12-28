<?php

namespace Garavel\Controller;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Garavel\Utils\Ajax;
use Garavel\Model\GaravelUserModel;
use Garavel\ViewComposers\FlashMessageViewComposer;
use Garavel\Auth\GaravelAuth;

class GaravelLoginController extends Controller {

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
    use RedirectsUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected static $defaultUserMail = 'tmdadmin@sabah.com.tr';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response|JsonResponse
     *
     * @throws Exception
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        $ajax = new Ajax();

        $email = $request->input("email");
        $password = $request->input('password');
        $errorMessages = ['Giriş başarısız'];
        $path = session()->get('url.intended', url('/'));

        $user = GaravelUserModel::where('email', $email)->first();

        if (!$user || $user->status == 0)
        {
            return $ajax->alert('danger', $errorMessages);
        }

        //TMD Auth Devre dışı bırakılmış giriş denemesi
        if ($user->is_tmd_auth == 0)
        {
            if ($this->attemptLogin($request))
            {
                $request->session()->regenerate();
                session()->forget('url.intended');

                //ilk giriş için kullanılan super user pasife çekiliyor
                if ($email == self::$defaultUserMail && Cache::has('default_user_deleted') === false)
                {
                    $this->updateDefaultUserToPassive($user);
                    return $ajax->redirect(route('users.create'));
                }

                $this->deleteDefaultUser();

                return $this->authenticated($request, $this->guard()->user())
                    ?: $ajax->redirect($path);
            }
        }

        //Tmd Auth ile giriş yapmayı dene
        $garavelAuth = new GaravelAuth();
        if ($garavelAuth->authenticate($email, $password))
        {
            //$request->session()->regenerate();

            //Şifreler farklılaşmış olabilir
            //$user->password = bcrypt($password);
            //$user->save();

            Auth::login($user);
            session()->forget('url.intended');

            $this->deleteDefaultUser();

            return $ajax->redirect($path);
        }

        return $ajax->alert('danger', $errorMessages);
    }


    /**
     * @param GaravelUserModel $user
     *
     * @return bool
     */
    protected function updateDefaultUserToPassive(GaravelUserModel $user)
    {
        $message = "Lütfen  super_user rolüne sahip kendi kullanıcınızı oluşturun 
                    \r\n veya kendi hesabınızla giriş yapın. \r\n Bu hesap kısa süre içerisinde silinecektir";

        request()->session()->flash(FlashMessageViewComposer::MESSAGE_WARNING, $message);

        $user->status = 0;
        $user->password = Hash::make(Str::random(10));

        return $user->save();
    }

    /**
     * @return bool
     */
    protected function deleteDefaultUser() : bool {


        if(Cache::has('default_user_deleted')){
            return true;
        }

        $isDefaultActive = GaravelUserModel::whereEmail(self::$defaultUserMail)->first();
        if ($isDefaultActive)
        {
            $isDefaultActive->delete();
            Cache::forever('default_user_deleted', 1);
            return true;
        }

        return false;

    }


    /**
     * Validate the user login request.
     *
     * @param Request $request
     *
     * @return void
     *
     */
    protected function validateLogin(Request $request)
    {
        $messages = [
            'email.required'       => 'E-Posta adresi girmelisiniz',
            'email.email'          => 'Geçerli bir e-posta adresi girmelisiniz',
            'password.required'    => 'Şifre girmelisiniz',
            'g-recaptcha-response' => 'required|captcha'
        ];

        $request->validate([
            $this->username() => 'required|email|string',
            'password'        => 'required|string',
        ], $messages);
    }

    /**
     * Show the application's login form.
     *
     * @return Response
     */
    public function showLoginForm()
    {
        return view('adminlte::auth.login');
    }

    protected function authenticated(Request $request, GaravelUserModel $user)
    {
        if ($request->ajax())
        {
            $ajax = new Ajax();

            return $ajax->redirect('/');
        }

        return redirect()->intended();
    }

}
