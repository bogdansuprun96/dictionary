<?
$words = $_POST['WordArray']; // Получаємо данні з 1ї колонки
$translate = $_POST['TranslateArray']; // Получаю данні здругої колонки
if (!empty($words) && !empty($translate)) // Перевіряю чи заповнені колонки
{
    # Очищаю перший масив від пустих значень
    $words = array_filter($words, function($element) {
        return !empty($element);
    });
    # Також очищаю другий масив від пустих значень
    $translate = array_filter($translate, function($element) {
        return !empty($element);
    });

/*    print_r($words);
    print_r($translate);*/
    $cWords = count($words); # Дізнаюсь кількість ключів першого масиву
    $cTransl = count($translate); # Дізнаюсь кількість ключів другого масиву
    require 'rb.php'; # Підключаю бібліотеку ORM
    R::setup('mysql:host=localhost;dbname=words',
        'root',''); //mysql

    # Повторна перевірка якщо масиви мають однакову кулькість слів
    if ((int)$cWords === (int)$cTransl){
        # Додатково ділю на два
        $cCount = ($cWords + $cTransl) / 2;
//        echo $cCount;
        # Відкриваю цикл
        for ($i = 0; $i <= $cWords; $i++)
        {
            # Обираю таблицю
            $english = R::dispense('english');

            # Вказую куди записати відповідні дані
            $english->word = $words[$i];
            $english->translate = $translate[$i];
            # Записую
            $res = R::store($english);
            echo "Слова успішно додані!";
        }
    }

}
else
{
    # Помилка у випадку не вірно введених данних
    echo "FATAL ERROR! Помилка, ви не ввели транксрипцію або слово! Перегляньте ще раз";
}