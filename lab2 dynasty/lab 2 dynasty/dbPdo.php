<?php

//функция, которая осуществляет подключение к базе. Создается объект класса PDO (класс представляет соединение между БД и PHP)
//На вход получает параметры о расположении базы данных (сервер, логин, пароль, имябазы)
//формирует строку подключения и устанавливает обязательные параметры
function dbConnect($host = 'localhost', $user = 'root', $pass = '', $dbName = 'webdevelopment')
{
	$dsn = "mysql:host=$host;dbname=$dbName";
	$opt = array(
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);

	$pdo = new PDO($dsn, $user, $pass, $opt);

	return $pdo;	

}
//Функция, которая осуществляет запрос к базе данных
//метод prepare() осуществляет подготовку запроса к выполнению
//метод execute() выполняет запрос. В зависимости от того необходимо ли подставить в запрос параметры
//используется третий аргумент $params.
//Функция is_array проверяет является ли переданный операнд массивом
function dbQuery($pdo, $query, $params = false) 
{

	$q = $pdo->prepare($query);
	
	if (is_array($params)){
		
		$q->execute($params);
		
	}
	else
	{
		$q->execute();
	}

	return $q;
}
//Функция, которая устанавливает кодировку базы данных.
//Необходима для корректного ввода/вывода (исключение кракозябр)
function dbSetCharset($pdo, $charset, $collation_connection){

	dbQuery($pdo, "SET NAMES '".$charset."'");
	dbQuery($pdo, "SET CHARACTER SET '".$charset."'");		
	dbQuery($pdo, "SET SESSION collation_connection = '".$collation_connection."'");


}

?>