<?php

namespace App\Services;
use App\Models\MailProvider;
use Illuminate\Support\Facades\Config;

class MailConfigurator
{
    
    public static function configure() {
    
        $provider = MailProvider::active();

        if($provider)
        {
            Config::set('mail.driver', $provider->driver);
            Config::set('mail.host', $provider->host);
            Config::set('mail.port', $provider->port);
            Config::set('mail.username', $provider->user_name);
            Config::set('mail.password', $provider->password);
            Config::set('mail.from.address', $provider->from_name);
            Config::set('mail.from.name', $provider->name);
        }
    }

}
