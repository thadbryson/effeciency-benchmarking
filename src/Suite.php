<?php

namespace TCB\Benchmarker;

use TCB\Benchmarker\Test;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Console\Helper;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output;

class Suite
{
    const LIMIT_MEMORY = '4096M';

    const LIMIT_PRECISION = 16;

    protected $name;
    protected $description;
    protected $fixtures;

    protected $tests;



    public function __construct($name, $description, array $fixtures = null)
    {
        $this->name        = $name;
        $this->description = $description;
        $this->fixtures    = $fixtures;

        $this->tests = new ArrayCollection();

        // Console output objects
        $this->output = new Output\StreamOutput(fopen('php://stdout', 'w'));
        $this->table  = new Helper\Table($this->output);

        $this->setup();
    }

    public function setup()
    {
        set_time_limit(0);

        ini_set('memory_limit', self::LIMIT_MEMORY);
        ini_set('precision',    self::LIMIT_PRECISION);

        return $this;
    }

    public function addTest(Test $test)
    {
        $this->tests->add($test);

        return $this;
    }

    public function run()
    {
        $this->output->writeln('');
        $this->output->writeln('----- <info>'.$this->name.'</info> -----');
        $this->output->writeln('');

        $this->table->setHeaders(['<info>Test</info>', '<info>Time</info>', '<info>Memory</info>']);

        foreach ($this->tests->getIterator() as $test) {

            $clock = $test->run($this->fixtures);

            $this->processResult($test, $clock->getDuration(), $clock->getMemory());
        }

        $this->table->render();
        $this->output->writeln('');

        return $this;
    }

    public function processResult($test, $duration, $memory)
    {
        $duration = $this->formatDuration($duration);
        $memory   = $this->formatMemory($memory);
        $comment  = $test->getComment();

        $this->table->addRow([$test->getName(), $duration, $memory]);

        if ($comment !== null) {
            $this->table->addRow([$test->getComment()]);
        }

        $this->table->addRow(new TableSeparator());


        return $this;
    }

    public function formatDuration($milliseconds)
    {
        if ($milliseconds > 1000) {
            return ($milliseconds / 1000).' s';
        }

        return $milliseconds.' ms';
    }

    public function formatMemory($bytes, $precision = 16)
    {
        $base     = log($bytes, 1024);
        $suffixes = ['', 'k', 'M', 'G', 'T', 'P'];

        return round(pow(1024, $base - floor($base)), $precision).' '.$suffixes[floor($base)];
    }
}
