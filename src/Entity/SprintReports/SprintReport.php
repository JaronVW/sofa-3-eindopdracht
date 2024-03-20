<?php

namespace App\Entity\SprintReports;

use DOMDocument;

class SprintReport
{
    private DOMDocument $doc;

    public function __construct(
        private string $header,
        private string $body,
        private string $footer,
    )
    {
        $doc = new DOMDocument();
        $doc->loadHTML($this->header . $this->body . $this->footer);
    }

    public  function exportHTML(): string
    {
        echo $this->doc->saveHTML();
        return $this->doc->saveHTML();
    }

    public  function exportPDF(): string
    {
        echo "Exporting to PDF...";
        return "Exporting to PDF...";
    }

    public  function exportPNG(): string
    {
        echo "Exporting to PNG...";
        return "Exporting to PNG...";
    }

    public  function exportXML(): string
    {
       echo "Exporting to XML..." ;
       return "Exporting to XML...";
    }

}
