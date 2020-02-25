# PHP实现爬虫的一种方案

## 基于两个开源组件：
- [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/)
Guzzle是一个PHP的HTTP客户端，用来轻而易举地发送请求，并集成到我们的WEB服务上。
- [DomCrawler](http://www.symfonychina.com/doc/current/components/dom_crawler.html)
Symfony的DomCrawler组件使HTML和XML文档的导览（navigation）变得容易。

## 安装
通过composer即可安装
```
composer require guzzlehttp/guzzle
composer require symfony/dom-crawler
```
## 思路
- 简单来说就是获取到网页上的信息然后按照一定的规则解析得到你想要的数据
- 获取信息可以使用Guzzle进行请求，DomCrawler组件提供了Xpath表达式进行过滤
- 不知道怎么定位、获取Xpath ？ 使用Chrome浏览器安装XPath Helper插件解决问题

## 简单使用
```php
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
```
## 参考
[Guzzle文档](https://guzzle-cn.readthedocs.io/zh_CN/latest/)

[DomCrawler文档](http://www.symfonychina.com/doc/current/components/dom_crawler.html)

[XPath教程](https://www.runoob.com/xpath/xpath-tutorial.html)