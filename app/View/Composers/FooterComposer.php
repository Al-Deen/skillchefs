<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Modules\CMS\Interfaces\FooterInterface;

class FooterComposer
{

    protected $footer;

    public function __construct(FooterInterface $footerInterface)
    {
        $this->footer = $footerInterface;
    }

    public function compose(View $view)
    {
        if (cache()->has('footer_menus')) {
            $data['footers'] = cache()->get('footer_menus');
        } else {
            $data['footers'] = $this->footer->model()->where('status_id', 1)->orderBy('column', 'asc')->get();
            cache()->put('footer_menus', $data['footers'], 60 * 60 * 24);
        }
        $view->with('data', $data);
    }
}
