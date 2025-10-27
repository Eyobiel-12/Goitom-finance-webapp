<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;

final class SidebarToggle extends Component
{
    public bool $isCollapsed = false;

    public function toggle(): void
    {
        $this->isCollapsed = !$this->isCollapsed;
        
        // Save to localStorage via Alpine
        $this->dispatch('sidebar-toggle', isCollapsed: $this->isCollapsed);
    }

    public function render()
    {
        return view('livewire.sidebar-toggle');
    }
}

