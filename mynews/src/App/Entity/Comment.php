<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 18.11.2017
 * Time: 21:00
 */

namespace App\Entity;

class Comment extends Base
{
    /**
     * @param int $choose
     * @return string
     */
    public function getTableName($choose = 0)
    {
        return 'comments';
    }

    /**
     * @param int $choose
     * @return array
     */
    public function getFields($choose = 0)
    {
        $commentFields = [
            'comments' => [
                'id',
                'user_id',
                'news_id',
                'comment_id',
                'comment',
                'created',
                'likes_cnt',
                'dislikes_cnt',
                'need_mod',
            ]
        ];
        return array_values($commentFields)[$choose];
    }

    /**
     * @param $data
     * @throws \Exception
     */
    public function checkFields($data)
    {
        if (!isset($data['comment']) || !strlen($data['comment'])) {
            throw new \Exception('Feedback form fields can\'t be empty');
        }
    }

    /**
     * Get Top-'$limit' of the most commented news for last '$days_old' days
     * @param int $limit
     * @param int $days_old
     * @return mixed
     */
    public function listTopCommentedNews($limit = 5, $days_old = 30)
    {
        $limit_clause = ($limit > 0) ? ' LIMIT ' . $limit : '';
        $sql = 'SELECT t1.news_id, title, date_created, count(t1.id) as comments_cnt, max(created) AS last_date, min(created) AS first_date
        FROM (
        SELECT comments.news_id, title, date_created, comments.id, comments.created, datediff(current_date, comments.created) AS T
        FROM ' . $this->getTableName() . ' JOIN news n ON comments.news_id = n.id
        WHERE datediff(current_date, comments.created) <= ' . $days_old . ' AND active != 0) as t1
        GROUP BY news_id
        ORDER BY comments_cnt DESC, last_date DESC' . $limit_clause . ';';
        return $this->conn->query($sql);
    }

    public function listTopCommentingUsers($limit = 5)
    {
        $limit_clause = ($limit > 0) ? ' LIMIT ' . $limit : '';
        $sql = 'SELECT user_id, name as user_name, count(id) as comments_cnt, sum(likes_cnt) as likes, sum(dislikes_cnt) as dislikes 
        FROM (
        SELECT user_id, c.id, likes_cnt, dislikes_cnt, name 
        FROM ' . $this->getTableName() . ' c LEFT JOIN users u ON c.user_id = u.id WHERE active != 0) t1
        GROUP BY user_id
        ORDER BY comments_cnt DESC' . $limit_clause . ';';
        return $this->conn->query($sql);
    }
}