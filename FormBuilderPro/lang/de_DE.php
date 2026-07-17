<?php

$i18n = [

// ── Basics ────────────────────────────────────────────────────────────────────
    'lang_Menu_Title'                   => 'Form Builder Pro',
    'lang_Page_Title'                   => 'Form Builder Pro',
    'lang_Description'                  => 'Drag-and-Drop-Formular-Builder mit mail() und SMTP. (SQLite3 erforderlich)',

// ── General actions ───────────────────────────────────────────────────────────
    'lang_New_Form'                     => 'Neues Formular',
    'lang_Save'                         => 'Speichern',
    'lang_Edit'                         => 'Formular bearbeiten',
    'lang_Duplicate'                    => 'Vervielfältigen',
    'lang_Delete'                       => 'Löschen',
    'lang_Back'                         => 'Zurück zur Liste',
    'lang_Submissions'                  => 'Einsendungen',

// ── Forms list ────────────────────────────────────────────────────────────────
    'lang_No_Forms'                     => 'Noch keine Formulare vorhanden. Erstellen Sie Ihr erstes Formular.',
    'lang_Col_Name'                     => 'Name',
    'lang_Col_Slug'                     => 'Slug',
    'lang_Col_Fields'                   => 'Felder',
    'lang_Col_Created'                  => 'Erstellt',

// ── Builder header ────────────────────────────────────────────────────────────
    'lang_Form_Name_Placeholder'        => 'Formularname',

// ── Builder tabs ──────────────────────────────────────────────────────────────
    'lang_Tab_Fields'                   => 'Felder',
    'lang_Tab_Settings'                 => 'Einstellungen',
    'lang_Tab_Forms'                    => 'Formulare',
    'lang_Tab_Files'                    => 'Anhänge',
    'lang_Tab_Spam'                     => 'Spam',
    'lang_Tab_Embed'                    => 'Einbetten',

// ── Spam protection ───────────────────────────────────────────────────────────
    'lang_Spam_Honeypot'                => 'Honeypot-Feld aktivieren',
    'lang_Spam_Honeypot_Hint'           => 'Fügt ein verstecktes Feld hinzu, das Bots ausfüllen, Menschen jedoch nicht. Für Besucher unsichtbar.',
    'lang_Spam_Timecheck'               => 'Zeitprüfung aktivieren',
    'lang_Spam_Timecheck_Hint'          => 'Lehnt Einsendungen ab, die schneller eingehen, als ein Mensch das Formular ausfüllen könnte.',
    'lang_Spam_Min_Time'                => 'Minimale Antwortzeit:',
    'lang_Spam_Seconds'                 => 'Sekunden',
    'lang_Captcha_Method'               => 'CAPTCHA-Methode',
    'lang_Captcha_None'                 => 'Keine',

// ── Cloudflare Turnstile ──────────────────────────────────────────────────────
    'lang_Turnstile_Hint'               => 'Erhalten Sie Ihre kostenlosen Site- und Geheimschlüssel im Cloudflare-Dashboard:',
    'lang_Turnstile_Link'               => 'Cloudflare Turnstile →',
    'lang_Turnstile_Site_Key'           => 'Site-Schlüssel',
    'lang_Turnstile_Secret_Key'         => 'Geheimschlüssel',
    'lang_Turnstile_Secret_Hint'        => 'Den Geheimschlüssel niemals öffentlich teilen oder veröffentlichen.',
    'lang_Turnstile_Failed'             => 'Sicherheitsprüfung fehlgeschlagen. Bitte versuchen Sie es erneut.',

// ── hCaptcha ──────────────────────────────────────────────────────────────────
    'lang_HCaptcha_Hint'                => 'Erhalten Sie Ihre kostenlosen Site- und Geheimschlüssel im hCaptcha-Dashboard:',
    'lang_HCaptcha_Link'                => 'hCaptcha-Dashboard →',
    'lang_HCaptcha_Site_Key'            => 'Site-Schlüssel',
    'lang_HCaptcha_Secret_Key'          => 'Geheimschlüssel',
    'lang_HCaptcha_Secret_Hint'         => 'Den Geheimschlüssel niemals öffentlich teilen oder veröffentlichen.',
    'lang_HCaptcha_Failed'              => 'Sicherheitsprüfung fehlgeschlagen. Bitte versuchen Sie es erneut.',

// ── Google reCAPTCHA ──────────────────────────────────────────────────────────
    'lang_Recaptcha_Hint'               => 'Erhalten Sie Ihre Site- und Geheimschlüssel in der Google reCAPTCHA-Konsole:',
    'lang_Recaptcha_Link'               => 'Google reCAPTCHA-Konsole →',
    'lang_Recaptcha_Site_Key'           => 'Site-Schlüssel',
    'lang_Recaptcha_Secret_Key'         => 'Geheimschlüssel',
    'lang_Recaptcha_Secret_Hint'        => 'Den Geheimschlüssel niemals öffentlich teilen oder veröffentlichen.',
    'lang_Recaptcha_Failed'             => 'Sicherheitsprüfung fehlgeschlagen. Bitte versuchen Sie es erneut.',
    'lang_Recaptcha3_Threshold'         => 'Bewertungsschwelle (0,0–1,0)',
    'lang_Recaptcha3_Threshold_Hint'    => 'Einsendungen unterhalb dieses Werts werden abgelehnt. 0,5 wird empfohlen. Höher = strenger.',

// ── Field palette ─────────────────────────────────────────────────────────────
    'lang_Add_Field'                    => 'Feld hinzufügen',
    'lang_Field_Text'                   => 'Text',
    'lang_Field_Textarea'               => 'Textbereich',
    'lang_Field_Email'                  => 'E-Mail',
    'lang_Field_Tel'                    => 'Telefon',
    'lang_Field_Number'                 => 'Zahl',
    'lang_Field_Select'                 => 'Dropdown',
    'lang_Field_Radio'                  => 'Optionsfeld',
    'lang_Field_Checkbox'               => 'Kontrollkästchen',
    'lang_Field_File'                   => 'Datei',
    'lang_Field_Date'                   => 'Datum',
    'lang_Field_Time'                   => 'Uhrzeit',

// ── Canvas ────────────────────────────────────────────────────────────────────
    'lang_Canvas_Head'                  => 'Formularfläche — zum Neuordnen ziehen',
    'lang_Drop_Hint'                    => 'Feld hier ablegen oder in der Palette anklicken, um es hinzuzufügen',
    'lang_ReplyTo_Head'                 => 'Reply-To-Adresse',
    'lang_File_Options_Head'            => 'Datei-Upload-Optionen',
    'lang_File_Options_Hint'            => 'Erlaubte Dateitypen und maximale Größe pro Dateifeld konfigurieren.',

// ── Properties panel ──────────────────────────────────────────────────────────
    'lang_Properties'                   => 'Eigenschaften',
    'lang_Select_Field'                 => 'Wählen Sie ein Feld aus, um dessen Eigenschaften zu bearbeiten',
    'lang_Prop_Label'                   => 'Beschriftung',
    'lang_Prop_Name'                    => 'Feldname (HTML)',
    'lang_Prop_Placeholder'             => 'Platzhalter',
    'lang_Prop_Required'                => 'Erforderlich',
    'lang_Prop_Options'                 => 'Optionen',
    'lang_Option_N'                     => 'Option',
    'lang_Add_Option'                   => 'Option hinzufügen',

// ── Settings tab ──────────────────────────────────────────────────────────────
    'lang_Mail_Method'                  => 'Versandmethode',
    'lang_Mail_Method_PHP'              => 'PHP mail() — Serverstandard verwenden',
    'lang_Mail_Method_SMTP'             => 'SMTP — unten konfigurieren',
    'lang_Setting_EmailTo'              => 'Empfänger-E-Mail',
    'lang_Setting_EmailFrom'            => 'Absenderadresse',
    'lang_Setting_EmailFrom_Hint'       => 'Adresse, von der E-Mails gesendet werden. Muss auf dem Server autorisiert sein.',
    'lang_Setting_EmailSubject'         => 'E-Mail-Betreff',
    'lang_Setting_SubmitLabel'          => 'Beschriftung der Schaltfläche',
    'lang_Setting_SuccessMsg'           => 'Erfolgsmeldung',
    'lang_Setting_AttachFiles'          => 'Hochgeladene Dateien an E-Mail anhängen (nur SMTP)',
    'lang_Setting_AttachFiles_Hint'     => 'Erfordert SMTP. Dateien werden unabhängig davon immer als Download-Links eingefügt.',
    'lang_Files_Head'                   => 'Hochgeladene Dateien',
    'lang_Files_Loading'                => 'Wird geladen…',
    'lang_SMTP_Hint'                    => 'leer lassen, um PHP mail() zu verwenden',
    'lang_SMTP_Host'                    => 'SMTP-Host',
    'lang_SMTP_Port'                    => 'Port',
    'lang_SMTP_Enc'                     => 'Verschlüsselung',
    'lang_SMTP_User'                    => 'SMTP-Benutzername',
    'lang_SMTP_Pass'                    => 'SMTP-Passwort',
    'lang_SMTP_From'                    => 'Absenderadresse',

// ── Embed tab ─────────────────────────────────────────────────────────────────
    'lang_Embed_Shortcode'              => 'Shortcode (in Seiteninhalt einfügen)',
    'lang_Embed_Tag'                    => 'Template-Tag (in Theme-PHP einfügen)',
    'lang_Embed_SaveHint'               => 'Speichern Sie zuerst das Formular, um Einbettungscodes zu erzeugen.',

// ── JS toast / feedback strings ───────────────────────────────────────────────
    'lang_Name_Required'                => 'Bitte geben Sie einen Formularnamen ein.',
    'lang_Saved'                        => 'Formular gespeichert!',
    'lang_Save_Failed'                  => 'Speichern fehlgeschlagen. Bitte erneut versuchen.',
    'lang_Save_First'                   => 'Speichern Sie zuerst das Formular.',

// ── Test email ────────────────────────────────────────────────────────────────
    'lang_Test_Email'                   => 'Test-E-Mail senden',
    'lang_Test_Sending'                 => 'Wird gesendet…',
    'lang_Test_Ok'                      => 'Test-E-Mail erfolgreich gesendet.',
    'lang_Test_Fail'                    => 'Senden fehlgeschlagen. Bitte Einstellungen prüfen.',

];