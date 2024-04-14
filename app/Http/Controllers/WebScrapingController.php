<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class WebScrapingController extends Controller
{
    public function scrape(Request $request) {
        $url = 'https://tabelog.com/rstLst/';
        $response = Http::get($url);

        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);

        $store_infos = [];

        $crawler->filter('.list-rst__rst-name-target')->each(function (Crawler $node) use (&$store_infos) {
            $store_name = $node->text();
            $store_link = $node->attr('href');

            $store_infos[] = ['name' => $store_name, 'link' => $store_link];
        });

        return view('index', ['store_infos' => $store_infos]);
    }

}
