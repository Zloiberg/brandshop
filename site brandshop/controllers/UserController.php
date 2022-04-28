<?php


class UserController
{

    public function actionRegister()
    {
        $index['title'] = 'Registration';
        $name = false;
        $email = false;
        $password = false;
        $result = false;

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = false;

            
            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }
            
            if ($errors == false) {
                // Если ошибок нет
                // Регистрируем пользователя
                $result = User::register($name, $email, $password);
            }
        }

        
        require_once(ROOT . '/views/user/register.php');
        return true;
    }
    

    public function actionLogin()
    {
        $email = false;
        $password = false;
        
        if (isset($_POST['submit'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = false;

            
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            // Проверяем существует ли пользователь
            $userId = User::checkUserData($email, $password);

            if ($userId == false) {
                // Если данные неправильные - показываем ошибку
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                // Если данные правильные, запоминаем пользователя (сессия)
                User::auth($userId);

                // Перенаправляем пользователя в закрытую часть - кабинет 
                header("Location: /cabinet");
            }
        }

        
        require_once(ROOT . '/views/user/login.php');
        return true;
    }


    public function actionLogout()
    {
        // Стартуем сессию
        session_start();
        
        // Удаляем информацию о пользователе из сессии
        unset($_SESSION["user"]);
        
        // Перенаправляем пользователя на главную страницу
        header("Location: /");
    }

}
