<?php

$i18n = [

// ── Basics ────────────────────────────────────────────────────────────────────
    'lang_Menu_Title'                   => 'Form Builder Pro',
    'lang_Page_Title'                   => 'Form Builder Pro',
    'lang_Description'                  => 'Créateur de formulaires par glisser-déposer avec prise en charge de mail() et SMTP. (SQLite3 requis)',

// ── General actions ───────────────────────────────────────────────────────────
    'lang_New_Form'                     => 'Nouveau formulaire',
    'lang_Save'                         => 'Enregistrer',
    'lang_Edit'                         => 'Modifier le formulaire',
    'lang_Delete'                       => 'Supprimer',
    'lang_Back'                         => 'Retour à la liste',
    'lang_Submissions'                  => 'Soumissions',

// ── Forms list ────────────────────────────────────────────────────────────────
    'lang_No_Forms'                     => 'Aucun formulaire pour le moment. Créez votre premier formulaire pour commencer.',
    'lang_Col_Name'                     => 'Nom',
    'lang_Col_Slug'                     => 'Slug',
    'lang_Col_Fields'                   => 'Champs',
    'lang_Col_Created'                  => 'Créé',

// ── Builder header ────────────────────────────────────────────────────────────
    'lang_Form_Name_Placeholder'        => 'Nom du formulaire',

// ── Builder tabs ──────────────────────────────────────────────────────────────
    'lang_Tab_Fields'                   => 'Champs',
    'lang_Tab_Settings'                 => 'Paramètres',
    'lang_Tab_Forms'                    => 'Formulaires',
    'lang_Tab_Files'                    => 'Pièces jointes',
    'lang_Tab_Spam'                     => 'Spam',
    'lang_Tab_Embed'                    => 'Intégration',

// ── Spam protection ───────────────────────────────────────────────────────────
    'lang_Spam_Honeypot'                => 'Activer le champ honeypot',
    'lang_Spam_Honeypot_Hint'           => 'Ajoute un champ caché que les robots remplissent mais pas les humains. Invisible pour les visiteurs.',
    'lang_Spam_Timecheck'               => 'Activer la vérification temporelle',
    'lang_Spam_Timecheck_Hint'          => 'Rejette les soumissions arrivant plus rapidement qu’un humain ne pourrait remplir le formulaire.',
    'lang_Spam_Min_Time'                => 'Temps de réponse minimum :',
    'lang_Spam_Seconds'                 => 'secondes',
    'lang_Captcha_Method'               => 'Méthode CAPTCHA',
    'lang_Captcha_None'                 => 'Aucune',

// ── Cloudflare Turnstile ──────────────────────────────────────────────────────
    'lang_Turnstile_Hint'               => 'Obtenez gratuitement vos clés de site et clés secrètes depuis le tableau de bord Cloudflare :',
    'lang_Turnstile_Link'               => 'Cloudflare Turnstile →',
    'lang_Turnstile_Site_Key'           => 'Clé du site',
    'lang_Turnstile_Secret_Key'         => 'Clé secrète',
    'lang_Turnstile_Secret_Hint'        => 'Ne partagez jamais et n’exposez jamais publiquement la clé secrète.',
    'lang_Turnstile_Failed'             => 'La vérification de sécurité a échoué. Veuillez réessayer.',

// ── hCaptcha ──────────────────────────────────────────────────────────────────
    'lang_HCaptcha_Hint'                => 'Obtenez gratuitement vos clés de site et clés secrètes depuis le tableau de bord hCaptcha :',
    'lang_HCaptcha_Link'                => 'Tableau de bord hCaptcha →',
    'lang_HCaptcha_Site_Key'            => 'Clé du site',
    'lang_HCaptcha_Secret_Key'          => 'Clé secrète',
    'lang_HCaptcha_Secret_Hint'         => 'Ne partagez jamais et n’exposez jamais publiquement la clé secrète.',
    'lang_HCaptcha_Failed'              => 'La vérification de sécurité a échoué. Veuillez réessayer.',

// ── Google reCAPTCHA ──────────────────────────────────────────────────────────
    'lang_Recaptcha_Hint'               => 'Obtenez vos clés de site et clés secrètes depuis la console Google reCAPTCHA :',
    'lang_Recaptcha_Link'               => 'Console Google reCAPTCHA →',
    'lang_Recaptcha_Site_Key'           => 'Clé du site',
    'lang_Recaptcha_Secret_Key'         => 'Clé secrète',
    'lang_Recaptcha_Secret_Hint'        => 'Ne partagez jamais et n’exposez jamais publiquement la clé secrète.',
    'lang_Recaptcha_Failed'             => 'La vérification de sécurité a échoué. Veuillez réessayer.',
    'lang_Recaptcha3_Threshold'         => 'Seuil de score (0.0–1.0)',
    'lang_Recaptcha3_Threshold_Hint'    => 'Les soumissions dont le score est inférieur à cette valeur seront rejetées. 0.5 est recommandé. Plus la valeur est élevée, plus le contrôle est strict.',

// ── Field palette ─────────────────────────────────────────────────────────────
    'lang_Add_Field'                    => 'Ajouter un champ',
    'lang_Field_Text'                   => 'Texte',
    'lang_Field_Textarea'               => 'Zone de texte',
    'lang_Field_Email'                  => 'E-mail',
    'lang_Field_Tel'                    => 'Téléphone',
    'lang_Field_Number'                 => 'Nombre',
    'lang_Field_Select'                 => 'Liste déroulante',
    'lang_Field_Radio'                  => 'Bouton radio',
    'lang_Field_Checkbox'               => 'Case à cocher',
    'lang_Field_File'                   => 'Fichier',
    'lang_Field_Date'                   => 'Date',
    'lang_Field_Time'                   => 'Heure',

// ── Canvas ────────────────────────────────────────────────────────────────────
    'lang_Canvas_Head'                  => 'Zone du formulaire — glissez pour réorganiser',
    'lang_Drop_Hint'                    => 'Déposez un champ ici ou cliquez sur un champ dans la palette pour l’ajouter',
    'lang_ReplyTo_Head'                 => 'Adresse Reply-To',
    'lang_File_Options_Head'            => 'Options d’envoi de fichiers',
    'lang_File_Options_Hint'            => 'Configurez les types de fichiers autorisés et la taille maximale pour chaque champ fichier.',

// ── Properties panel ──────────────────────────────────────────────────────────
    'lang_Properties'                   => 'Propriétés',
    'lang_Select_Field'                 => 'Sélectionnez un champ pour modifier ses propriétés',
    'lang_Prop_Label'                   => 'Libellé',
    'lang_Prop_Name'                    => 'Nom du champ (HTML)',
    'lang_Prop_Placeholder'             => 'Texte indicatif',
    'lang_Prop_Required'                => 'Obligatoire',
    'lang_Prop_Options'                 => 'Options',
    'lang_Option_N'                     => 'Option',
    'lang_Add_Option'                   => 'Ajouter une option',

// ── Settings tab ──────────────────────────────────────────────────────────────
    'lang_Mail_Method'                  => 'Méthode d’envoi',
    'lang_Mail_Method_PHP'              => 'PHP mail() — utiliser les paramètres par défaut du serveur',
    'lang_Mail_Method_SMTP'             => 'SMTP — configurer ci-dessous',
    'lang_Setting_EmailTo'              => 'Envoyer à l’adresse e-mail',
    'lang_Setting_EmailFrom'            => 'Adresse d’expéditeur',
    'lang_Setting_EmailFrom_Hint'       => 'Adresse utilisée pour envoyer les e-mails. Elle doit être autorisée sur votre serveur.',
    'lang_Setting_EmailSubject'         => 'Objet de l’e-mail',
    'lang_Setting_SubmitLabel'          => 'Libellé du bouton d’envoi',
    'lang_Setting_SuccessMsg'           => 'Message de succès',
    'lang_Setting_AttachFiles'          => 'Joindre les fichiers téléchargés à l’e-mail (SMTP uniquement)',
    'lang_Setting_AttachFiles_Hint'     => 'Nécessite SMTP. Les fichiers seront toujours inclus sous forme de liens de téléchargement.',
    'lang_Files_Head'                   => 'Fichiers téléchargés',
    'lang_Files_Loading'                => 'Chargement…',
    'lang_SMTP_Hint'                    => 'laisser vide pour utiliser PHP mail()',
    'lang_SMTP_Host'                    => 'Hôte SMTP',
    'lang_SMTP_Port'                    => 'Port',
    'lang_SMTP_Enc'                     => 'Chiffrement',
    'lang_SMTP_User'                    => 'Nom d’utilisateur SMTP',
    'lang_SMTP_Pass'                    => 'Mot de passe SMTP',
    'lang_SMTP_From'                    => 'Adresse d’expéditeur',

// ── Embed tab ─────────────────────────────────────────────────────────────────
    'lang_Embed_Shortcode'              => 'Shortcode (à coller dans le contenu de la page)',
    'lang_Embed_Tag'                    => 'Balise de modèle (à coller dans le PHP du thème)',
    'lang_Embed_SaveHint'               => 'Enregistrez d’abord le formulaire pour générer les codes d’intégration.',

// ── JS toast / feedback strings ───────────────────────────────────────────────
    'lang_Name_Required'                => 'Veuillez saisir un nom de formulaire.',
    'lang_Saved'                        => 'Formulaire enregistré !',
    'lang_Save_Failed'                  => 'Échec de l’enregistrement. Veuillez réessayer.',
    'lang_Save_First'                   => 'Enregistrez d’abord le formulaire.',

// ── Test email ────────────────────────────────────────────────────────────────
    'lang_Test_Email'                   => 'Envoyer un e-mail de test',
    'lang_Test_Sending'                 => 'Envoi en cours…',
    'lang_Test_Ok'                      => 'E-mail de test envoyé avec succès.',
    'lang_Test_Fail'                    => 'Échec de l’envoi. Vérifiez vos paramètres.',

];