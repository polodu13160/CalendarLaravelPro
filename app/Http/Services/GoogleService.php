<?php

namespace App\Http\Services;

use App\Models\User;
use Google\Service\OAuth2;

class GoogleService
{
    protected $user;
    protected $client;
    public function __construct(User $user)
    {
        $this->client = $this->googleClientConfig();
        $this->user = $user;
    }

    private function googleClientConfig() {
        $redirectURL = "user.integration.authorize_google_calendar";
        $all_scopes = implode(' ', array(
            \Google_Service_Calendar::CALENDAR,
            OAuth2::USERINFO_PROFILE,
            OAuth2::USERINFO_EMAIL
        ));
        $client = new \Google_Client();
        $client->setApplicationName("Events");
        $client->setScopes($all_scopes);
        // $client->setAuthConfig(storage_path('app/googleClient/client_secret.json'));
        $client->setState('gcalendar');
        $client->setRedirectUri(route($redirectURL));
        $client->setAccessType('offline');
        $client->setApprovalPrompt("force");
        return $client;
    }

    public function authUrl() {

        $client = $this->client;
        return $client->createAuthUrl();
    }
}
