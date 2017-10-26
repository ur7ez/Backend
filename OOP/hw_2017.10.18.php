<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 23.10.2017
 * Time: 17:24
 */
//Тема:
// Введение в ООП: классы, свойства классов, методы, конструкторы.
//Принципы ООП: инкапсуляция, наследование.
//Задание: https://github.com/Gendos-ua/academy_lessons/blob/master/06_objects/homework.md
echo "<pre>";

//1. Сделайте класс `Task1`, в котором будут следующие `public` поля - `name` (имя), `age` (возраст), `salary` (зарплата).
//Создайте объект этого класса, затем установите поля в следующие значения (не в `__construct`, а для созданного объекта) - имя 'Иван', возраст 25, зарплата 1000. Создайте второй объект этого класса, установите поля в следующие значения - имя 'Вася', возраст 26, зарплата 2000.
//   Выведите на экран сумму зарплат Ивана и Васи. Выведите на экран сумму возрастов Ивана и Васи.

class Task1
{
    public $name;
    public $age;
    public $salary;
}

$employee1 = new Task1();
$employee1->name = 'Иван';
$employee1->age = 25;
$employee1->salary = 1000;

$employee2 = new Task1();
$employee2->name = 'Вася';
$employee2->age = 26;
$employee2->salary = 2000;

echo "Задача 1.\n Сумма зарплат ($employee1->name и $employee2->name): " . ($employee1->salary +
        $employee2->salary);
echo "\n Сумма возрастов ($employee1->name и $employee2->name): " . ($employee1->age +
        $employee2->age) . "\n";

//2. Сделайте класс `Task2`, в котором будут следующие `private` поля - `name` (имя), `age` (возраст), `salary` (зарплата) и следующие public методы `setName`, `getName`, `setAge`, `getAge`, `setSalary`, `getSalary`.
//Создайте 2 объекта этого класса: 'Иван', возраст 25, зарплата 1000 и 'Вася', возраст 26, зарплата 2000.
//   Выведите на экран сумму зарплат Ивана и Васи. Выведите на экран сумму возрастов Ивана и Васи.

class Task2
{
    private $name;
    private $age;
    private $salary;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setAge($age)
    {
        if ($this->checkAge($age)) {
            $this->age = $age;
        }
    }

    private function checkAge($age)
    {
        if ($age >= 1 && $age <= 100) {
            return true;
        } else {
            return false;
        }
    }

    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getSalary()
    {
        return $this->salary;
    }
}

$employee1 = new Task2();
$employee1->setName('Иван');
$employee1->setAge(25);
$employee1->setSalary(1000);

$employee2 = new Task2();
$employee2->setName('Вася');
$employee2->setAge(26);
$employee2->setSalary(2000);

echo "Задача 2.\n Сумма зарплат ({$employee1->getName()} и {$employee2->getName()}): " . ($employee1->getSalary() +
        $employee2->getSalary());
echo "\n Сумма возрастов ({$employee1->getName()} и {$employee2->getName()}): " . ($employee1->getAge() +
        $employee2->getAge()) . "\n";

//3. Дополните класс `Task2` из предыдущей задачи `private` методом `checkAge`, который будет проверять возраст на корректность (от 1 до 100 лет). Этот метод должен использовать метод `setAge` перед установкой нового возраста (если возраст не корректный - он не должен меняться)

$new_age = 101;
$employee2->setAge($new_age);
echo "Задача 3.\n меняем возраст на $new_age лет у {$employee2->getName()}. Проверка: " . $employee2->getAge() . "\n";

//4. Сделайте класс `Task4`, в котором будут следующие `private` поля - name (имя), `salary` (зарплата). Сделайте так, чтобы эти свойства заполнялись в методе `__construct` при создании объекта (вот так: `new Worker(имя, возраст)` ). Сделайте также `public` методы `getName`, `getSalary`.
//Создайте объект этого класса 'Дима', возраст 25, зарплата 1000. Выведите на экран произведение его возраста и зарплаты.

