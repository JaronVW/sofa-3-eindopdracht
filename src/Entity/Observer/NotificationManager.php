<?php

namespace App\Entity\Observer;

use App\Entity\NotificationListener;

class NotificationManager
{
    /**
     * @param array<int,array<UserRole,NotificationListener>> $listeners
     */
    private array $listeners;

    public function __construct()
    {
        $this->listeners = [];
    }

    public function subscribe(UserRole $userRole, NotificationListener $listener): void
    {
       $this->listeners[] = [$userRole, $listener] ;
    }

    public function unsubscribe(UserRole $userRole, NotificationListener $listener)
    {
        $key = array_search([$userRole, $listener], $this->listeners);
        unset($this->listeners[$key]);
    }

    public function notify(UserRole $userRole, string $message): void
    {
        foreach ($this->listeners as $i) {
            [$listenerRole,$listener] = $i;
            if ($userRole === $listenerRole) {
                $listener->sendNotification($message);
            }
        }
    }
}
