<?php

namespace App\Libraries\Annacode\Traits\Models;

trait ApplicationModelTrait
{

    public function getName()
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function getLoginRoute()
    {
        return $this->getDomain().$this->login_route;
    }
}