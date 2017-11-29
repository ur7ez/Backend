<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27.11.2017
 * Time: 14:48
 */

namespace App\Controllers\Admin;

use App\Controllers\Base;
use App\Core\App;
use App\Entity\Contact;

class ContactsController extends Base
{
    /** @var Contact */
    private $contactsModel;

    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->contactsModel = new Contact(App::getConnection());
    }

    public function indexAction()
    {
        $this->data = $this->contactsModel->list();
    }

    public function editAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $id = isset($this->params[0]) ? $this->params[0] : null;
                $this->data = [
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'messages' => $_POST['messages'],
                ];
                $this->contactsModel->save($this->data, $id);
                App::getSession()->setFlash('User comment has been revised');
                App::getRouter()->redirect('index');
            } catch (\Exception $e) {
                App::getSession()->setFlash($e->getMessage());
            }
        }
        if (isset($this->params[0]) && $this->params[0] > 0) {
            $this->data = $this->contactsModel->getById($this->params[0]);
        }
    }

    public function deleteAction()
    {
        $id = isset($this->params[0]) ? $this->params[0] : null;
        if (!$id) {
            App::getSession()->setFlash('Missing comment id');
        } elseif ($this->contactsModel->delete($id)) {
            App::getSession()->setFlash('User comment has been deleted');
        } else {
            App::getSession()->setFlash('Couldn\'t delete comment');
        }
        App::getRouter()->redirect('index');
    }
}