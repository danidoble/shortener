<?php

namespace App\Livewire\Urls;

use Livewire\Attributes\On;
use Livewire\Component;

class Share extends Component
{
    public bool $show = false;
    public string $shortened = '';

    public function render()
    {
        return view('livewire.urls.share');
    }

    #[On('showShare')]
    public function showShare(string $shortened = ''): void
    {
        $this->shortened = route('url.redirect', $shortened);
        $this->show = true;
    }
}
