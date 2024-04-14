<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\DomCrawler\Crawler;

class Scrape extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'scraping';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'https://tabelog.com/rstLst/';
        $response = Http::get($url);

        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);

        $store_info = [];

        $crawler->filter('.list-rst__rst-name-target')->each(function (Crawler $node) use (&$store_info) {
            $store_name = $node->text();
            $store_link = $node->attr('href');

            $store_info[] = ['name' => $store_name, 'link' => $store_link];
        });

        var_dump($store_info);
    }
}
