<?php

use App\Domain\Exceptions\PipelineFailedException;
use App\Domain\Pipeline\Action;
use App\Domain\Pipeline\Category;
use App\Domain\Pipeline\Pipeline;
use PHPUnit\Framework\TestCase;

class PipelineTest extends TestCase
{

    /**
     * @test
     * @throws PipelineFailedException
     */
    public function it_runs_pipeline_commands_correctly()
    {
        $pipeline = new Pipeline();
        $cat = new Category("Merge changes");

        $tracking = $this->createMock(Action::class);
        $tracking->expects($this->once())->method('execute');
        $cat->add($tracking);


        $add = $this->createMock(Action::class);
        $add->expects($this->once())->method('execute');
        $cat->add($add);

        $commit = $this->createMock(Action::class);
        $commit->expects($this->once())->method('execute');
        $cat->add($commit);

        $push = $this->createMock(Action::class);
        $push->expects($this->once())->method('execute');
        $cat->add($push);

        $pipeline->addAction($cat);
        $pipeline->execute();
    }

    /**
     * @test
     * @throws PipelineFailedException
     */
    public function it_throws_exception_when_action_fails()
    {
        $pipeline = new Pipeline();
        $cat = new Category("Merge changes");

        $tracking = $this->createMock(Action::class);
        $tracking->expects($this->once())->method('execute');
        $cat->add($tracking);


        $add = $this->createMock(Action::class);
        $add->expects($this->once())->method('execute');
        $cat->add($add);

        $commit = $this->createMock(Action::class);
        $commit->expects($this->once())->method('execute');
        $cat->add($commit);

        $push = $this->createMock(Action::class);
        $push->expects($this->once())->method('execute');
        $cat->add($push);

        $fail = new class("fail") extends Action {
            public function __construct(string $name)
            {
                parent::__construct($name);
            }
            public function execute(): string
            {
                throw new PipelineFailedException();
            }
        };
        $cat->add($fail);

        $this->expectException(PipelineFailedException::class);

        $pipeline->addAction($cat);
        $pipeline->execute();
    }
}
