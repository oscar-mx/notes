<?php

require_once '../vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

douban();
function douban()
{
    //爬取豆瓣电影top250第一页信息
    $url = "https://movie.douban.com/top250";
    //浏览器请求头
    $headers = [
        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.25',
    ];
    $client = new Client([
        'timeout' => 20,
        'headers' => $headers
    ]);
    //发送请求获取页面内容
    $response = $client->request('GET', $url)->getBody()->getContents();
    $data = [];
    $crawler = new Crawler();
    $crawler->addHtmlContent($response);
    //使用crawler进行页面内容分析
    try{
        //这里使用的是xpath语法
        $crawler->filterXPath('//*[@id="content"]/div/div[1]/ol/li/div/div[2]')->each(function(Crawler $node, $i) use (&$data){
            $item = [
                'title' => $node->filterXPath('//div[contains(@class, "hd")]/a/span[1]')->text(),
                'url' => $node->filterXPath('//div[contains(@class, "hd")]/a')->attr('href'),
                'desc' => $node->filterXPath('//div[contains(@class, "bd")]/p')->text(),
                'score' => $node->filterXPath('//div[contains(@class, "bd")]/div[contains(@class, "star")]')->text(),
            ];
            $data[] = $item;
        });
    }catch (\Exception $e){
        echo $e->getMessage() . PHP_EOL;
    }
    //打印结果
    print_r($data);
}