<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 07.09.2017
 * Time: 22:35
 */
echo "<pre>";
//1. Дана строка. Найти количество слов, начинающихся с буквы `b`.
$mystr = "Following its independence, Ukraine declared itself a neutral state. Nonetheless it formed a limited military partnership with the Russian Federation and other CIS countries and a partnership with NATO in 1994. In the 2000s, the government began leaning towards NATO, and a deeper cooperation with the alliance was set by the NATO-Ukraine Action Plan signed in 2002. It was later agreed that the question of joining NATO should be answered by a national referendum at some point in the future. Former President Viktor Yanukovych considered the current level of co-operation between Ukraine and NATO sufficient, and was against Ukraine joining NATO. /Here we hide semicolon :/ In 2013, after the government of President Yanukovych had decided to suspend the Ukraine-European Union Association Agreement and seek closer economic ties with Russia, a several-months-long wave of demonstrations and protests known as the Euromaidan began, which later escalated into the 2014 Ukrainian revolution that led to the overthrow of President Yanukovych and his cabinet and the establishment of a new government. These events formed the background for the annexation of Crimea by Russia in March 2014, and the War in Donbass in April 2014. On 1 January 2016, Ukraine applied the economic part of the Deep and Comprehensive Free Trade Area with the European Union.";

echo "Дана строка (для всех примеров): ", PHP_EOL, wordwrap($mystr, 150), PHP_EOL;
$look_for = 'b';
$parse_mystr = str_word_count($mystr, 2);

//если нужны слова без повторов, то можно далее использовать:
//$parse_str_un = array_unique($parse_mystr);

$i = 0;
$final_arr = [];
foreach ($parse_mystr as $b) {
    if ($b[0] == $look_for) {
        $final_arr[] = $b;
        $i++;
    }
}
$total_b = count($parse_mystr);
echo PHP_EOL, "1. Words starting with $look_for: $i (" . round(100 * $i / $total_b, 3) . "%) in a total of " . $total_b . " words" . PHP_EOL;
print_r($final_arr);

//2. Дана строка. Подсчитать, сколько в ней букв `r`, `k`, `t`. Вывести результат в виде массива.
echo "<hr>";
$mystr_parse = count_chars($mystr, 1);
$arr = array(
    "r" => $mystr_parse[ord('r')],
    "k" => $mystr_parse[ord('k')],
    "t" => $mystr_parse[ord('t')],
);
echo "2. Letters count for 'r', 'k', 't' (case-sensitive!): " . PHP_EOL;
print_r($arr);

//3. Дана строка. Найти длину самого короткого слова и самого длинного слова.
echo "<hr>";

function cmp($a, $b)
{
    if (mb_strlen($a) == mb_strlen($b)) {
        return 0;
    }
    return (mb_strlen($a) < mb_strlen($b)) ? -1 : 1;
}

$parse_str_un = array_unique($parse_mystr);
usort($parse_str_un, 'cmp');
//print_r($parse_str_un);
echo "3. Самое короткое слово (", mb_strlen($parse_str_un[0]), " символов): ", $parse_str_un[0], ". ";
echo "Самое длинное слово (", mb_strlen(end($parse_str_un)), " символов): ", end($parse_str_un), PHP_EOL;

//4. Дана строка символов, среди которых есть одно двоеточие `:`. Определить, сколько символов ему предшествует.
echo "<hr>";
$needle = ":";
echo "4. Кол-во символов до первого символа '$needle': ", strpos($mystr, $needle), PHP_EOL;

//5. Дана строка. Определить, сколько раз в нее входит подстрока `abc`.
echo "<hr>";
$needle = 'res'; //чтобы не менять базовую строку - ищу то что в ней точно есть :)
echo "5. Кол-во вхождений подстроки '$needle': ", substr_count($mystr, $needle), PHP_EOL;

//6. Дана строка. Подсчитать, сколько уникальных символов встречается в ней. Вывести их на экран в виде массива.
echo "<hr>";
echo "6. Уникальных символов в строке: ", count($mystr_parse), PHP_EOL;
echo "<br> Все символы в данной строке (в скобках указано кол-во раз использования):<br>";
function key_to_chr(&$item, $key)
{
    $item = "\"" . chr($key) . "\"" . " (" . $item . ")";
}

