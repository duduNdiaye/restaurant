<x-mail::message>
# Confirmation de commande

Merci {{$nomClient }}
Votre commande a bien ete cree
Et est en cours de preparation et sera prete
{{ $date }} a {{ $heure }}

Votre numero de commande est :
{{ $numeroCommande }}


Cordialement,<br>
ClickMiam
</x-mail::message>
