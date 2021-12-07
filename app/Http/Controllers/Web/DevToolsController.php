<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;

/**
 * Class DocsController
 * @package App\Http\Controllers\Web
 */
final class DevToolsController extends Controller
{
    /**
     * Get swagger file content
     *
     * @return string
     */
    public function file() : string
    {
        return file_get_contents(base_path('docs/swagger.yaml'));
    }

    /**
     * Render view with docs
     *
     * @return Factory
     */
    public function docs()
    {
        return view('dev_tools.docs_form');
    }
}
