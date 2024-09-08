<?php

namespace App\Livewire\Urls;

use App\Models\Url;
use App\Models\UrlOption;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    public bool $success = false;
    public $db_url;
    public ?string $shortenedUrl = null;

    public ?string $url = null;
    public ?string $customSlug = null;
    public ?string $title = null;

    public function render()
    {
        return view('livewire.urls.edit');
    }

    public function mount(Url $db_url): void
    {
        $this->db_url = $db_url;
        $this->url = $db_url->url;
        $this->title = $db_url->title;
        $this->customSlug = $db_url->shortened_url;
    }

    public function short(): void
    {
        $this->validate([
            'url' => ['required', 'url', 'max:5000'],
            'title' => ['nullable', 'string', 'max:255'],
            'customSlug' => ['required', 'alpha_dash', 'max:255'],
        ]);

        if ($this->customSlug !== $this->db_url->shortened_url) {
            $exist = Url::withTrashed()->where('shortened_url', $this->customSlug)->first();
            if ($exist && $exist->shortened_url === $this->customSlug) {
                $this->addError('customSlug', 'The provided custom slug is already taken.');
                return;
            }
        }

        $shortenedUrl = $this->customSlug;

        if (blank($this->title)) {
            try {
                $response = Http::get($this->url);
                $title = Str::between($response->body(), '<title>', '</title>') ?? 'No title found';
                $title = explode('</title>', $title)[0] ?? 'No title found';
            } catch (Exception) {
                $title = 'No title found';
            }
        } else {
            $title = $this->title;
        }

        $url = $this->db_url;
        $url->title = Str::limit($title, 255);
        $url->url = $this->url;
        $url->ip_address = request()->ip();
        $url->user_agent = request()->userAgent();
        $url->shortened_url = $shortenedUrl;
        $url->save();

        $this->shortenedUrl = route('url.redirect', $shortenedUrl);
        $this->success = true;
    }
}
