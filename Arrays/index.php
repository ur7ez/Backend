<?php
//Deatailes here:
//https://github.com/Gendos-ua/academy_lessons/blob/master/01_arrays/homework.md
echo "<pre>";

//1. Выведите на экран `$n` раз фразу "Silence is golden". (`for`)
$n = 10;
for ($i = 1; $i <= $n; $i++) {
    echo str_pad("$i.", 4, ' ', STR_PAD_RIGHT) . "Silence is golden" . PHP_EOL;
}
//2. Найти сумму чисел в диапазоне от 1 до 150 (включительно). (`for, while`)
echo "<br>";
$to_val = 150;
echo "Суммa чисел в диапазоне от 1 до $to_val (включительно):" . PHP_EOL;
for ($i = 1, $k = 0; $i <= $to_val; $i++) {
    $k += $i;
}
echo "FOR: " . $k . PHP_EOL;
$i = 1;
$k = 0;
while ($i <= 150) {
    $k += $i;
    $i++;
}
echo "WHILE: " . $k . PHP_EOL;
//3. Вывести список простых чисел в диапазоне от 1 до 200 (включительно).
$to_val = 200;
echo "<br>Список простых чисел в диапазоне от 1 до $to_val:<br>";
for ($i = 2, $simple_cnt = 0; $i <= $to_val; $i++) {
    $is_simple = true;
    for ($j = 2; $j < $i && $is_simple; $j++) {
        if ($i % $j == 0) $is_simple = false;
    }
    if ($is_simple) {
        $simple_cnt++;
        echo str_pad($i, 3, ' ', STR_PAD_RIGHT), ($simple_cnt % 10) ? " " : "<br>";
    }
}

//4. Вывести числа в следущей последовательности: от 200 до 1. (`for, while, foreach`)
$from_val = 200;
echo "<br><br>Последовательность от $from_val до 1:<br>";
echo "FOR:<br>";
for ($i = $from_val; $i > 0; $i--) {
    echo str_pad($i, 3, ' ', STR_PAD_RIGHT), (($i - 1) % 10) ? " " : "<br>";
}
echo "<br>WHILE:<br>";
$i = $from_val;
while ($i > 0) {
    echo str_pad($i--, 3, ' ', STR_PAD_RIGHT), ($i % 10) ? " " : "<br>";
}
$nat_numbers = range($from_val, 1);
echo "<br>FOREACH:<br>";
foreach ($nat_numbers as $nn) {
    echo str_pad($nn, 3, ' ', STR_PAD_RIGHT), (($nn - 1) % 10) ? " " : "<br>";
}
//5. С помощью цикла вывести произведение чисел от 1 до 50 (`for, foreach`)
$to_val = 50;
echo "<br>Произведение чисел от 1 до $to_val";
for ($i = 1, $k = 1; $i <= $to_val; $i++) {
    $k *= $i;
}
echo "<br>FOR: $k";

$nat_numbers = range(1, $to_val);
$k = 1;
foreach ($nat_numbers as $num) {
    $k *= $num;
}
echo "<br>FOREACH: $k<br>";
//6. Вывести все числа, меньшие 1000, которые делятся без остатка одновременно на 3 и на 5. (`for, while`)
$to_val = 1000;
echo "<br>Числа, меньшие $to_val, которые делятся без остатка одновременно на 3 и на 5:<br>";
echo "<br>FOR:<br>";
for ($i = 0, $k = 0; $i <= $to_val; $i++) {
    if ((($i % 3) + ($i % 5)) == 0) {
        echo str_pad($i, 4, ' ', STR_PAD_RIGHT);
        echo !(++$k % 10) ? "<br>" : "";
    }
}
echo "<br>WHILE:<br>";
$i = 0;
$k = 0;
while ($i <= $to_val) {
    if ((($i % 3) + ($i % 5)) == 0) {
        echo str_pad($i, 4, ' ', STR_PAD_RIGHT);
        echo !(++$k % 10) ? "<br>" : "";
    }
    $i++;
}
//7. Вывести на экран все шестизначные счастливые билеты. Билет называется счастливым, если сумма первых трех цифр в номере билета равна сумме последних трех цифр. Найдите количество счастливых билетов и процент от общего числа билетов.
echo "<br><br>Шестизначные счастливые билеты:<br>";
$from_val = 999000; #100000;
$to_val = 999999;
$time_start = microtime(true);

//делаем двумя видами циклов - FOR (без массива) и FOREACH с массивом и логим время выполнения
if (1) {
    $cycle_type = "FOR";
    for ($i = $from_val, $bingo = 0; $i <= $to_val; $i++) {
        if ($i < 100000) $k = str_pad($i, 6, '0', STR_PAD_LEFT);
        else $k = (string)$i;
        if ($k[0] + $k[1] + $k[2] == $k[3] + $k[4] + $k[5]) {
            echo $k . " ", !(++$bingo % 20) ? "<br>" : "";
        }
    }
} else {
    $cycle_type = "FOREACH";
    $tickets = range($from_val, $to_val);
    $bingo = 0;
    foreach ($tickets as $i) {
        if ($i < 100000) $k = str_pad($i, 6, '0', STR_PAD_LEFT);
        else $k = (string)$i;
        if ($k[0] + $k[1] + $k[2] == $k[3] + $k[4] + $k[5]) {
            echo $k . " ", !(++$bingo % 20) ? "<br>" : "";
        }
    }
}
echo "<br><br>=> Общее кол-во счастливых билетов: $bingo (" . round(100 * $bingo / ($to_val - $from_val + 1), 3) . "%)<br>Total task execution time (used '$cycle_type' cycle): " . round(microtime(true) - $time_start, 3) . " sec<br>";

