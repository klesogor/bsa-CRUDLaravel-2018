<?php

namespace App\Services;


class CurrencyBuilder
{
    private $date;
    private $id;
    private $name;
    private $course;
    private $shortName;
    private $active;

    public function setDate(string $date)
    {
        $this->date = \DateTime::createFromFormat('Y-m-d H-i-s',$date);
        return $this;
    }

    public function setDateTimestamp(int $timestamp)
    {
        $this->date = (new \DateTime())->setTimestamp($timestamp);
        return $this;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function setCourse(float $course)
    {
        $this->course = $course;
        return $this;
    }

    public function  setShortName(string  $name)
    {
        $this->shortName = $name;
        return $this;
    }

    public function setActive(bool $active)
    {
        $this->active = $active;
        return $this;
    }

    public function build()
    {
        return new Currency(
            $this->id,
            $this->name,
            $this->shortName,
            $this->course,
            $this->date,
            $this->active
        );
    }

}