class Task4
{
    private $name;
    private $salary;
    private $age;

    public function __construct($name, $salary, $age)
    {
        $this->name = $name;
        $this->salary = $salary;
        $this->age = $age;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getSalary()
    {
        return $this->salary;
    }
}

$worker = new Task4('Дима', 1000, 25);
echo "Задача 4.\n Произведение возраста и зарплаты для объекта '{$worker->getName()}': " .
    ($worker->getSalary() * $worker->getAge()) . "\n";

//5. Сделайте класс `User`, в котором будут следующие protected поля - `name` (имя), `age` (возраст), `public` методы `setName`, `getName`, `setAge`, `getAge`.
//Сделайте класс `Worker`, который наследует от класса `User` и вносит дополнительное `private` поле `salary` (зарплата), а также методы `public` `getSalary` и `setSalary`.
//Создайте объект этого класса 'Иван', возраст 25, зарплата 1000. Создайте второй объект этого класса 'Вася', возраст 26, зарплата 2000. Найдите сумму зарплат Ивана и Васи.
//Сделайте класс `Student`, который наследует от класса `User` и вносит дополнительные private поля стипендия, курс, а также геттеры и сеттеры для них.

class User
{
    protected $name;
    protected $age;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function getAge()
    {
        return $this->age;
    }
}

class Worker extends User
{
    private $salary;

    public function getSalary()
    {
        return $this->salary;
    }

    public function setSalary($salary)
    {
        $this->salary = $salary;
    }
}

$worker1 = new Worker();
$worker1->setName('Иван');
$worker1->setAge(25);
$worker1->setSalary(1000);

$worker2 = new Worker();
$worker2->setName('Вася');
$worker2->setAge(26);
$worker2->setSalary(2000);

echo "Задача 5.\n Сумма зарплат для объектов '{$worker1->getName()}' и '{$worker2->getName()}': " .
    ($worker1->getSalary() + $worker2->getSalary()) . "\n";

class Student extends User
{
    private $scholarship;
    private $exchange;


    public function getScholarship()
    {
        return $this->scholarship;
    }

    public function setScholarship($scholarship)
    {
        $this->scholarship = $scholarship;
    }

    public function getExchange()
    {
        return $this->exchange;
    }

    public function setExchange($exchange)
    {
        $this->exchange = $exchange;
    }

}

//6. Сделайте класс `Driver` (Водитель), который будет наследоваться от класса `Worker` из предыдущей задачи. Этот метод должен вносить следующие `private` поля: водительский стаж, категория вождения (A, B, C).

class Driver extends Worker
{
    private $experience;
    private $category;

    public function getExperience()
    {
        return $this->experience;
    }

    public function setExperience($experience)
    {
        $this->experience = $experience;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

}

//7. Создайте класс `Form` - оболочку для создания форм. Он должен иметь методы `input`, `submit`, `password`, `textarea`, `open`, `close`. Каждый метод принимает массив атрибутов.

class Form
{
    public function input(array $attr_arr)
    {
        $tag = '<input type="{type}" value="{value}">';
        return $this->fillElements($attr_arr, $tag);
    }

    public function submit(array $attr_arr)
    {
        $tag = '<input type="submit" value="{value}">';
        return $this->fillElements($attr_arr, $tag);
    }

    public function password(array $attr_arr)
    {
        $tag = '<input type="password" value="{value}">';
        return $this->fillElements($attr_arr, $tag);
    }

    public function textarea(array $attr_arr)
    {
        $tag = '<textarea placeholder="{placeholder}">{value}</textarea>';
        return $this->fillElements($attr_arr, $tag);
    }

    public function open(array $attr_arr)
    {
        $tag = '<form action="{action}" method="{method}">';
        return $this->fillElements($attr_arr, $tag);
    }

    public function close()
    {
        return '</form>';
    }

