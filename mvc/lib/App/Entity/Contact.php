<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 18.11.2017
 * Time: 21:00
 */

namespace App\Entity;

class Contact extends Base
{
    public function getTableName()
    {
        return 'feedback';
    }

    public function checkFields($data)
    {
        if (!isset($data['name']) || !isset($data['email']) || !isset($data['messages']) || !strlen($data['name']) || !strlen($data['email']) || !strlen($data['messages'])) {
            throw new \Exception('Feedback form fields can\'t be empty');
        }
    }
}