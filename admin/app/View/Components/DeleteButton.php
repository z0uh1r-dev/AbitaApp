<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class DeleteButton extends Component
{
    public function __construct(
        public string $action,
        public string $label = 'Delete',
        public string $confirm = 'Are you sure you want to delete this? This action cannot be undone.'
    ) {}

    public function render(): View
    {
        return view('admin.components.delete-button');
    }
}
