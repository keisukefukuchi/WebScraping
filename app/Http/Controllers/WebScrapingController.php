<?php

namespace App\Http\Controllers;

use App\Models\Scripting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class WebScrapingController extends Controller
{
    public function scrape(Request $request) {
        $url = 'https://tabelog.com/rstLst/';
        $response = Http::get($url);

        $html = $response->getBody()->getContents();
        $crawler = new Scripting();
        $store_infos = $crawler->crawler(new Crawler($html));
        return view('index', ['store_infos' => $store_infos]);
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        $prefecture = $request->prefecture;

        $url = 'https://tabelog.com/' . $prefecture  .'/rstLst/?sk=' . $keyword;

        $response = Http::get($url);

        $html = $response->getBody()->getContents();
        $crawler = new Scripting();
        $store_infos = $crawler->crawler(new Crawler($html));
        return view('index', ['store_infos' => $store_infos]);
    }
}