//8. Заполнить массив длины `$n` нулями и единицами, при этом данные значения чередуются начиная с нуля. (`for, while`)
$n = 10;
echo "<br>Заполнить массив длины `$n` нулями и единицами, при этом данные значения чередуются начиная с нуля<br>";
// как вариант без цикла:
/*
$test_arr = array_fill_keys(range(1, $n, 2), 0) + array_fill_keys(range(2, $n, 2), 1);
ksort($test_arr);
print_r($test_arr);
*/
$test_arr = array();
for ($i = 1; $i <= $n; $i++) {
    $test_arr[$i] = (int)!($i % 2);
}
echo PHP_EOL . "FOR: ", print_r($test_arr, 1);
$i = 1;
while ($i <= $n) {
    $test_arr[$i] = (int)!($i % 2);
    $i++;
}
echo PHP_EOL . "WHILE: ", print_r($test_arr, 1);

//9. Cоздать массив из `$n` чисел, каждый элемент которого равен квадрату своего индекса. (`for`)
$n = 10;
echo "<br>Cоздать массив из `$n` чисел, каждый элемент которого равен квадрату своего индекса<br>";
$test_arr = array();
for ($i = 1; $i <= $n; $i++) {
    $test_arr[$i] = $i * $i;
}
echo PHP_EOL, print_r($test_arr, 1);
//10. Даны два упорядоченных по возрастанию массива. Образовать из этих двух массивов единый упорядоченный по возрастанию массив.
$arr1 = range(31, 90, 2);
$arr2 = range(30, 90, 2);
echo "<br>Образовать из двух упорядоченных по возрастанию массивов единый упорядоченный по возрастанию массив<br>";
echo "<div style='display: inline-block'>";
$arr3 = array_merge($arr1, $arr2);
sort($arr3, SORT_NUMERIC);
echo "<div style='float:left'>";
echo PHP_EOL . "1st sorted array = ", print_r($arr1, 1) . PHP_EOL;
echo "</div>";
echo "<div style='float:left;padding: 0 20px;'>";
echo PHP_EOL . "2nd sorted array = ", print_r($arr2, 1) . PHP_EOL;
echo "</div>";
echo "<div style='float:left'>";
echo PHP_EOL . "single sorted array = ", print_r($arr3, 1) . PHP_EOL;
echo "</div></div><br>";

//11. Дана переменная `$n` - число, которое не превосходит 100000 (сто тысяч). Вывести прописью число, которое она хранит (например, 2134 - две тысячи сто тридцать четыре). Массив использовать необязательно.

$n = 903050;  //не более 100.000
//создаем двумерный массив [позиция разряда][переводы цифр] написания цифр для каждого разряда (разряды считаем с конца, т.е. первый элемент - написания для единиц, второй - для десятков, третий - для сотен и т.д.)
$digits_enum_rus = [
    1 => ['0' => "",
        '1' => "один",
        '2' => "два",
        '3' => "три",
        '4' => "четыре",
        '5' => "пять",
        '6' => "шесть",
        '7' => "семь",
        '8' => "восемь",
        '9' => "девять"],
    2 => ['0' => "",
        '1' => "десять",
        '2' => "двадцать",
        '3' => "тридцать",
        '4' => "сорок",
        '5' => "пятьдесят",
        '6' => "шестьдесят",
        '7' => "семьдесят",
        '8' => "восемьдесят",
        '9' => "девяносто"],
    3 => ['0' => "",
        '1' => "сто",
        '2' => "двести",
        '3' => "триста",
        '4' => "четыреста",
        '5' => "пятьсот",
        '6' => "шестьсот",
        '7' => "семьсот",
        '8' => "восемьсот",
        '9' => "девятьсот"]
];
$complex_2digit_numbers = [
    '11' => 'одиннадцать',
    '12' => 'двенадцать',
    '13' => 'тринадцать',
    '14' => 'четырнадцать',
    '15' => 'пятнадцать',
    '16' => 'шестнадцать',
    '17' => 'семнадцать',
    '18' => 'восемнадцать',
    '19' => 'девятнадцать'
];
$gr_nubers = [4 => "тысяч", 7 => "миллион", 10 => "миллиард"];
$num_res = array();
$tmp_n = (string)$n;
$num_len = strlen($tmp_n);
$i = $num_len - 1; //кол-во цифр в числе
//массив пробегаем по тысячным разрядам, сбрасывая счетчик разрядов
for ($pos = 1, $j = $num_len; $i >= 0; $i--, $j--, $pos++) {
    $cur_digit = $tmp_n[$i];
    //проверяем переход тысячных разрядов
    if ((($pos % 3) == 1) && ($pos > 3)) {
        $num_res[$j] = $gr_nubers[$num_len - $i];
        $pos = 1;
        $j--;
    }
    //проверка на двух-значное число
    if (($pos == 2) && array_key_exists($cur_digit . $tmp_n[$i + 1], $complex_2digit_numbers)) {
        $num_res[$j] = $complex_2digit_numbers[$cur_digit . $tmp_n[$i + 1]];
        unset($num_res[$j + 1]);
    } else {
        $num_res[$j] = $digits_enum_rus[$pos][$cur_digit];
        if ($num_res[$j] == '') unset($num_res[$j]);
    }
}
ksort($num_res);
$number_in_spelling = implode(' ', $num_res);
echo "<div>" . "Число $n прописью: <b><i>" . $number_in_spelling, "</i></b></div>";

//12. Создать массив, который содержит полный список букв латинского алфавита. Вывести каждую вторую букву алфавита с новой строки. (`foreach`)
echo "<br>Массив, который содержит полный список букв латинского алфавита: <br>";
$latino = range('A', 'Z');
foreach ($latino as $key => $abc) {
    echo ($key % 2) ? ($key + 1) . ". $abc<br>" : "";
}
