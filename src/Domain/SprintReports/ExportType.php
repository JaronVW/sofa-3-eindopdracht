<?php

namespace App\Domain\SprintReports;

enum ExportType
{
    case PDF;
    case PNG;
    case HTML;
    case XML;
}
