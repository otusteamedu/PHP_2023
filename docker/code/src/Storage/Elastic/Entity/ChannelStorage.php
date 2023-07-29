<?php

namespace IilyukDmitryi\App\Storage\Elastic\Entity;


use IilyukDmitryi\App\Storage\Base\ChannelStorageInterface;

use function MongoDB\BSON\toCanonicalExtendedJSON;

class ChannelStorage extends Base implements ChannelStorageInterface
{

    protected function getSettings(): array
    {
        return [
            'analysis' => [
                'filter' => [
                    'ru_stop' => [
                        'type' => 'stop',
                        'stopwords' => '_russian_',
                    ],
                    'ru_stemmer' => [
                        'type' => 'stemmer',
                        'language' => 'russian',
                    ]
                ],
                'analyzer' => [
                    'my_russian' => [
                        'tokenizer' => 'standard',
                        'filter' => ['lowercase', 'ru_stop', 'ru_stemmer']
                    ]
                ]
            ],
        ];
    }

    protected function getMappings(): array
    {
        return [
            'properties' => [
                "channel_id" =>  [
                    "type" =>  "keyword"
                ],
                'channel_name' => [
                    'type' => 'text',
                    'analyzer' => 'my_russian'
                ],
                'subscriber_count' => [
                    'type' => 'integer'
                ],
            ]
        ];
    }

    /**
     * @return array
     */
    public static  function getIndexName(): string
    {
        return "youtube_channel";
    }


}