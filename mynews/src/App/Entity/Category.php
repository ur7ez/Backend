<?php
/**
 * Created by PhpStorm.
 * User: Mike Nykytenko
 * Date: 11/13/17
 * Time: 20:55
 */

namespace App\Entity;

class Category extends Base
{
    /**
     * @param int $choose
     * @return string
     */
    public function getTableName($choose = 0)
    {
        $categoryTables = [
            'categories',
            'news_in_categories',
        ];
        return $categoryTables[$choose];
    }

    /**
     * @param int $choose
     * @return array
     */
    public function getFields($choose = 0)
    {
        $categoryFields = [
            'categories' => [
                'id',
                'title',
                'description',
                'header',
                'restricted',
                'comments_moderated',
                'active',
            ],
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
            ]
        ];
        return array_values($categoryFields)[$choose];
    }

    /**
     * @param $data
     * @throws \Exception
     */
    public function checkFields($data)
    {
        if (!is_string($data['title']) || !strlen($data['title'])) {
            throw new \Exception('Category title can\'t be empty');
        }
    }

    /**
     * @param int $limit -  defines how many news should appear in each category
     * @param int $table_id
     * @return mixed
     */
    public function listTop($limit = 5, $table_id = 1)
    {
        $sql = "
    SELECT top_news.category_id, news.* FROM
  (SELECT
     category_id,
     SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(news_id ORDER BY news_date_created DESC), ',', value), ',', -1) AS news_id,
     SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(news_date_created ORDER BY news_date_created DESC), ',', value), ',', -1) AS date_created
   FROM " . $this->getTableName($table_id) . ", tinyint_asc
   WHERE ( tinyint_asc.value >= 1 AND tinyint_asc.value <= $limit ) AND active != 0
   GROUP BY category_id, value) top_news
  JOIN news ON top_news.news_id = news.id
    ORDER BY top_news.category_id ASC, top_news.date_created DESC;";
        return $this->conn->query($sql);
    }

    /**
     * Filters data array by a given id
     * @param array $array
     * @param string $field - a field in array to be inspected by a given ID value
     * @param $ID
     * @return array
     */
    static function filterArrayFromID($array, $field = '', $ID)
    {
        return array_values(
            array_filter($array, function ($arrayValue) use ($field, $ID) {
                return $arrayValue[$field] == $ID;
            }));
    }
}