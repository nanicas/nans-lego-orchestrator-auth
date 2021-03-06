<?php

namespace Zevitagem\LegoAuth\Repositories;

use Zevitagem\LegoAuth\Repositories\AbstractLaravelRepository;
use Zevitagem\LegoAuth\Helpers\Helper;

class ConfigUserRepository extends AbstractLaravelRepository
{
    public function __construct()
    {
        $model = Helper::readConfig()['models']['config_user'];
        
        parent::setModel(new $model());
    }

    public function getByUserAndSlug(int $userId, int $slug)
    {
        $row = $this->getModel()
            ->where('user_id', $userId)
            ->where('slug', $slug);

        return ($row->exists()) ? $row->first() : null;
    }
}