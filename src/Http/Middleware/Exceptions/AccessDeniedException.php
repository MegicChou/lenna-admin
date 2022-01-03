<?php

namespace Lenna\Admin\Http\Middleware\Exceptions;

class AccessDeniedException extends \Exception
{

    /**
     * Render the exception into an HTTP response.
     *
     */
    public function render()
    {
        return response(view("lenna-admin::errorpage.access-denied")
            ->render(),403);
    }
}
