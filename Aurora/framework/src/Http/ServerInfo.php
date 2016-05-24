<?php

class ServerInfo implements \IteratorAggregate, \Countable
{
    protected $info = array();

    public function __construct($info)
    {
        $this->info = $info;
    }

    public function getIterator()
    {
        return \ArrayIterator($this->info);
    }

    public function count()
    {
        return count($this->info);
    }
}
