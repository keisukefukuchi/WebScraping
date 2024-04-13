<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\DomCrawler\Crawler;

class WebScrapingController extends Controller
{
    public function scrape(Request $request) {
        $client = new Client();
        $base_url = 'https://pubmed.ncbi.nlm.nih.gov/';

        // ユーザ入力を取得
        $keywords = $request->input('keywords', '');
        $max_pages = 10;

        $articles = [];

        if (!empty($keywords)) {
            for ($page = 1; $page <= $max_pages; $page++) {
                $url = "{$base_url}?term={$keywords}&page={$page}";
                $response = $client->request('GET', $url);
                $html = $response->getBody()->getContents();

                $crawler = new Crawler($html);
                $page_results = $crawler->filter('.docsum-content')->each(function (Crawler $node) {
                    return [
                        'title' => $node->filter('.docsum-title')->text(),
                        'authors' => $node->filter('.docsum-authors')->text(),
                        'pmid' => $node->filter('.docsum-pmid')->text(),
                        'snippet' => $node->filter('.full-view-snippet')->text(),
                        'journalCitation' => $node->filter('.docsum-journal-citation.full-journal-citation')->text()
                    ];
                });

                $articles = array_merge($articles, $page_results);
                sleep(1); // API制限やサーバーへの負荷を考慮して1秒待機
            }
        }

        // ページネーションの設定
        $articles = collect($articles);
        $currentPage = $request->input('page', 1);
        $perPage = 10;
        $currentItems = $articles->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedArticles = new LengthAwarePaginator($currentItems, count($articles), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('index', compact('paginatedArticles', 'keywords'));
    }

}
