<?php

namespace App\Livewire\Urls;

use App\Models\Url;
use DeviceDetector\DeviceDetector;
use Illuminate\Support\Collection;
use Livewire\Component;

class Show extends Component
{
    public $link;
    public bool $share = false;
    public bool $_isDeleting = false;
    public $deletingUrl = false;

    public ?Collection $referrerData = null;

    public function render()
    {
        return view('livewire.urls.show');
    }

    public function mount(Url $db_url): void
    {
        $db_url->load('statistics7days', 'statisticsPrevious7days');
        $this->link = $db_url;

        // get referrer data, count, host
        $data = $db_url->statistics7days->groupBy('referer')->map(function ($item) {
            return [
                'count' => $item->count(),
                'host' => $this->getHostFormReferer($item->first()->referer ?? 'Direct'),
            ];
        })->sortDesc();
        $this->referrerData = collect();
        foreach ($data as $value) {
            $this->referrerData[] = [
                'host' => $value['host'],
                'count' => $value['count'],
            ];
        }

        //$userAgent = $db_url->statistics7days->first()->user_agent;
//        $dd = new DeviceDetector($userAgent);
//        $dd->parse();
//        if ($dd->isBot()) {
//            // handle bots,spiders,crawlers,...
//            $botInfo = $dd->getBot();
//
//            dd($botInfo);
//        } else {
//            $clientInfo = $dd->getClient(); // holds information about browser, feed reader, media player, ...
//            $osInfo = $dd->getOs();
//            $device = $dd->getDeviceName();
//            $brand = $dd->getBrandName();
//            $model = $dd->getModel();
//
//            dd($clientInfo, $osInfo, $device, $brand, $model);
//        }
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

    public function parseViewsToSimple(int $value): string
    {
        // parse 1000 to 1k, 1000000 to 1m, etc
        $absValue = abs($value);
        if ($absValue < 1000) {
            return $value;
        }

        $value = $absValue / 1000;
        if ($value < 1000) {
            $value = round($value, 1);
            return $value . 'k';
        }

        $value = $absValue / 1000000;
        $value = round($value, 1);
        return $value . 'm';
    }

    public function getHostFormReferer(string $referer = ''): string
    {
        $referer = parse_url($referer, PHP_URL_HOST);
        if ($referer) {
            return $referer;
        }
        return 'Direct';
    }
}
