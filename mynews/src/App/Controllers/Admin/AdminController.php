<?php
/**
 * Created by PhpStorm.
 * User: Mike Nykytenko
 * Date: 24.11.2017
 * Time: 6:20
 */

namespace App\Controllers\Admin;

use App\Controllers\Base;

class AdminController extends Base
{
    public function __construct(array $params = [])
    {
        parent::__construct($params, 20);
    }
}