<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 14.09.2017
 * Time: 16:24
 */
echo "<pre>";
//1. Дан массив элементов `'one', 'two', 'three', 'four', 'five', 'six'`, при помощи функции `usort` и анонимной функции для сортировки нужно отсортировать этот массив таким образом, чтобы в итоге его элементы выстроились в таком порядке:
//`'two', 'one', 'four', 'three', 'six', 'five'`.

$arr = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten'];
echo "1. Array before applying custom sort:<br>", print_r($arr, 1), PHP_EOL;
//echo "Iter\t a= \t b= \treturn", PHP_EOL . "-----------------------------" . PHP_EOL;
usort($arr, function ($a, $b) use ($arr) {
    //требуется запоминать ключи исходного массива, так как функция usort() не передает и не сохраняет исходные ключи
    // после раюоты
    $pos_a = array_search($a, $arr);
    $pos_b = array_search($b, $arr);
    //проверяем 3 варианта позиций элементов в исходном массиве (отсчет идет от 0):
    //1. позиции обоих элементов - либо четные, лиюо нечетные:
    if ((($pos_a & 1) && ($pos_b & 1)) || (!($pos_a & 1) && !($pos_b & 1))) {
        $result = ($pos_a < $pos_b) ? -1 : 1;
        //2. позиция первого аргумента - нечетная, второго - четная:
    } elseif (($pos_a & 1) && !($pos_b & 1)) {
        $result = ($pos_a - $pos_b <= 1) ? -1 : 1;
        //3. позиция первого аргумента - четная, второго - нечетная:
    } else {
        $result = ($pos_a - $pos_b <= -3) ? -1 : 1;
    }
//    static $cnt = 0;
//    ++$cnt;
//    echo "$cnt \t $a \t $b \t " . $result . PHP_EOL;
    return $result;
});
echo "... array after applying custom sort callback func:", print_r($arr, 1), PHP_EOL;
echo "<hr>";

//2. При помощи функции `range` создать массив целых чисел произвольной длины. При помощи функции `array_filter` и анонимной функции отфильтровать элементы массива таким образом, чтобы в нем остались только те элементы, которые делятся одновременно на `3`, `2`, `5` без остатка.
$arr_first = 22;
$arr_last = 185;
$my_arr = range($arr_first, $arr_last);
$my_arr = array_filter($my_arr, function ($var) {
    return !($var % (2 * 3 * 5));
});
echo "2. Отфильтрованный массив целых чисел [$arr_first .. $arr_last] (только те элементы, которые делятся одновременно на `3`, `2`, `5` без остатка):"
    . PHP_EOL;
print_r($my_arr);
echo "<hr>";

//3. Дана строка - `Walks Straight walked numbly through the destruction. Nothing left, no one alive.`. Разбить строку на массив слов (так, чтобы не осталось спец.символов - `,` `.`). При помощи функции `usort` и анонимной функции для сортировки отсортировать массив таким образом, чтобы его элементы выстроились от самого короткого слова к самому длинному.
$my_str = "Walks Straight walked numbly through the destruction. Nothing left, no one alive.";
$arr_of_string = str_word_count($my_str, 2);
echo "3. Сортируем слова из строки '$my_str' (от короткого для самого длинного):" . PHP_EOL;
usort($arr_of_string, function ($a, $b) {
    return (strlen($a) < strlen($b)) ? -1 : 1;
});
print_r($arr_of_string);
echo "<hr>";

//4. Создать функцию с именем `sayHello`, которая принимает один аргумент - строку `$name`(указать тип аргумента). Функция должна выводить сначала строку `Привет, $name`. А затем строку, в которой будет сказанно, сколько раз функция была вызвана в формате `Всего поздоровались $n раз`. Вызвать функцию несколько раз с разным значением параметра.
function sayHello(string $name)
{
    static $cnt_names = array();
    if (array_key_exists($name, $cnt_names)) {
        $cnt = $cnt_names[$name] + 1;
        $cnt_names[$name] = $cnt;
        return "Всего Вы, $name, поздоровались $cnt раз(а)";
    } else {
        $cnt_names[$name] = 1;
        return "Привет, $name!";
    }

}

echo "4. Вызываем функцию со статической переменной:" . PHP_EOL;
$users_arr = ['Tanya', 'Mike', 'Tanya', 'Con', 'Alex', 'Con', 'Alex', 'Alex'];
$j = count($users_arr);
while ($j--) {
    echo "Пришел поздороваться пользователь '" . $users_arr[$j] . "'. Ответ системы: <b>" . sayHello($users_arr[$j]) .
        "</b>" . PHP_EOL;
}
echo "<hr>";

//5. Написать функцию, которая принимает один(!) аргумент - натуральное число. При каждом вызове функция должна возвращать среднее арифметическое значение переданных в нее чисел с учетом всех предыдущих вызовов. Пример:
//```php
//    echo func(1);  // 1/1 = 1
//    echo func(5);  // (1+5)/2 = 3
//    echo func(3);  // (1+5+3)/3 = 3
//    echo func(31); // (1+5+3+31)/4 = 10
//```
echo "5. Функция, которая возвращает ср.арифм. накапленной суммы итеративно передаваемых аргументов:";
function mat_aver(int $nat)
{
    static $prev_nat = 0;
    static $cnt = 0;
    static $str_nats = ""; //статич. переменная для вывода комментария расчетов
    $str_nats = (!$prev_nat) ? "($nat" : "$str_nats+$nat";
    $prev_nat += $nat;
    ++$cnt;
    echo "<br> $str_nats)/$cnt = ";
    return $prev_nat / $cnt;
}

$j = 10;
while ($j--) {
    $n = rand(0, 100);
    echo mat_aver($n);
}
echo "<hr>";

//*6. Дано слово, состоящее только из строчных латинских букв. Напишите функцию, которая проверит, является ли это слово палиндромом. Выведите `да` или `нет`. При решении этой задачи нельзя использовать циклы, массивы и функции разворота строки. Рекурсия разрешена :)
echo "*6. Функция, проверяющая слово на палиндром:" . PHP_EOL;
function word_palindrom(string $word)
{
    static $cnt = -1;
    if ((strlen($word) - $cnt - 1 <= $cnt) || (strlen($word) == 1)) {
        return 1;
    }
    ++$cnt;
    return (strtolower($word[strlen($word) - $cnt - 1]) == strtolower($word[$cnt])) && word_palindrom($word);
}
$some_lat_word = 'saippuakivikauppias';
echo "слово '$some_lat_word' - ", (word_palindrom($some_lat_word)) ? "палиндром" : "НЕ палиндром";
echo "<br>";

//*7. Дано число `n`, десятичная запись которого не содержит нулей. Получите число, записанное теми же цифрами, но в противоположном порядке. При решении этой задачи нельзя использовать циклы, строки, массивы, разрешается только рекурсия и целочисленная арифметика. Функция должна возвращать целое число, являющееся результатом работы программы, выводить число по одной цифре нельзя. Можно использовать дополнительные аргументы для передачи данных между рекурсивными вызовами.
//Пример:
//    echo func(235); // 532
echo "<hr>";
echo "<hr>";
$n = 2351894; // десятичная запись: N = an⋅10^n + a(n−1)⋅10^(n−1) + … + a1⋅10 + a0
function num_reverse(int $n, int $inp_tail = 0): int
{
    if ($n < 1) {
        return $inp_tail + $n;
    } else {
        return num_reverse(intval($n / 10), $inp_tail * 10 + ($n % 10));
    }
}
echo "*7. Функция, которая 'переворачивает' число $n: <u>", num_reverse($n), "</u><br>";
