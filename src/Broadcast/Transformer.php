<?php

namespace YEntWeChat\Broadcast;

use YEntWeChat\Message\AbstractMessage;
use YEntWeChat\Message\News;
use YEntWeChat\Message\Text;

/**
 * Class Transformer.
 */
class Transformer
{
    /**
     * transform message to XML.
     *
     * @param array|string|AbstractMessage $message
     *
     * @return array
     */
    public function transform($message)
    {
        if (is_array($message)) {
            $class = News::class;
        } else {
            if (is_string($message)) {
                $message = new Text(['content' => $message]);
            }

            $class = get_class($message);
        }

        $handle = 'transform'.substr($class, strlen('YEntWeChat\Message\\'));

        return method_exists($this, $handle) ? $this->$handle($message) : [];
    }

    /**
     * Transform text message.
     *
     * @return array
     */
    public function transformText(AbstractMessage $message)
    {
        return [
            'msgtype' => 'text',
            'text'    => [
                'content' => $message->get('content'),
            ],
        ];
    }

    /**
     * Transform image message.
     *
     * @return array
     */
    public function transformImage(AbstractMessage $message)
    {
        return [
            'msgtype' => 'image',
            'image'   => [
                'media_id' => $message->get('media_id'),
            ],
        ];
    }

    /**
     * Transform music message.
     *
     * @return array
     */
    public function transformMusic(AbstractMessage $message)
    {
        return [
            'msgtype' => 'music',
            'music'   => [
                'title'          => $message->get('title'),
                'description'    => $message->get('description'),
                'musicurl'       => $message->get('url'),
                'hqmusicurl'     => $message->get('hq_url'),
                'thumb_media_id' => $message->get('thumb_media_id'),
            ],
        ];
    }

    /**
     * Transform video message.
     *
     * @return array
     */
    public function transformVideo(AbstractMessage $message)
    {
        return [
            'msgtype' => 'video',
            'video'   => [
                'title'          => $message->get('title'),
                'media_id'       => $message->get('media_id'),
                'description'    => $message->get('description'),
                'thumb_media_id' => $message->get('thumb_media_id'),
            ],
        ];
    }

    /**
     * Transform voice message.
     *
     * @return array
     */
    public function transformVoice(AbstractMessage $message)
    {
        return [
            'msgtype' => 'voice',
            'voice'   => [
                'media_id' => $message->get('media_id'),
            ],
        ];
    }

    /**
     * Transform file message.
     *
     * @return array
     */
    public function transformFile(AbstractMessage $message)
    {
        return [
            'msgtype' => 'file',
            'file'    => [
                'media_id' => $message->get('media_id'),
            ],
        ];
    }

    /**
     * Transform articles message.
     *
     * @return array
     */
    public function transformNews($news)
    {
        $articles = [];

        if (!is_array($news)) {
            $news = [$news];
        }

        foreach ($news as $item) {
            $articles[] = [
                'title'       => $item->get('title'),
                'description' => $item->get('description'),
                'url'         => $item->get('url'),
                'picurl'      => $item->get('pic_url'),
                'btntxt'      => $item->get('btntxt'),
            ];
        }

        return ['msgtype' => 'news', 'news' => ['articles' => $articles]];
    }

    /**
     * Transform articles message.
     *
     * @return array
     */
    public function transformMpNews($news)
    {
        $articles = [];

        if (!is_array($news)) {
            $news = [$news];
        }

        foreach ($news as $item) {
            $articles[] = [
                'title'              => $item->get('title'),
                'thumb_media_id'     => $item->get('thumb_media_id'),
                'author'             => $item->get('author'),
                'content_source_url' => $item->get('content_source_url'),
                'content'            => $item->get('content'),
                'digest'             => $item->get('digest'),
                'show_cover_pic'     => $item->get('show_cover_pic'),
            ];
        }

        return ['msgtype' => 'mpnews', 'news' => ['articles' => $articles]];
    }

    /**
     * Transform material message.
     *
     * @return array
     */
    public function transformMaterial(AbstractMessage $message)
    {
        $type = $message->getType();

        return [
            'msgtype' => $type,
            $type     => [
                'media_id' => $message->get('media_id'),
            ],
        ];
    }

    /**
     * Transform textcard message.
     *
     * @return array
     */
    public function transformTextCard(AbstractMessage $message)
    {
        return [
            'msgtype'  => 'textcard',
            'textcard' => [
                'title'       => $message->get('title'),
                'description' => $message->get('description'),
                'url'         => $message->get('url'),
                'btntxt'      => $message->get('btntxt'),
            ],
        ];
    }

    /**
     * Transform card message.
     *
     * @param $message
     *
     * @return array
     */
    public function transformCard($message)
    {
        return [
            'wxcard'  => [
                'card_id' => $message,
            ],
            'msgtype' => 'wxcard',
        ];
    }
}
