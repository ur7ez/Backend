<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 12.09.2017
 * Time: 15:13
 */
echo "<pre>";
//1. Написать функцию, которая возводит число в заданную степень и возвращает его. Число передается в функцию первым аргументом, степень - вторым. По-умолчанию аргумент степени должен принимать значение `2`. (Использовать встроенную в язык функцию `pow` нельзя)
/**
 * @param $a
 * @param int $power
 * @return mixed
 */
function in_pwr($a, $power = 2)
{
    return number_format($a ** $power, 0, ',', '.');
}

$n = 8;
$power = 11;
echo "1. Результат от возведения числа $n в степень ";
echo isset($power) ? "$power : " . in_pwr($n, $power) : "2: " . in_pwr($n), PHP_EOL;

//2. Написать функцию, которая создает массив и заполняет его случайными числами в диапазоне, указанном пользователем. Функция должна принимать три аргумента - начало диапазона, его конец и длину требуемого массива. После генерации она должна вернуть созданный массив.
function array_rnd($r_start, $r_end, $arr_length)
{
    $arr = [];
    for ($i = 0; $i < $arr_length; $i++) {
        $arr[$i] = rand($r_start, $r_end);
    }
    return $arr;
}

$r_start = 0;
$r_end = 100;
$array_lnth = 20;
echo "2. Массив длиной $array_lnth со случайными значениями от $r_start до $r_end: " . PHP_EOL;
print_r(array_rnd($r_start, $r_end, $array_lnth));

//3. Написать функцию, которая будет возвращать сумму элементов целочисленного массива, который был передан в нее первым аргуметом.
function arr_summ($arr)
{
    return array_sum($arr);
}

$my_arr = [121, 234, 683, 7843, 23456, 5632, 112, 9];
echo "3. Дан целочисленный массив:" . PHP_EOL;
print_r($my_arr);
echo "Сумма его элементов равна: " . number_format(arr_summ($my_arr), 0, ',', '.') . PHP_EOL;

//4. Сгенерировать десять массивов из случайных чисел. Найти среди них один с максимальной суммой элементов и вывести его на экран. При решении задачи использовать две функции из двух задач выше.

echo "4.<br>4.1 Сгенерировать десять массивов из случайных чисел:" . PHP_EOL;
$my_arrs = array();
$max_sum = [];
$j = 0;
$cur_arr_summ = 0;
for ($i = 1; $i <= 10; $i++) {
    echo ($i == 10) ? "<div>" : "<div style='float: left;padding-right:20px;'>";
    $my_arrs[$i] = array_rnd($r_start, $r_end, $array_lnth);
    $cur_arr_summ = arr_summ($my_arrs[$i]);
    if ($cur_arr_summ > $j) {
        $max_sum[0] = $i;
        $max_sum[1] = $cur_arr_summ;
        $j = $cur_arr_summ;
    }
    echo "[$i] => ";
    print_r($my_arrs[$i]);
    echo "</div>";
}
echo "<br>4.2 Массив с максимальной суммой - №" . $max_sum[0] . " (" . $max_sum[1] . "):" . PHP_EOL;
print_r($my_arrs[$max_sum[0]]);

//5. Написать функцию, которая принимает один аргумент по ссылке - строку. Функция должна добавить в конец входящей строки строку ` functioned!`. Возвращать функция ничего не должна.
/**
 * @param string $arg
 */
function some_func(&$arg)
{
    $arg .= " functioned!";
}

$my_string = "Some string";
echo "<br>5. Функция с аргументом, передаваемым по ссылке: '$my_string' ";
some_func($my_string);
echo "выдает в результате: '$my_string'" . PHP_EOL;

//_Рекурсия_
//6. Написать функцию, которая принимает один аргумент - натуральное число `n`. Функция должна вывести все числа от `1` до `n` через пробел. Циклы или функцию `range` использовать нельзя.
function my_recursion($n)
{
    if ($n < 1 || gettype($n) <> 'integer') {
        return false;
    } else {
        echo $n . " " . my_recursion(--$n);
    };
}

$n = 10;
echo "<br>6. Функция с рекурсией (повтор числа от 1 до n). вывод для n = $n:" . PHP_EOL;
my_recursion($n);
