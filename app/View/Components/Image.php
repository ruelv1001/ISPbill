<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Image extends Component
{
    public $src;
    public $alt;
    public $class;
    public $width;
    public $height;
    public $isSvg;

    /**
     * Create a new component instance.
     */
    public function __construct($src, $alt = '', $class = '', $width = null, $height = null)
    {
        $this->src = $src;
        $this->alt = $alt;
        $this->class = $class;
        $this->width = $width;
        $this->height = $height;
        $this->isSvg = pathinfo($this->src, PATHINFO_EXTENSION) === 'svg';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.image');
    }
}
