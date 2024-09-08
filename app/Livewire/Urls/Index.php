<?php

namespace App\Livewire\Urls;

use App\Models\Url;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public int $page = 1;
    public bool $share = false;
    public bool $_isDeleting = false;
    public $deletingUrl = false;

    public function render()
    {
        return view('livewire.urls.index', [
            'links' => $this->getLinks(),
        ]);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function getLinks(): LengthAwarePaginator
    {
        return Url::where('user_id', auth()->id())
            ->where(function ($query) {
                $query->where('shortened_url', 'like', '%' . $this->search . '%')
                    ->orWhere('url', 'like', '%' . $this->search . '%')
                    ->orWhere('title', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function showShare(Url $url): void
    {
        $this->share = true;
        $this->dispatch('showShare', shortened: $url->shortened_url);
    }

    public function deleteModal(Url $url): void
    {
        $this->_isDeleting = true;
        $this->deletingUrl = $url;
    }

    public function confirmDelete(): void
    {
        if ($this->deletingUrl) {
            $this->deletingUrl->delete();
        }
        $this->_isDeleting = false;
    }

    public function details(Url $url): void
    {
        $this->redirect(route('dashboard.links.show', $url));
    }
}
