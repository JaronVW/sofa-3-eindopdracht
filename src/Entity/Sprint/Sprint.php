<?php

namespace App\Entity\Sprint;

use App\Entity\Backlog;
use App\Entity\BacklogItem\BacklogItem;
use App\Entity\Exceptions\ModificationNotAllowedException;
use App\Entity\Sprint\States\Release\ReleaseCreatedState;
use App\Entity\Sprint\States\SprintState;
use App\Entity\SprintReports\ExportType;
use App\Entity\SprintReports\SprintReport;
use App\Entity\Users\Developer;
use App\Entity\Users\ProductOwner;
use App\Entity\Users\ScrumMaster;
use DateTimeImmutable;

abstract class Sprint
{

    private SprintState $state;
    private Backlog $backlog;

    /**
     * @var array<int, Developer>
     */
    private array $developers = [];


    public function __construct(
        private string               $name,
        private DateTimeImmutable    $startDate,
        private DateTimeImmutable    $endDate,
        private readonly ScrumMaster $scrumMaster,
        private ?ProductOwner        $productOwner = null
    )
    {
        $this->state = new ReleaseCreatedState();
        $this->backlog = new Backlog();
    }

    /**
     * @throws ModificationNotAllowedException
     */

    /**
     * @throws ModificationNotAllowedException
     */
    public function addBacklogItem(BacklogItem $backlogItem): void
    {
        if ($this->modifySprintAllowed()) {
            $this->backlog->addBacklogItem($backlogItem);
        }
    }

    /**
     * @return array<int,BacklogItem>
     */
    public function getBacklogItems(): array
    {
        return $this->backlog->getBacklogItems();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setState(SprintState $state): void
    {
        $this->state = $state;
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function setName(string $name): void
    {
        if ($this->modifySprintAllowed()) {
            $this->name = $name;
        }
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function setStartDate(DateTimeImmutable $startDate): void
    {
        if ($this->modifySprintAllowed()) {
            $this->startDate = $startDate;
        }
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function setEndDate(DateTimeImmutable $endDate): void
    {
        if ($this->modifySprintAllowed()) {
            $this->endDate = $endDate;
        }
    }

    private function modifySprintAllowed(): bool
    {
        if ($this->state instanceof ReleaseCreatedState) {
            return true;
        } else {
            throw new ModificationNotALlowedException();
        }
    }

    public function getScrumMaster(): ScrumMaster
    {
        return $this->scrumMaster;
    }

    public function getProductOwner(): ?ProductOwner
    {
        return $this->productOwner;
    }

    public function setProductOwner(?ProductOwner $productOwner): void
    {
        $this->productOwner = $productOwner;
    }

    public function export(ExportType $exportType, string $header, string $body, string $footer): string
    {
        $body = "<p>Product owner:" . $this->productOwner->name . " Scrum master: " . $this->scrumMaster->name ?? "N/A" . " Developers: " . json_encode($this->effortPointsPerDeveloper()) . "</p>" . $body;
        $sprintReport = new SprintReport($header, $body, $footer);
        return match ($exportType) {
            ExportType::HTML => $sprintReport->exportHTML(),
            ExportType::PDF => $sprintReport->exportPDF(),
            ExportType::PNG => $sprintReport->exportPNG(),
            ExportType::XML => $sprintReport->exportXML(),
        };
    }

    /**
     * @return array<string,int>
     */
    public function effortPointsPerDeveloper(): array
    {
        $developersPoints = [];
        foreach ($this->developers as $developer) {
            $developersPoints[$developer->name] = 0;
        }
        foreach ($this->getBacklogItems() as $backlogItem) {
            $developersPoints[$backlogItem->getDeveloper()?->name] += $backlogItem->getEffortPoints();
        }
        return $developersPoints;
    }
}
