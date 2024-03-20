<?php

namespace App\Entity\SprintReports;

enum ExportType
{
    case PDF;
    case PNG;
    case HTML;
    case XML;
}
