<?php

namespace App\Livewire;

use App\Models\JobOrder;
use Illuminate\Support\Collection;
use Livewire\Component;

class WelcomeSearch extends Component
{
    public string $search = '';
    public string $searchBy = 'name';
    public bool $searchPerformed = false;

    public function mount(): void
    {
        $this->search = trim((string) request()->query('query', ''));
        $this->searchBy = request()->query('search_by', 'name');
        $this->searchPerformed = $this->search !== '';
    }

    public function search(): void
    {
        $this->searchPerformed = true;
    }

    public function updatedSearch(): void
    {
        if (trim($this->search) === '') {
            $this->searchPerformed = false;
        }
    }

    public function getJobOrdersProperty(): Collection
    {
        $search = trim($this->search);

        if ($search === '') {
            return collect();
        }

        return JobOrder::with(['customer', 'device', 'services'])
            ->when(
                $this->searchBy === 'reference',
                fn ($query) => $query->where('reference_number', 'like', "%{$search}%"),
                fn ($query) => $query->whereHas('customer', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            )
            ->orderByDesc('created_at')
            ->get();
    }

    public function render()
    {
        return view('livewire.welcome-search', [
            'jobOrders' => $this->jobOrders,
        ]);
    }
}
