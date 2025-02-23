<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\SocialAccount;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();

            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);
        } catch (\Throwable $err) {
            if ($err->getMessage() == 'This password does not use the Bcrypt algorithm.') {
                return back()->with('err', 'Error: Your account is registered as a social account.')->withInput($request->only('email'));
            }

            return back()->with('err', 'Terjadi kesalahan saat mencoba masuk. Silakan periksa kembali detail Anda atau coba lagi nanti.')->withInput($request->only('email'));
        }
    }




    /**
     * Redirect the user to the provider authentication page.
     */
    public function redirectToProvider($provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Get user info from provider.
     */
    public function handleProviderCallback($provider): RedirectResponse
    {
        try {
            $user = Socialite::driver($provider)->user();
            $authUser = $this->findOrCreateUser($user, $provider);
            Auth::login($authUser, true);

            return redirect()->intended(RouteServiceProvider::HOME);
        } catch (\Throwable $err) {
            return to_route('login')->with('status', 'Error: ' . $err->getMessage());
        }
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     */
    public function findOrCreateUser($socialUser, $provider): User
    {
        $socialAccount = SocialAccount::where('provider_id', $socialUser->getId())
            ->where('provider_name', $provider)
            ->first();
        if ($socialAccount) {
            return $socialAccount->user;
        } else {
            if ($socialUser->getEmail() != null) {
                $user = User::where('email', $socialUser->getEmail())->first();
                if (! $user) {
                    $user = User::create([
                        'name' => $socialUser->getName() ?? 'User',
                        'email' => $socialUser->getEmail() ?? null,
                    ]);
                    $user->assignRole('user');

                    event(new Registered($user));
                }
                $user->socialAccounts()->create([
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => $provider,
                ]);

                return $user;
            }
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
