<?php

return [
    'name' => 'Товары',
    'create' => 'Новый товар',
    'edit' => 'Редактировать товар - :name',
    'form' => [
        'name' => 'Name',
        'name_placeholder' => 'Название продукта (максимум 120 символов)',
        'description' => 'Описание',
        'description_placeholder' => 'Краткое описание продукта (не более 400 символов)',
        'categories' => 'Категории',
        'content' => 'Содержание',
        'price' => 'Цена',
        'quantity' => 'Количество',
        'brand' => 'Бренд',
        'width' => 'Ширина',
        'height' => 'Высота',
        'weight' => 'Вес',
        'date' => [
            'end' => 'С даты',
            'start' => 'На данный момент',
        ],
        'image' => 'Изображения',
        'collections' => 'Коллекции продуктов',
        'labels' => 'Ярлыки',
        'price_sale' => 'Цена продажи',
        'product_type' => [
            'title' => 'Тип продукта',
        ],
        'product' => 'Продукт',
        'total' => 'Всего',
        'sub_total' => 'Промежуточный итог',
        'shipping_fee' => 'Стоимость доставки',
        'discount' => 'Скидка',
        'options' => 'Параметры',
        'shipping' => [
            'height' => 'Высота',
            'length' => 'Длина',
            'title' => 'Доставка',
            'weight' => 'Вес',
            'wide' => 'Ширина',
        ],
        'stock' => [
            'allow_order_when_out' => 'Разрешить клиенту создавать заказ, когда этого товара нет в наличии',
            'in_stock' => 'В наличии',
            'out_stock' => 'Нет в наличии',
            'title' => 'Состояние запасов',
        ],
        'storehouse' => [
            'no_storehouse' => 'Нет управления складом',
            'storehouse' => 'С управлением складом',
            'title' => 'Склад',
            'quantity' => 'Количество',
        ],
        'tax' => 'Налог',
        'is_default' => 'По умолчанию',
        'action' => 'Действие',
        'restock_quantity' => 'Количество запасов',
        'remain' => 'Оставайтесь',
        'choose_discount_period' => 'Выберите период действия скидки',
        'cancel' => 'Отмена',
        'no_results' => 'Нет результатов!',
        'value' => 'Значение',
        'attribute_name' => 'Наименование атрибута',
        'add_more_attribute' => 'Добавьте больше атрибутов',
        'continue' => 'Продолжить',
        'add_new_attributes' => 'Добавление новых атрибутов',
        'add_new_attributes_description' => 'Добавление новых атрибутов помогает товару иметь множество вариантов, например, размер или цвет.',
        'create_product_variations' => ':link для создания вариантов товара!',
        'tags' => 'Теги',
        'write_some_tags' => 'Напишите несколько тегов',
        'variation_existed' => 'This variation is existed.',
        'no_attributes_selected' => 'Атрибуты не выбраны!',
        'added_variation_success' => 'Вариант добавлен!',
        'updated_variation_success' => 'Обновление варианта прошло успешно!',
        'created_all_variation_success' => 'Все варианты созданы!',
        'updated_product_attributes_success' => 'Обновление атрибутов продукта прошло успешно!',
        'stock_status' => 'Состояние запасов',
        'auto_generate_sku' => 'Автоматическое генерирование артикула?',
        'featured_image' => 'Избранное изображение (необязательно)',
        'product_id' => 'Продукт ID',
    ],
    'price' => 'Цена',
    'quantity' => 'Количество',
    'type' => 'Тип',
    'image' => 'Миниатюра',
    'sku' => 'Артикул',
    'variation_sku' => 'Артикул варианта',
    'brand' => 'Бренд',
    'cannot_delete' => 'Не удалось удалить продукт',
    'product_deleted' => 'Продукт удалён',
    'product_collections' => 'Коллекции продуктов',
    'products' => 'Продукция',
    'menu' => 'Продукты',
    'control' => [
        'button_add_image' => 'Добавить изображение',
    ],
    'price_sale' => 'Цена продажи',
    'price_group_title' => 'Управление ценой продукта',
    'store_house_group_title' => 'Управление складом',
    'shipping_group_title' => 'Менеджер по доставке',
    'overview' => 'Обзор',
    'attributes' => 'Атрибуты',
    'product_has_variations' => 'Продукт имеет варианты',
    'manage_products' => 'Управление продуктами',
    'add_new_product' => 'Добавить новый продукт',
    'start_by_adding_new_product' => 'Начните с добавления новых продуктов.',
    'edit_this_product' => 'Редактировать этот продукт',
    'delete' => 'Удалить',
    'related_products' => 'Сопутствующие товары',
    'cross_selling_products' => 'Перекрестные продажи товаров',
    'up_selling_products' => 'Самые продаваемые продукты',
    'grouped_products' => 'Сгруппированные товары',
    'search_products' => 'Поиск товаров',
    'selected_products' => 'Избранные товары',
    'edit_variation_item' => 'Редактировать',
    'variations_box_description' => 'Нажмите "Редактировать атрибут" для добавления/удаления вариантов атрибутов или нажмите "Добавить новый вариант" для добавления варианта.',
    'save_changes' => 'Сохранить изменения',
    'continue' => 'Продолжить',
    'edit_attribute' => 'Изменить атрибут',
    'select_attribute' => 'Выберите атрибут',
    'add_new_variation' => 'Добавить новый вариант',
    'edit_variation' => 'Редактирование варианта',
    'generate_all_variations' => 'Создать все варианты',
    'generate_all_variations_confirmation' => 'Вы уверены, что хотите создать все варианты для этого продукта?',
    'delete_variation' => 'Удалить вариант?',
    'delete_variation_confirmation' => 'Вы уверены, что хотите удалить этот вариант? Это действие нельзя отменить.',
    'delete_variations_confirmation' => 'Вы уверены, что хотите удалить эти варианты? Это действие нельзя отменить.',
    'product_create_validate_name_required' => 'Пожалуйста, введите название продукта',
    'product_create_validate_sale_price_max' => 'Скидка должна быть меньше первоначальной цены',
    'product_create_validate_sale_price_required_if' => 'Необходимо ввести скидку, когда вы хотите запланировать акцию',
    'product_create_validate_end_date_after' => 'Дата окончания должна быть после даты начала',
    'product_create_validate_start_date_required_if' => 'Дата начала скидки не может быть оставлена пустой при выборе расписания.',
    'product_create_validate_sale_price' => 'Скидки нельзя оставлять пустыми, если выбрано планирование',
    'stock_statuses' => [
        'in_stock' => 'В наличии',
        'out_of_stock' => 'Нет на складе',
        'on_backorder' => 'Под заказ',
    ],
    'stock_status' => 'Состояние запасов',
    'processing' => 'Обработка...',
    'delete_selected_variations' => 'Удалить выбранные варианты',
    'delete_variations' => 'Удалить варианты',
    'category' => 'Категория',
    'product_price_flash_sale_warning' => 'Этот товар находится в срочной продаже <strong>:name</strong> поэтому его цена составляет <strong>:price</strong>.',
    'product_price_discount_warning' => 'Этот товар со скидкой <strong>:name</strong> поэтому его цена составляет <strong>:price</strong>.',
];
