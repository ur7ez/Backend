<?php
/**
 * Created by PhpStorm.
 * User: Mike Nykytenko
 * Date: 18.11.2017
 * Time: 21:00
 */

namespace App\Entity;

class Ads extends Base
{
    /**
     * @param int $choose
     * @return string
     */
    public function getTableName($choose = 0)
    {
        return 'site_ads';
    }

    /**
     * @param int $choose
     * @return array
     */
    public function getFields($choose = 0)
    {
        $commentFields = [
            'site_ads' => [
                'id',
                'product',
                'description',
                'price',
                'seller',
                'ref',
                'active',
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
        $msg = [];
        foreach ($data as $key => $val) {
            switch ($key) {
                case 'product':
                    if (!isset($val) || !strlen($val)) {
                        $msg[] = 'Product title can\'t be empty';
                    }
                    break;
                case 'price':
                    if (($val <= 0) || !isset($val)) {
                        $msg[] = 'Ads price can\'t be empty or less than 0';
                    }
                    break;
            }
        }
        if ($msg) {
            throw new \Exception(implode('; ', $msg));
        }
    }

    public function list($filter = [], $limit = null, $offset = 0, $table_id = 0, $order = [], &$get_total = null)
    {
        $data['ads_data'] = parent::list($filter, $limit, $offset, $table_id, $order, $get_total);
        $data['ads_background'] = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
        return $data;
    }
}