<?php
namespace App\Services;

use App\SocialProvider;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialGoogleAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialProvider::whereProvider('google')
            ->whereProviderId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $account = new SocialProvider([
                'provider_id' => $providerUser->getId(),
                'provider' => 'google'
            ]);
        $user = User::whereEmail($providerUser->getEmail())->first();
        if (!$user) {
            $user = User::create([
                        'email' => $providerUser->getEmail(),
                        'name' => $providerUser->getName(),
                        'password' => bcrypt('password'),
                        'status' => 1
                    ]);
        }
        $account->user()->associate($user);
        $account->save();
        return $user;
        }
    }
}
