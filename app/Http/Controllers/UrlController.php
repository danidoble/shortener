<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUrlRequest;
use App\Http\Requests\UpdateUrlRequest;
use App\Models\Url;
use App\Models\UrlLog;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUrlRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Url $url)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Url $url)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUrlRequest $request, Url $url)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Url $url)
    {
        //
    }

    public function to($url)
    {
        $url = Url::where('shortened_url', $url)->firstOrFail();
        $url->last_visited = now();
        $url->visits++;
        if(request()->routeIs('qr.redirect')) {
            $url->visits_qr++;
        }
        $url->save();

        $log = new UrlLog();
        $log->url_id = $url->id;
        $log->url = $url->url;
        $log->shortened_url = $url->shortened_url;
        $log->ip_address = request()->ip();
        $log->user_agent = request()->userAgent();
        $info = $this->ip_info(request()->ip()) ?? [];
        $log->country_code = $info['country_code'] ?? null;
        $log->country = $info['country'] ?? null;
        $log->region_code = $info['region_code'] ?? null;
        $log->region = $info['region'] ?? null;
        $log->continent_name = $info['continent_name'] ?? null;
        $log->referer = request()->headers->get('referer');
        $log->type = request()->routeIs('qr.redirect') ? 'qr' : 'url';
        $log->save();

        return redirect($url->url);
    }


    private function ip_info(?string $ip = null): array
    {
        $arr = [];
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if (true) {
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (isset($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }

        $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), null, strtolower(trim("location")));
        $support = array("country", "countrycode", "state", "region", "city", "location", "address");
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            if ($ip === '127.0.0.1') {
                $ip = '';
            }
            $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip), true);
            if (!is_array($ip_data)) {
                return $arr;
            }
            $arr['country_code'] = $ip_data['geoplugin_countryCode'] ?? null;
            $arr['country'] = $ip_data['geoplugin_countryName'] ?? null;
            $arr['region_code'] = $ip_data['geoplugin_regionCode'] ?? null;
            $arr['region'] = $ip_data['geoplugin_regionName'] ?? null;
            $arr['continent_name'] = $ip_data['geoplugin_continentName'] ?? null;

            return $arr;
        }
        return $arr;
    }
}
