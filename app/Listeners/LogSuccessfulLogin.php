<?php

namespace App\Listeners;

use App\Models\LoginLog;
use Illuminate\Auth\Events\Login as LoginEvent;
use Illuminate\Http\Request;

class LogSuccessfulLogin
{
    /**
     * The request instance.
     */
    protected Request $request;

    /**
     * Create the event listener.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     */
    public function handle(LoginEvent $event): void
    {
        if ($event->user) {
            LoginLog::create([
                'user_id' => $event->user->id,
            ]);
        }
    }
}
