<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse;



class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Quando faccio il logout mi ritorna alla view della login
        // In questo modo implemento una nuova classe e la ridireziono alla login view
        // In questo modo dice al container che quando serve la classe LogoutResponse di mandarla in questo modo
        // con la redierct a login, rispetto a quando era scritta nella classe originale che passa una risposta json e
        // un redirect a: '/'
        // $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
        //     public function toResponse($request)
        //     {
        //         //dd('prov');
        //         return redirect('/login');
        //     }
        // });

        // // Una volta che mi registro mi ritorna nella view dell' impostazione del secondo fattore
        // $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
        //     public function toResponse($request)
        //     {
        //         //dd('prov');
        //         return redirect('/home');
        //     }
        // });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // ##################

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.passwords.email');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.passwords.reset', ['request' => $request]);
        });

        //restituisce la vista di verifica dell'autenticazione a due fattori di fortify.
        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });

    }

}
