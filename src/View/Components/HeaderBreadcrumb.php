<?php

namespace Lenna\Admin\View\Components;

use Illuminate\View\Component;

class HeaderBreadcrumb extends Component
{
    private $title;

    private $breadcrumb;

    public function __construct($title, $breadcrumb)
    {
        $this->title        = $title;
        $this->breadcrumb   = $breadcrumb;
    }

    public function render()
    {
        // TODO: Implement render() method.
        return view('lenna-admin::header-breadcrumb',[
            'title'         => $this->title,
            'breadcrumb'    => $this->breadcrumb
        ]);
    }
}