    private function fillElements(array $replace_arr, string $strToFill)
    {
        if (count($replace_arr) === 0) {
            return $strToFill;
        } else {
            $pref = "{";
            $postf = "}";
            $rarr = [];
            foreach ($replace_arr as $key => $val) {
                $rarr[$pref . $key . $postf] = $val;
            }
            return str_replace(array_keys($rarr), array_values($replace_arr), $strToFill);
        }
    }
}

$form = new Form();

echo "Задача 7.\n";
echo "form->open: " . htmlspecialchars($form->open(['action' => 'index.php', 'method' => 'POST'])) . "\n";
//Код выше выведет <form action="index.php" method="POST">

echo "form->input: " . htmlspecialchars($form->input(['type' => 'text', 'value' => '!!!'])) . "\n";
//Код выше выведет <input type="text" value="!!!">

echo "form->password: " . htmlspecialchars($form->password(['value' => '!!!'])) . "\n";
//Код выше выведет <input type="password" value="!!!">

echo "form->submin: " . htmlspecialchars($form->submit(['value' => 'go'])) . "\n";
//Код выше выведет <input type="submit" value="go">

echo "form->textarea: " . htmlspecialchars($form->textarea(['placeholder' => '123', 'value' => '!!!'])) . "\n";
//Код выше выведет <textarea placeholder="123">!!!</textarea>

echo "form->close: " . htmlspecialchars($form->close()) . "\n";
//Код выше выведет </form>


//8. Создайте класс `Cookie` - оболочку над работой с куками. Класс должен иметь следующие методы: установка куки `set(имя куки, ее значение)`, получение куки `get(имя куки)`, удаление куки `del(имя куки)`.

class Cookie
{
    public function set($cookieName, $cookieValue)
    {
        return setcookie($cookieName, $cookieValue);
    }

    public function get($cookieName)
    {
        return $_COOKIE[$cookieName];
    }

    public function del($cookieName)
    {
        return setcookie($cookieName, "", time() - 3600);
    }
}

//9. Создайте класс `Session` - оболочку над сессиями. Он должен иметь следующие методы: создать переменную сессии, получить переменную, удалить переменную сессии, проверить наличие переменной сессии. Сессия должна стартовать (`session_start`) в методе `__construct`.

class Session
{
    const SESSION_STARTED = TRUE;
    const SESSION_NOT_STARTED = FALSE;
    private $sessionState = self::SESSION_NOT_STARTED;

    /**
     * (Re)starts the session.
     * TRUE if the session has been initialized, else FALSE.
     */
    public function __construct()
    {
        if ($this->sessionState == self::SESSION_NOT_STARTED) {
            $this->sessionState = session_start();
        }
    }

    /**
     * @param string $ses_VarName
     * @param string $ses_VarValue
     */
    public function set(string $ses_VarName, string $ses_VarValue)
    {
        $_SESSION["$ses_VarName"] = $ses_VarValue;
    }

    /**
     * @param string $ses_VarName
     * @return mixed
     */
    public function get(string $ses_VarName)
    {
        if ($this->check($ses_VarName)) {
            return $_SESSION["$ses_VarName"];
        } else {
            return null;
        }
    }

    public function del($ses_VarName)
    {
        if ($this->check($ses_VarName)) {
            unset($_SESSION["$ses_VarName"]);
        }
    }

    /**
     * @param $ses_VarName
     * @return bool
     */
    public function check($ses_VarName): bool
    {
        return isset($_SESSION[$ses_VarName]);
    }

    public function destroy()
    {
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(), '', 0, '/');
//        session_regenerate_id();
        $this->sessionState = self::SESSION_NOT_STARTED;
    }

}

$mysession = new Session();
$mysession->set('user', 'Mike');
echo "Задача 9.\n Переменная 'user' в сессии c ID = '" . session_id() . "' имеет значение: '" . $mysession->get('user') . "'";
$mysession->del('user');
echo "\n Переменная 'user' удалена, попытка чтения значения: '" . $mysession->get('user') . "'";
echo "\n Переменная 'erere' не была установлена, попытка чтения ее значения: '" . $mysession->get('erere') . "'";

$mysession->destroy();
echo "\n Сессия удалена (SID = '" . session_id() . "')!";
