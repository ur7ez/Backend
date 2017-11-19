<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 18.11.2017
 * Time: 20:55
 */

namespace App\Controllers;

use App\Core\App;
use App\Core\Session;
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
        $data = $_POST;
        if ($data) {
            if ($this->contactsModel->save($data)) {
                Session::setFlash('Thank you! Your message was sent successfully!');
            } else {
                throw new \Exception('Error savimg feedback message: ' . var_dump($data));
            }
        }
    }

    public function viewAction()
    {
        $contacts = $this->contactsModel->getById($this->params[0]);

        if (!empty($contacts)) {
            $this->data = $contacts;
        } else {
            $this->page404();
        }
    }
}