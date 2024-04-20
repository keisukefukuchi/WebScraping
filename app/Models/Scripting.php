<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\DomCrawler\Crawler;

class Scripting extends Model
{
    use HasFactory;

    public function crawler(Crawler $crawler) {
        $store_infos = [];
        $crawler->filter('.list-rst__rst-name-target')->each(function (Crawler $node) use (&$store_infos) {
            $store_name = $node->text();
            $store_link = $node->attr('href');

            $store_infos[] = ['name' => $store_name, 'link' => $store_link];
        });

        return $store_infos;
    }
}
