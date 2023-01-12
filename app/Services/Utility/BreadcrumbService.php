<?php
/*
 * Breadcrumbs Helper
 *
 * @author Agin
 * @date 26-Oct-2018
 */

namespace App\Services\Utility;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;


class BreadcrumbService
{

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    private $_home = [];


    /**
     * Initialize a new composer instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Bind data to the view
     *
     * @param array $data
     * @param bool $exclude
     */
    public function compose(array $data = [], bool $exclude = false)
    {
        $breadcrumbs = ($exclude)? []: $this->parseSegments($data);
        View::share('breadcrumbs', $breadcrumbs);
    }

    public function addHome(array $data = [])
    {
        $this->_home = $data;
    }

    /**
     * Parse the request route segments.
     *
     * @param array $data
     * @return \Illuminate\Support\Collection
     */
    protected function parseSegments(array $data = [])
    {
        $breadcrumbSegments = collect($this->request->segments())->mapWithKeys(function ($segment, $key) {
            return [
                $segment => implode('/', array_slice($this->request->segments(), 0, $key + 1))
            ];
        });
        if (! empty($data)) {
            $breadcrumb = (! empty($this->_home))? array_merge($this->_home, $data) : array_merge([$breadcrumbSegments->first() => $breadcrumbSegments->first()], $data);
            return collect($breadcrumb);
        } else {
            return $breadcrumbSegments;
        }
    }

}

