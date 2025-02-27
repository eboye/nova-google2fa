<?php

namespace Lifeonscreen\Google2fa\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Lifeonscreen\Google2fa\Google2FAAuthenticator;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA as G2fa;
use PragmaRX\Recovery\Recovery;

/**
 * Class Google2fa
 * @package Lifeonscreen\Google2fa\Http\Middleware
 */
class Google2fa
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure(\Illuminate\Http\Request):mixed  $next
     * @return Response|RedirectResponse|JsonResponse
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidCharactersException
     * @throws SecretKeyTooShortException
     */
    public function handle(Request $request, Closure $next)
    {
        if (!config('lifeonscreen2fa.enabled')) {
            return $next($request);
        }
        if ($request->path() === 'los/2fa/confirm' || $request->path() === 'los/2fa/authenticate'
            || $request->path() === 'los/2fa/register') {
            return $next($request);
        }
        $authenticator = app(Google2FAAuthenticator::class);
        if (auth()->guest() || $authenticator->isAuthenticated()) {
            return $next($request);
        }
        if (empty(auth()->user()->user2fa) || auth()->user()->user2fa->google2fa_enable === 0) {

            $google2fa = new G2fa();
            $recovery = new Recovery();
            $secretKey = $google2fa->generateSecretKey();
            $data['recovery'] = $recovery
                ->setCount(config('lifeonscreen2fa.recovery_codes.count'))
                ->setBlocks(config('lifeonscreen2fa.recovery_codes.blocks'))
                ->setChars(config('lifeonscreen2fa.recovery_codes.chars_in_block'))
                ->toArray();

            $user2faModel = config('lifeonscreen2fa.models.user2fa');
            $user2faModel::where('user_id', auth()->user()->id)->delete();

            $user2fa = new $user2faModel();
            $user2fa->user_id = auth()->user()->id;
            $user2fa->google2fa_secret = $secretKey;
            $user2fa->recovery = encrypt(json_encode($data['recovery']));
            $user2fa->save();

            return response(view('google2fa::recovery', $data));
        }

        return response(view('google2fa::authenticate'));
    }
}
