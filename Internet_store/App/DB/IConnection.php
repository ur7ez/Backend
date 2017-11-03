<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 03.11.2017
 * Time: 15:08
 */
namespace App\DB;
interface IConnection
{
    /**
     * @param string $queryStr
     * @return bool|\mysqli_result
     */
    public function query(string $queryStr);

    /**
     * @return \mysqli
     */
    public function get();
}