array_walk($mystr_parse, 'key_to_chr');
print_r($mystr_parse);

//7. Дана строка. Найти в ней те слова, которые начинаются и оканчиваются одной и той же буквой.
echo "<hr>";
echo "7. Слова (состоящие более чем из 1-го символа), которые начинаются и оканчиваются одной и той же буквой:<br>";
//print_r($parse_str_un);
foreach ($parse_str_un as $item) {
    if ($item[0] == $item[mb_strlen($item) - 1] && mb_strlen($item) > 1) echo "\t" . $item . PHP_EOL;
}

//8. Дана строка. В строке заменить все двоеточия `:` точкой с запятой `;`. Подсчитать количество замен.
echo "<hr>";
$needle = " ";
$replace_to = "\\";
$repl_cnt = 0;
$mystr1 = str_replace($needle, $replace_to, $mystr, $repl_cnt);
echo "8. Количество замен '$needle' на '$replace_to': $repl_cnt" . PHP_EOL;
echo "Получили строку после замен: " . PHP_EOL . wordwrap($mystr1, 150, "\n", true) . PHP_EOL;

//9. Дана строка, содержащая буквы, целые неотрицательные числа и иные символы. Требуется все числа, которые встречаются в строке, поместить в отдельный целочисленный массив. Например, если дана строка `bear 48 tail9 read13 bl0b`, то в массиве должны оказаться числа `48`, `9`, `13` и `0`.
echo "<hr>";
$mystr1 = "df9#djs 3434n 909cu3:849n 3u 8748h-hg37 48*376 sfdsf";
echo "9. Числа из строки '$mystr1' помещаем в отд. массив:" . PHP_EOL;
preg_match_all('/(\d+)/', $mystr1, $matches);
print_r($matches[0]);

//10. Дана строка. Определите, каких букв (строчных или прописных) в ней больше, и преобразуйте следующим образом: если больше прописных (больших) букв, чем строчных (маленьких), то все буквы преобразуются в прописные; если больше строчных, то все буквы преобразуются в строчные; если поровну и тех и других — текст остается без изменения.
echo "<hr>";
//$mystr = "idfk olkFEDFd fdF__REh'Spd Fvko i=4YKNJHfm+++UUU__ ue";
$mystr_10 = "F__ЗИПh'Цpd Дvko i=4ДЛАЛАар+++UUU__ ваа";
//$mystr = "ijdi45gfUl;lPENH_dfdfklk*:dfdfUR_7Espfkpdшшоа плоапаГЬСОР_ОВдллдлГт ова ГРЦыв2кВ4Ж щjdf HX:kdf sj Hlk;of kJLKX:LD l odfk dsjg LKLKC LRJ";

$arr = array("строчны", "прописны");
$mystr_mod = '';
preg_match_all("/[A-ZА-Я]/u", $mystr_10, $matches, PREG_PATTERN_ORDER);
$l1 = count($matches[0]);
preg_match_all("/[а-яa-z]/u", $mystr_10, $matches, PREG_PATTERN_ORDER);
$l2 = count($matches[0]);
if ($l1 < $l2) {
    $conv_type = 0;
    $mystr_mod = mb_strtolower($mystr_10);
} elseif ($l1 > $l2) {
    $conv_type = 1;
    $mystr_mod = mb_strtoupper($mystr_10);
} else {
    $conv_type = 3;
}

echo "10. В строке<br>'$mystr_10'<br>";
if ($conv_type != 3) {
    echo "больше " . $arr[$conv_type] . "х букв ($l1), чем " . $arr[!$conv_type] . "х ($l2) => меняем все буквы в строке на " . $arr[$conv_type] . "е:" . PHP_EOL;
    echo $mystr_mod . PHP_EOL;
} else echo "одинаковое кол-во строчных и прописных букв, не меняем ничего в строке." . PHP_EOL;

//11. Строка содержит одно слово. Проверить, будет ли оно читаться одинаково справа налево и слева направо (т.е. является ли оно палиндромом).
echo "<hr>";
$mystr_single = "rotor";
$str_encoding = mb_detect_encoding($mystr_single);
$mystr_rev = ($str_encoding <> "ASCII") ? utf8_strrev($mystr_single) : strrev($mystr_single);
if ($mystr_rev == $mystr_single) {
    echo "11. Строка '$mystr_single' - палиндром!";
} else echo "11. Строка '$mystr_single' - НЕ палиндром!";

