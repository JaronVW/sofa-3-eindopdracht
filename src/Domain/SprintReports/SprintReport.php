<?php

namespace App\Domain\SprintReports;

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
        $this->doc = new DOMDocument();
        echo '<!DOCTYPE html><html lang="en">' . $this->header . $this->body . $this->footer. '</html>';
        $this->doc->loadHTML('<!DOCTYPE html><html lang="en">' . $this->header . $this->body . $this->footer. '</html>');
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
