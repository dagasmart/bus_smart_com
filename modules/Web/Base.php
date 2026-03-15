<?php

namespace Modules\Web;

use DagaSmart\BizAdmin\Admin;

class Base extends Admin
{
    public static function view($apiPrefix = ''): array|string|null
    {
        if (!$apiPrefix) {
            $apiPrefix = self::config('admin.route.prefix');
        }

        if (is_file(public_path('web-assets/index.html'))) {
            $view = file_get_contents(public_path('web-assets/index.html'));
        } else {
            $view = file_get_contents(base_path('vendor/dagasmart/bizadmin/web-views/dist/index.html'));
        }

        $logoPath = self::config('admin.logo');

        $script = '<script>document.querySelector(\'link[rel*="icon"]\').href="' . $logoPath . '";window.$adminApiPrefix = "/' . $apiPrefix . '"</script>';

        return preg_replace('/<script>window.*?<\/script>/is', $script, $view);
    }


}
