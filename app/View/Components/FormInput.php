<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormInput extends Component
{
    public $name;
    public $type;
    public $value;
    public $label;
    public $required;
    public $readonly;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $type = 'text', $value = '', $label = '', $required = '', $readonly = '')
    {
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->label = $label;
        $this->required = $required;
        $this->readonly = $readonly;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-input');
    }
}
