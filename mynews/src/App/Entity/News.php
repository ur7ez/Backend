<?php
/**
 * Created by PhpStorm.
 * User: Mike Nykytenko
 * Date: 11/13/17
 * Time: 20:55
 */

namespace App\Entity;

class News extends Base
{
    /**
     * @param int $choose
     * @return string
     */
    public function getTableName($choose = 0)
    {
        $newsTables = [
            'news_in_categories',
            'news'
        ];
        return $newsTables[$choose];
    }

    /**
     * @param int $choose
     * @return mixed
     */
    public function getFields($choose = 0)
    {
        $newsFields = [
            'news_in_categories' => [
                'category_id',
                'category_title',
                'category_description',
                'category_header',
                'news_id',
                'title',
                'content',
                'news_date_created',
                'author',
                'source_ref',
                'image_cap',
                'hits_cnt',
                'active'
            ],
            'news' => [
                'id',
                'title',
                'content',
                'date_created',
                'author',
                'source_ref',
                'image_cap',
                'hits_cnt',
                'active',
            ],
        ];
        return array_values($newsFields)[$choose];
    }

    /**
     * Проверяет поля таблицы, в которую будем
     * вносить изменения в методе parent::save()
     * @param $data
     * @throws \Exception
     */
    public function checkFields($data)
    {
        $msg = [];
        foreach ($data as $key => $val) {
            switch ($key) {
                case 'title':
                    if (!is_string($val) || !strlen($val)) {
                        $msg[] = 'News title can\'t be empty';
                    }
                    break;
                case 'content':
                    if (!is_string($val) || !strlen($val)) {
                        $msg[] = 'News content can\'t be empty';
                    }
                    break;
            }
        }
        if ($msg) {
            throw new \Exception(implode('; ', $msg));
        }
    }
}