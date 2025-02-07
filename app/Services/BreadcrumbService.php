<?php
// app/Services/BreadcrumbService.php

namespace App\Services;

class BreadcrumbService
{
    protected $breadcrumbs = [];

    public function set($key, $title, $url = null)
    {
        $this->breadcrumbs[$key] = [
            'title' => $title,
            'url' => $url,
        ];
    }

    public function get($key)
    {
        return $this->breadcrumbs[$key] ?? null;
    }

    public function all()
    {
        return $this->breadcrumbs;
    }
}
