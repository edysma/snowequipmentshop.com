{{ header }}

<h2>"Bestellung erhalten"!</h2>

<p>Hi {{ customer_name }},</p>
<p>Vielen Dank, dass Sie unsere Produkte gekauft haben. Wir werden Sie telefonisch kontaktieren <strong>{{ customer_phone }}</strong> Bestellung bestätigen!</p>

{{ product_list }}

<h3>Kundeninformation</h3>

<p>{{ customer_name }} - {{ customer_phone }}, {{ customer_address }}</p>

<h3>Versandmethode</h3>
<p>{{ shipping_method }}</p>

<h3>Zahlungsmethode</h3>
<p>{{ payment_method }}</p>

<br />

<p>Wenn Sie Fragen haben, kontaktieren Sie uns bitte über uns über <a href="mailto:{{ site_admin_email }}">{{ site_admin_email }}</a></p>

{{ footer }}
