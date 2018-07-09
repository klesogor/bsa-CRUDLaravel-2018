<?php

namespace App\Services;


final class CurrencyBuilder
{
    private $date;
    private $id = 1;
    private $name;
    private $course;
    private $shortName;
    private $active;

    public function setDate(string $date):CurrencyBuilder
    {
        $this->date = \DateTime::createFromFormat('Y-m-d H-i-s',$date);
        return $this;
    }

    public function setDateTimestamp(int $timestamp):CurrencyBuilder
    {
        $this->date = (new \DateTime())->setTimestamp($timestamp);
        return $this;
    }

    public function setName(string $name):CurrencyBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function setCourse(float $course):CurrencyBuilder
    {
        $this->course = $course;
        return $this;
    }

    public function  setShortName(string  $name):CurrencyBuilder
    {
        $this->shortName = $name;
        return $this;
    }

    public function setActive(bool $active):CurrencyBuilder
    {
        $this->active = $active;
        return $this;
    }

    public function build():Currency
    {
        return new Currency(
            $this->id++,
            $this->name,
            $this->shortName,
            $this->course,
            $this->date,
            $this->active
        );
    }

}