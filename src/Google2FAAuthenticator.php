<?php

namespace Lifeonscreen\Google2fa;

use Exception;
use PragmaRX\Google2FALaravel\Support\Authenticator;

/**
 * Class Google2FAAuthenticator
 * @package Lifeonscreen\Google2fa
 */
class Google2FAAuthenticator extends Authenticator
{
    protected function canPassWithoutCheckingOTP(): bool
    {
        return
            !$this->isEnabled() ||
            $this->noUserIsAuthenticated() ||
            $this->twoFactorAuthStillValid();
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getGoogle2FASecretKey(): mixed
    {
        $secret = $this->getUser()->user2fa->{$this->config('otp_secret_column')};
        if (empty($secret)) {
            throw new Exception('Secret key cannot be empty.');
        }

        return $secret;
    }
}
