{{ header }}

<h2>"Заявка принята"!</h2>

<p>Привет {{ customer_name }},</p>
<p>Спасибо за покупку наших продуктов, мы свяжемся с вами по телефону <strong>{{ customer_phone }}</strong> Чтобы подтвердить заказ!</p>

{{ product_list }}

<h3>Информация для клиентов</h3>

<p>{{ customer_name }} - {{ customer_phone }}, {{ customer_address }}</p>

<h3>Способ доставки</h3>
<p>{{ shipping_method }}</p>

<h3>Метод оплаты</h3>
<p>{{ payment_method }}</p>

<br />

<p>Если у вас есть какие -либо вопросы, свяжитесь с нами через <a href="mailto:{{ site_admin_email }}">{{ site_admin_email }}</a></p>

{{ footer }}
