<?php

namespace TCB\Benchmarker;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Stopwatch\Stopwatch;

class Test
{
    protected $test;

    protected $name;

    protected $comment;

    protected $clock;



    public function __construct($test, $name, $comment = null)
    {
        $this->test    = $test;
        $this->name    = $name;
        $this->comment = $comment;

        $this->clock = new Stopwatch();
    }

    public function run(array $fixtures)
    {
        // Start the stopwatch.
        $this->clock->start($this->getName());

        // Run the test closure here.
        call_user_func_array($this->test, [$fixtures]);

        // Return the Stopwatch event.
        return $this->clock->stop($this->getName());
    }

    public function getName()
    {
        return $this->name;
    }

    public function getComment()
    {
        return $this->comment;
    }
}
