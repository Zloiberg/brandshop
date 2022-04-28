<?php


 
class Cart
{

    public static function addProduct($id)
    {
        $id = intval($id);

        $productsInCart = array();
//если в корзине есть продукты то они хранятся в сессии
        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];
        }

        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id] ++;
        } else {
            $productsInCart[$id] = 1;
        }

        $_SESSION['products'] = $productsInCart;

        return self::countItems();
    }

   
    public static function countItems()
    {
        // Проверка наличия товаров в корзине
        if (isset($_SESSION['products'])) {
            // Если массив с товарами есть
            // Подсчитаем и вернем их количество
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }

    
     // Возвращает массив с идентификаторами и количеством товаров в корзине<br/>

    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

    //стоимость передан товеров
    public static function getTotalPrice($products)
    {
        $productsInCart = self::getProducts();

        // Подсчитываем общую стоимость
        $total = 0;
        if ($productsInCart) {
            foreach ($products as $item) {
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }

        return $total;
    }

    //очистка корзины
    public static function clear()
    {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }

   //удаление товара из корзины
    public static function deleteProduct($id)
    {
        $productsInCart = self::getProducts();

        unset($productsInCart[$id]);

        $_SESSION['products'] = $productsInCart;
    }

}
