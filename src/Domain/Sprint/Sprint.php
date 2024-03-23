<?php

namespace App\Domain\Sprint;

use App\Domain\Backlog;
use App\Domain\BacklogItem\BacklogItem;
use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Pipeline\Pipeline;
use App\Domain\Sprint\States\PartialProduct\PartialProductCreatedState;
use App\Domain\Sprint\States\PartialProduct\PartialProductSprintState;
use App\Domain\Sprint\States\Release\ReleaseCreatedState;
use App\Domain\Sprint\States\Release\ReleaseSprintState;
use App\Domain\SprintReports\ExportType;
use App\Domain\SprintReports\SprintReport;
use App\Domain\Users\Developer;
use App\Domain\Users\ProductOwner;
use App\Domain\Users\ScrumMaster;
use DateTimeImmutable;

abstract class Sprint
{

    protected ReleaseSprintState|PartialProductSprintState $state;
    protected Backlog $backlog;


    /**
     * @var array<int, Developer>
     */
    protected array $developers = [];

    protected Pipeline $pipeline;


    public function __construct(
        protected string               $name,
        protected DateTimeImmutable    $startDate,
        protected DateTimeImmutable    $endDate,
        protected readonly ScrumMaster $scrumMaster,
        protected ?ProductOwner        $productOwner = null
    )
    {
        $this->backlog = new Backlog();
        $this->pipeline = new Pipeline();
    }

    /**
     * @throws ModificationNotAllowedException
     */

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


    public function setPipeline(Pipeline $pipeline): void
    {
        if ($this->modifySprintAllowed()) {
            $this->pipeline = $pipeline;
        }
    }

    public function setProductOwner(?ProductOwner $productOwner): void
    {
        if ($this->modifySprintAllowed()) {
            $this->productOwner = $productOwner;
        }
    }

    public function setState(ReleaseSprintState $state): void
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

    /**
     * @throws ModificationNotAllowedException
     */
    private function modifySprintAllowed(): bool
    {
        if (( $this->state instanceof ReleaseCreatedState || $this->state instanceof PartialProductCreatedState) || $this->pipeline->isPipeLineBusy()) {
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

    /**
     * @throws ModificationNotAllowedException
     */
    public function addBacklogItem(BacklogItem $backlogItem): void
    {
        if ($this->modifySprintAllowed()) {
            $this->backlog->addBacklogItem($backlogItem);
        }
    }


    public function getPipeline(): Pipeline
    {
        return $this->pipeline;
    }

    abstract public function progressSprint(): void;

    abstract public function cancelSprint(): void;
}
