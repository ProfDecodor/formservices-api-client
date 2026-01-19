<?php

namespace Jway\FormServicesApiClient\Api\V2023\Resources;

use Jway\FormServicesApiClient\FormServicesClient;

class AuthenticationResource
{
    protected FormServicesClient $client;

    public function __construct(FormServicesClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get authenticated user data and user interface context.
     */
    public function me(?string $lang = null, ?string $group = null): array
    {
        return $this->client->get('rest/auth/me', [
            'lang' => $lang,
            'group' => $group,
        ]);
    }

    /**
     * Update authenticated user data.
     */
    public function update(array $userData): array
    {
        return $this->client->put('rest/auth/me', $userData);
    }

    /**
     * Create account.
     */
    public function createAccount(array $accountData): array
    {
        return $this->client->post('rest/auth/createaccount', $accountData);
    }

    /**
     * Find user credential type.
     */
    public function credentialType(string $userLogin, bool $creation = false): array
    {
        return $this->client->post('rest/auth/credentialtype', [
            'name' => $userLogin,
            'creation' => $creation,
        ]);
    }

    /**
     * Logout user.
     */
    public function logout(): array
    {
        return $this->client->post('rest/auth/logout', []);
    }

    /**
     * Request a new password.
     */
    public function lostPassword(string $login, string $email, string $captcha): array
    {
        return $this->client->post('rest/auth/lostpassword', [
            'name' => $login,
            'email' => $email,
            'captcha' => $captcha,
        ]);
    }

    /**
     * Check submitted token and update password.
     */
    public function resetPassword(string $login, string $token, string $newPassword): array
    {
        return $this->client->post('rest/auth/resetpassword', [
            'name' => $login,
            'token' => $token,
            'password' => $newPassword,
        ]);
    }
}