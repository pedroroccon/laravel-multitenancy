<?php

namespace App\Providers;

use App\Listeners\SetTenantIdInSession;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // Quando um usuário fizer login na aplicação 
        // devemos pegar o evento e então direcionar 
        // para o listener responsável por definir 
        // o ID do inquilino.
        Login::class => [
            SetTenantIdInSession::class, 
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
