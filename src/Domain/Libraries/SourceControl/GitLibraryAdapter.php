<?php

namespace App\Domain\Libraries\SourceControl;

class GitLibraryAdapter implements SourceControlLibrary
{

    public function linkIssue(string $message): string
    {
        echo  $message . " to GitHub\n";
        return $message . " to GitHub\n";
    }
}
