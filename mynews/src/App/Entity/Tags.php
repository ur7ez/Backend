<?php
/**
 * Created by PhpStorm.
 * User: Mike Nykytenko
 * Date: 11/13/17
 * Time: 20:55
 */

namespace App\Entity;

class Tags extends Base
{
    /**
     * @param int $choose
     * @return string
     */
    public function getTableName($choose = 0)
    {
        $tagsTables = [
            'tags_in_news',
            'tags'
        ];
        return $tagsTables[$choose];
    }

    /**
     * @param int $choose
     * @return array
     */
    public function getFields($choose = 0)
    {
        $tagsFields = [
            'tags_in_news' => [
                'id',   // news id
                'title',
                'content',
                'date_created',
                'author',
                'source_ref',
                'image_cap',
                'hits_cnt',
                'active',
                'tag_id',
                'tag',
            ],
            'tags' => [
                'id',
                'tag',
            ]
        ];
        return array_values($tagsFields)[$choose];
    }

    /**
     * @param $data
     * @throws \Exception
     */
    public function checkFields($data)
    {
        if (!is_string($data['title']) || !strlen($data['title'])) {
            throw new \Exception('News title can\'t be empty');
        }
        if (!is_string($data['content']) || !strlen($data['content'])) {
            throw new \Exception('News content can\'t be empty');
        }
    }
}