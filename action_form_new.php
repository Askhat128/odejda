<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, отправлены ли данные формы и не пусты ли они
    if (isset($_POST["lastname"]) && !empty($_POST["lastname"])) {
        $lastname = htmlspecialchars($_POST["lastname"]);
        echo "Вы ввели фамилию: " . $lastname . "<br>";
    } else {
        echo "Поле 'Фамилия' не заполнено.<br>";
    }

    if (isset($_POST["firstname"]) && !empty($_POST["firstname"])) {
        $firstname = htmlspecialchars($_POST["firstname"]);
        echo "Вы ввели имя и отчество: " . $firstname . "<br>";
    } else {
        echo "Поле 'Имя, Отчество' не заполнено.<br>";
    }

    if (isset($_POST["answer"]) && !empty($_POST["answer"])) {
        $answer = htmlspecialchars($_POST["answer"]);
        echo "Вы ввели: " . $answer . "<br>";
    } else {
        echo "Поле 'Ваши предложения' не заполнено.<br>";
    }

    // Подключение к базе данных (код подключения без изменений)
    $host = "localhost";
    $database = "survey_responses";
    $username = "root";
    $password = "";

    try {
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password, $opt);
        $conn->exec("set names utf8");

        // Подготавливаем SQL-запрос
        $query = $conn->prepare("INSERT INTO survey_responses (lastname, firstname, answer) values (:lastname, :firstname, :answer)");
        $data = array('lastname' => $lastname, 'firstname' => $firstname, 'answer' => $answer);

        // Выполняем запрос с данными и проверяем результат
        if ($query->execute($data) && $query->rowCount() > 0) {
            echo "<br>Информация занесена в базу данных";
        } else {
            echo "<br>Ошибка при записи данных в базу данных.";
        }
        echo "<br>";
    } catch (PDOException $e) {
        //Более подробное сообщение об ошибке для отладки
        error_log("Database error: " . $e->getMessage());
        echo "Произошла ошибка. Пожалуйста, попробуйте позже.";
    }
    $conn = null;
}

