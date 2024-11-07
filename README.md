задание №1: файлы app\Helpers\event_helpers.php и app\Http\Controllers\OrdersController.php

    >Важно учесть, если запрос будет происходить одновременно, не должно возникнуть такой ситуации, что двум разным заказам присвоился один номер.

    Это условие не совсем понял. Мы же делаем запрос к сторонней апи, то есть, не можем повлиять на её ответы. На нашей стороне, в свою очередь, уникальность штрихкода обеспечена флагом unique на столбце barcode в таблице orders. При попытке вставить запись с уже существующим штрихкодом можем поймать exception и перегенировать его.

    Запросы закомментил. Ответы на эти запросы представляют собой просто строку, вычисленную случайно.

задание №2.1: 

    предложил бы следующее (многие ко многим)
    
    таблица price_variants

        id | event_id | title (групповой, льготный т.д) | price

        event_id для вывода доступных билетов на событие.

    таблица orders

        id | event_id | barcode

        возможно, event_id не столь нужна. Но, как вариант, если понадобится вывести все заказы на какое-то событие, то этот столбец нам это позволит.

    таблица order_bodies (связующая)

        id | order_id | price_var_id | quantity

        столбцы с внешним ключем заказа, ключами цены и количеством билетов, купленных по этой цене

    2. можно вместо этого пользоваться столбцами с типом json

        например:
            
        orders

        id | event_id | tickets (json)

        tickets example: 

        {
            ticket_types: {0 => 'льготный', 1 => 'групповой'}
            ticket_quantities: {0 => 3, 1 => 5} 
        }

        тут больше ньюансов. Нужна обработка этой строки в репрезентативные данные. Кто-то может несанкционарованно вставить в базу неправильные данные и тд.
        Итог: работать с подобными столбцами будет сложнее, но производительность бд будет лучше, вроде как.

задание №2.2:

    основу возьму с первого подзадания.

    таблица price_variants

        id | event_id | title (групповой, льготный т.д) | price

        event_id для вывода доступных билетов на событие.

    таблица orders

        id | event_id

        возможно, event_id не столь нужна. Но, как вариант, если понадобится вывести все заказы на какое-то событие, то этот столбец нам это позволит.

    таблица order_bodies (связующая)

        id | order_id | price_var_id  | barcode 

        столбцы с внешним ключем заказа, ключами цены и количеством билетов, купленных по этой цене

    добавил колонку barcode и убрал quantity в связующей таблице. Теперь каждому элементу из тела заказа может быть присвоен свой код.



        