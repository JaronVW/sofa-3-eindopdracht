<?php

namespace App\Tests;
libxml_use_internal_errors(true);

use App\Domain\SprintReports\SprintReport;
use PHPUnit\Framework\TestCase;

class SprintReportTest extends TestCase
{

    /**
     * @test
     */
    public function it_tests_the_report_functionality(): void
    {
        libxml_use_internal_errors(true);
        $header = '<head><title>Title of the document</title></head>';
        $body = '<body>Body</body>';
        $footer = '<footer>Avans Lmt</footer>';
        $sprintReport = new SprintReport($header, $body, $footer);
        libxml_use_internal_errors(false);


        $this->assertStringContainsString($header . $body . $footer, $sprintReport->exportHTML());
        $this->assertEquals("Exporting to PDF...", $sprintReport->exportPDF());
        $this->assertEquals("Exporting to PNG...", $sprintReport->exportPNG());
        $this->assertEquals("Exporting to XML...", $sprintReport->exportXML());
    }
}
