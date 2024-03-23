<?php

namespace App\Domain\Libraries\SourceControl;

interface SourceControlLibrary
{
    public function linkIssue(string $message): string;
}
