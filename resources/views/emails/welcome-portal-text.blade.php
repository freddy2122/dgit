Bonjour {{ $user->first_name }},

Bienvenue sur DGT Portal.

Voici vos informations :

Identifiant (e-mail) : {{ $user->email }}
Numéro de dossier : {{ $user->dossier_number }}

Pour activer votre compte, ouvrez ce lien dans votre navigateur :
{{ $activationUrl }}

@if ($user->dni_recto_path && $user->dni_verso_path)
Nous avons bien reçu le recto et le verso de votre pièce d’identité.
@elseif ($user->dni_recto_path || $user->dni_verso_path)
Une partie de votre pièce d’identité a été téléchargée ; vous pourrez compléter l’autre côté depuis votre espace.
@else
Vous pourrez joindre le recto et le verso de votre pièce d’identité depuis votre espace personnel.
@endif

Cordialement,
DGT Portal (maquette)
