<?php

namespace App\Entity\Libraries;


class EmailLibrary
{

    public function sendEmail(string $message): string
    {
        return "Sent email";
    }
}
