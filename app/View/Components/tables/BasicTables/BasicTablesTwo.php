<?php

namespace App\View\Components\tables\BasicTables;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BasicTablesTwo extends Component
{
    // Tambahkan properti ini
    public $karyawans;

    /**
     * Create a new component instance.
     */
    public function __construct($karyawans = [])
    {
        // Tangkap datanya di sini
        $this->karyawans = $karyawans;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tables.basic-tables.basic-tables-two');
    }
}
