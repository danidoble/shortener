<?php

namespace App\Livewire\Urls;

use App\Models\Url;
use App\Models\UrlOption;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    public bool $success = false;
    public ?string $shortenedUrl = null;

    public ?string $url = null;
    public ?string $customSlug = null;
    public ?string $title = null;

    public function render()
    {
        return view('livewire.urls.create');
    }

    public function short()
    {
        $this->validate([
            'url' => ['required', 'url', 'max:5000'],
            'title' => ['nullable', 'string', 'max:255'],
            'customSlug' => ['nullable', 'alpha_dash', 'max:255'],
        ]);

        if ($this->customSlug) {
            $exist = Url::withTrashed()->where('shortened_url', $this->customSlug)->first();
            if ($exist && $exist->shortened_url === $this->customSlug) {
                $this->addError('customSlug', 'The provided custom slug is already taken.');
                return;
            }
            $shortenedUrl = $this->customSlug;
        } else {
            $lastId = (int)UrlOption::where('name', 'next_id')->first()->value;
            do {
                $shortenedUrl = $this->base62_encode($lastId);
                $exist = Url::withTrashed()->where('shortened_url', $shortenedUrl)->first();

                if ($exist && $exist->shortened_url === $shortenedUrl) {
                    $lastId++;
                }
            } while ($exist);
            UrlOption::where('name', 'next_id')->update(['value' => $lastId + 1]);
        }

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

        $url = new Url();
        $url->title = $this->title ?? Str::limit($title, 255);
        $url->url = $this->url;
        $url->ip_address = request()->ip();
        $url->user_agent = request()->userAgent();
        $url->user_id = auth()->id();
        $url->shortened_url = $shortenedUrl;
        $url->save();

        $this->shortenedUrl = route('url.redirect', $shortenedUrl);
        $this->success = true;
    }

    private function base62_encode($data): string
    {
        $characters = config('app.base62.characters');
        $base = strlen($characters);
        $result = '';

        while ($data > 0) {
            $remainder = $data % $base;
            $data = intval($data / $base);
            $result = $characters[$remainder] . $result;
        }

        return $result;
    }
}