function utf8_strrev($str)
{
    preg_match_all('/./us', $str, $ar);
    return join('', array_reverse($ar[0]));
}

//12. Дана строка, в которой слова зашифрованы — каждое из них записано наоборот. Расшифровать строку и вывести на экран.
echo "<hr>";
$mystr1 = "gniwolloF sti ecnednepedni, eniarkU deralced flesti a lartuen etats. sselehtenoN ti demrof a detimil yratilim pihsrentrap htiw eht naissuR noitaredeF dna rehto SIC seirtnuoc dna a pihsrentrap htiw OTAN ni 1994. nI eht 2000s, eht tnemnrevog nageb gninael sdrawot OTAN, dna a repeed noitarepooc htiw eht ecnailla saw tes yb eht eniarkU-OTAN noitcA nalP dengis ni 2002.";
echo "12. Дана строка:" . PHP_EOL . wordwrap($mystr1, 150, "\n", true) . PHP_EOL . PHP_EOL;
$parse_mystr = str_word_count($mystr1, 2);
foreach ($parse_mystr as $key => &$arr) {
    $arr = strrev($arr);
    $mystr1 = substr_replace($mystr1, $arr, $key, strlen($arr));
    //if ($key>50) break;
}
//print_r($parse_mystr);
echo "Дешифрованная строка:" . PHP_EOL . wordwrap($mystr1, 150, "\n", true) . PHP_EOL;

//13. Дана строка, определить, каких букв в ней больше - гласных или согласных.
echo "<hr>";
$mystr = $mystr_10;
$mystr_lower = $mystr; //mb_strtolower($mystr);
preg_match_all("/[aeiouаеёиоуыэюя]/ui", $mystr_lower, $matches, PREG_PATTERN_ORDER);
$l1 = count($matches[0]);
preg_match_all("/[б-джзк-нп-тф-ъь]|[b-df-hj-np-tv-xz]/ui", $mystr_lower, $matches, PREG_PATTERN_ORDER);
$l2 = count($matches[0]);
//print_r($matches);
echo "13. В строке:<br><i>", wordwrap($mystr, 150, "\n", true), "<br></i>больше ", ($l1 > $l2) ? "гласных" : "согласных", " букв (", ($l1 > $l2) ? $l1 : $l2, " vs ", ($l1 > $l2) ? $l2 : $l1, ")." . PHP_EOL;

//14. Дан массив строк, в котором хранятся фамилии и инициалы учеников класса (формат: `Иванов И.И.`). Требуется вывести массив, в котором для каждого ученика указано количества его однофамильцев.
echo "<hr>";
$pupils = Array("Петров А.И. ", "Иванов В. В.", "Сидоров С.В.", "Петров Г.К.", "Васильев П.П.", "Сахаров А.С.", "Сидоров Б.Г.", "Иванова Т.М.", "Макарова Т.Н.", "Вредныйдядя В.В.", "Хорошенко В.Р.", "Колодязный П.Ф.", "Смирнов А.Д.", "Петров Ю.Ю.", "Сова З.К.", "Хорошенко С.А.", "Непомнящий Ш.Ц.", "Сукачев Г.Г.", "Хуюй Л.Ю.");

//делаем массив только по фамилиям учеников
$pups = preg_replace("/\s+(\w[\.?\s?]|\w?)+/u", "", implode(";", $pupils));
$pups_array = explode(";", $pups);
// print_r($pups_array);
$new = [];
foreach ($pups_array as $p) {
    $new[] = array_keys($pups_array, $p); //заполняем массив с однофамильцами
}
foreach ($new as $id => $dupes) {
    $dupes_cnt = count($dupes);
    if ($dupes_cnt > 1) {
        //запись в оригинальный массив инфо о однофамильцах:
        $pupils[$id] = $pupils[$id] . "\t($dupes_cnt однофамильца)";
    }
}
echo "14. В списке учеников класса находим однофамильцев и указаываем рядом сколько их:" . PHP_EOL;
print_r($pupils);
