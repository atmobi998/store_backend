<?php

namespace Atcmobapp\Core\View\Cell;

use Cake\Cache\Cache;
use Cake\I18n\Time;
use Cake\Utility\Xml;
use Cake\View\Cell;
use Atcmobapp\Core\Link;

class BlogFeedCell extends Cell
{

    public function dashboard()
    {
        $posts = $this->getPosts();

        $this->set('posts', $posts);
    }

    protected function getPosts()
    {
        $posts = Cache::read('atcmobile_blog_feed_posts');
        if ($posts === false) {
            $xml = Xml::build(file_get_contents('https://blog.metroeconomics.com/promoted.rss'));

            $data = Xml::toArray($xml);

            $posts = [];
            foreach ($data['rss']['channel']['item'] as $item) {
                $posts[] = (object)[
                    'title' => $item['title'],
                    'url' => new Link($item['link']),
                    'body' => $item['description'],
                    'date' => new Time($item['pubDate']),
                ];
            }
        }

        Cache::write('atcmobile_blog_feed_posts', $posts);

        return $posts;
    }
}
