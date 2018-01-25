<?
echo "Задание №1"."<hr>";
//В переменную $content помещаем содержимое файла main_list_name.txt
$content='';
$content = file_get_contents('main_list_name.txt');
//По запятой разбиваем содержимое файла и ложим в массив полученные значения
$array_list = explode(",", $content);
//Сортируем массив
sort($array_list, SORT_STRING);


//Создаём массив для хранения файлов расположенных в каталоге 
$array_list_folder = array();
//Сканируем каталог и ложим в объект $Regex названия файлов  
$Directory = new RecursiveDirectoryIterator('main_dir');
$Iterator = new RecursiveIteratorIterator($Directory);
$Regex = new RegexIterator($Iterator, '/^.+\.txt$/i', RecursiveRegexIterator::GET_MATCH);
//Перезаписываем объект в массив $array_list_folder
foreach ($Regex as $key => $value) {
         array_push($array_list_folder, $key);
}

//Сортируем массив $array_list_folder с помощью пользовательской функции $params
//Сортируем происходит по названиям файлов лежащих в директории main_dir и во вложенных папках
usort($array_list_folder, 'params');

function params($a, $b) {

    if ($a == $b) {
        return 0;
    }

    $a_cmp = substr($a, strrpos($a, '\\', 2));
    $b_cmp = substr($b, strrpos($b, '\\', 2));

    return ($a_cmp < $b_cmp) ? -1 : 1;
}


//Сравниваем массивы с названиями с файла main_list_name.txt и c папки main_dir 

for ($i=0; $i < count($array_list_folder); $i++) { 
        $c="";
        for ($j=0; $j < count($array_list); $j++) { 
              //Если названиия файлов совпадают, то выходим из цикла и переходи к следующим значениям  
             if(substr($array_list_folder[$i], strrpos($array_list_folder[$i],'\\', 2) + 1) === $array_list[$j])
              {$c=""; break;} 
              //Если названиия файлов совпадают частично, то проверяем на сколько отличаются названия файлов
              else if (substr($array_list_folder[$i], strrpos($array_list_folder[$i],'\\', 2) + 1, -4) === substr($array_list[$j], 0, strrpos($array_list_folder[4],'\\', 2)+1-5)) {
                        //Если на более чем 10% записываем это
                        if(strlen(substr($array_list_folder[$i], strrpos($array_list_folder[$i],'\\', 2) + 1)) < strlen($array_list[$j]) - 1){
                           $c = $array_list_folder[$i].":Отличие более чем на 10%";
                           break;     
                        }
                        //Если на 10 % отмечаем это
                        else{
                           $c = $array_list_folder[$i].":Отличие - 10%";
                           break;    
                        }
                  

                 }
             else {
                $c = $array_list_folder[$i];
             }
        }
        //Выводим на экран все не совпадающие файлы
        if($c !== ""){
        echo $c."&#160"."&#160"."&#160";}
      
}

echo "<br>"."<br>"."Задание №2"."<hr>";
//Получаем содержимое данного файла и спомощью функции htmlentities записіваем в тег <pre>

echo '<pre>' . htmlentities(file_get_contents('./index.php')) . '</pre>';





?>