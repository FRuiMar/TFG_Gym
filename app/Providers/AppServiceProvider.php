<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verificación de correo electrónico - Forza Training Center')
                ->greeting('¡Hola ' . $notifiable->name . '!')
                ->line('¡Gracias por registrarte en Forza Training Center!')
                ->line('Por favor, haz clic en el siguiente botón para verificar tu dirección de correo electrónico.')
                ->action('Verificar dirección de correo', $url)
                ->line('Si no creaste una cuenta, no es necesario realizar ninguna acción.')
                ->salutation('Saludos, el equipo de Forza Training Center');
        });
    }
}
