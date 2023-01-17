{{ header }}

<h2>"Orden recibida"!</h2>

<p>Hola {{ customer_name }},</p>
<p>Gracias por comprar nuestros productos, nos pondremos en contacto con usted por teléfono <strong>{{ customer_phone }}</strong> para confirmar el pedido!</p>

{{ product_list }}

<h3>Información al cliente</h3>

<p>{{ customer_name }} - {{ customer_phone }}, {{ customer_address }}</p>

<h3>Método de envío</h3>
<p>{{ shipping_method }}</p>

<h3>Método de pago</h3>
<p>{{ payment_method }}</p>

<br />

<p>Si tiene alguna pregunta, contáctenos a través de <a href="mailto:{{ site_admin_email }}">{{ site_admin_email }}</a></p>

{{ footer }}
