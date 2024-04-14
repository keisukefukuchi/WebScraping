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
        $url = 'https://tenshoku.mynavi.jp/list/pg3';
        $response = Http::get($url);

        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);
        $crawler->filter('.cassetteRecruit__copy > a')->each(function (Crawler $node) {
            dump($node->attr('href'));
        });
    }
}
