{{ header }}

<h2>Ordine ricevuto!</h2>

<p>Salve {{ customer_name }},</p>
<p>grazie per aver acquistato i nostri prodotti, ti contatteremo per confermare l'ordine!</p>

{{ product_list }}

<h3>Informazioni Cliente</h3>

<p>{{ customer_name }} - {{ customer_phone }}, {{ customer_address }}</p>

<h3>Metodo di spedizione</h3>
<p>{{ shipping_method }}</p>

<h3>Metodo di pagamento</h3>
<p>{{ payment_method }}</p>

<br />

<p>Se hai qualche domanda, ti preghiamo di contattarci tramite <a href="mailto:{{ site_admin_email }}">{{ site_admin_email }}</a></p>

{{ footer }}
