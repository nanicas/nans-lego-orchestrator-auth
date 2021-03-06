<?php

namespace Zevitagem\LegoAuth\Controllers;

use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Services\SlugService;
use Illuminate\Http\Request;
use Zevitagem\LegoAuth\Traits\AvailabilityWithView;

class ApplicationController
{

    use AvailabilityWithView;

    public function __construct()
    {
        $this->addViewNamespace();
    }

    public function slugs(Request $request)
    {
        $route = $request->query('login_route');

        try {
            $service = new SlugService();
            $slugs   = $service->getSlugsByApplication($request->route('app'));
            $status  = true;
            $message = '';
        } catch (\Throwable $ex) {
            $status  = false;
            $message = $ex->getMessage();
            $slugs   = [];
        }

        return json_encode(Helper::createDefaultJsonToResponse($status,
                [
                    'html' => Helper::getGeneralAdapter()->loadView(
                        'slugs_list',
                        compact('route', 'slugs', 'message', 'status')
                    )->render()
                ]
        ));
    }

    public function buildOutLoginRoute(Request $request)
    {
        $config = Helper::readConfig();
        $route  = $request->query('login_route');

        $hasSlugsInside  = ($config['slugs_inside'] === true);
        $hasSelectedSlug = (!empty($_GET['slug']));
        $isLaravel       = Helper::isLaravel();

        $data = [
            'with_slugs' => (int) (!$isLaravel || !$hasSlugsInside),
            //'slugs_from_requester' => (int) ($isLaravel && !$hasSlugsInside && !$hasSelectedSlug)
        ];

        if ($hasSelectedSlug) {
            $data['slug'] = $_GET['slug'];
        }

        return Helper::getGeneralAdapter()->loadView('outsourced_login.login_route',
            compact('route', 'data')
        )->render();
    }
}