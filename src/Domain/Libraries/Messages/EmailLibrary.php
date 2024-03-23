<?php

namespace App\Domain\Libraries\Messages;


class EmailLibrary
{

    public function sendEmail(string $message): string
    {
        echo "Sent Email \n";
        return "Sent email";
    }
}
