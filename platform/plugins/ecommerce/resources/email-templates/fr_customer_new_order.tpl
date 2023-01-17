{{ header }}

<h2>"Ordre reçu"!</h2>

<p>Salut {{ customer_name }},</p>
<p>Merci d'avoir acheté nos produits, nous vous contacterons par téléphone <strong>{{ customer_phone }}</strong> pour confirmer la commande!</p>

{{ product_list }}

<h3>Informations client</h3>

<p>{{ customer_name }} - {{ customer_phone }}, {{ customer_address }}</p>

<h3>Mode de livraison</h3>
<p>{{ shipping_method }}</p>

<h3>Mode de paiement</h3>
<p>{{ payment_method }}</p>

<br />

<p>Si vous avez une question, veuillez nous contacter via <a href="mailto:{{ site_admin_email }}">{{ site_admin_email }}</a></p>

{{ footer }}
