<?php

namespace App\Tests;

use App\Entity\SprintReports\SprintReport;
use PHPUnit\Framework\TestCase;

class SprintReportTest extends TestCase
{

    /**
     * @test
     */
    public function it_tests_the_report_functionality(): void
    {
        $header = '<head><title>Title of the document</title></head>';
        $body = "<body>Body</body>";
        $footer = '<footer><p>Avans Lmt</p></footer>';
        $sprintReport = new SprintReport($header, $body, $footer);

        $this->assertEquals($header . $body . $footer, $sprintReport->exportHTML());
        $this->assertEquals("Exporting to PDF...", $sprintReport->exportPDF());
        $this->assertEquals("Exporting to PNG...", $sprintReport->exportPNG());
        $this->assertEquals("Exporting to XML...", $sprintReport->exportXML());
    }
}
