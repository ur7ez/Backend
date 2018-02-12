<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 18.11.2017
 * Time: 20:55
 */

namespace App\Controllers;

use App\Core\App;
use App\Entity\Comment;

class CommentsController extends Base
{
    /** @var Comment */
    private $commentsModel;

    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->commentsModel = new Comment(App::getConnection());
    }

    /**
     * @throws \Exception
     */
    public function indexAction()
    {
        $data = $_POST;
        if ($data) {
            if ($this->commentsModel->save($data)) {
                App::getSession()->setFlash('Thank you! Your message was sent successfully!');
            } else {
                throw new \Exception('Error savimg feedback message: ' . var_dump($data));
            }
        } else {
            $data = '';
        }
    }
}