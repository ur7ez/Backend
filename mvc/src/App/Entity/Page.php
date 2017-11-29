<?php
/**
 * Created by PhpStorm.
 * User: gendos
 * Date: 11/13/17
 * Time: 20:55
 */

namespace App\Entity;

class Page extends Base
{
    public function getTableName()
    {
        return 'pages';
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return [
            'id',
            'title',
            'alias',
            'content',
            'active',
        ];
    }

    public function checkFields($data)
    {
        if (!is_string($data['title']) || !strlen($data['title'])) {
            throw new \Exception('Page title can\'t be empty');
        }
    }
}