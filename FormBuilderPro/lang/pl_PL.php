<?php

$i18n = [

// ── Basics ────────────────────────────────────────────────────────────────────
    'lang_Menu_Title'                   => 'Form Builder Pro',
    'lang_Page_Title'                   => 'Form Builder Pro',
    'lang_Description'                  => 'Kreator formularzy metodą przeciągnij i upuść z obsługą mail() i SMTP. (Wymagane SQLite3)',

// ── General actions ───────────────────────────────────────────────────────────
    'lang_New_Form'                     => 'Nowy formularz',
    'lang_Save'                         => 'Zapisz',
    'lang_Edit'                         => 'Edytuj formularz',
    'lang_Delete'                       => 'Usuń',
    'lang_Back'                         => 'Powrót do listy',
    'lang_Submissions'                  => 'Zgłoszenia',

// ── Forms list ────────────────────────────────────────────────────────────────
    'lang_No_Forms'                     => 'Brak formularzy. Utwórz swój pierwszy formularz, aby rozpocząć.',
    'lang_Col_Name'                     => 'Nazwa',
    'lang_Col_Slug'                     => 'Slug',
    'lang_Col_Fields'                   => 'Pola',
    'lang_Col_Created'                  => 'Utworzono',

// ── Builder header ────────────────────────────────────────────────────────────
    'lang_Form_Name_Placeholder'        => 'Nazwa formularza',

// ── Builder tabs ──────────────────────────────────────────────────────────────
    'lang_Tab_Fields'                   => 'Pola',
    'lang_Tab_Settings'                 => 'Ustawienia',
    'lang_Tab_Forms'                    => 'Formularze',
    'lang_Tab_Files'                    => 'Załączniki',
    'lang_Tab_Spam'                     => 'Spam',
    'lang_Tab_Embed'                    => 'Osadzanie',

// ── Spam protection ───────────────────────────────────────────────────────────
    'lang_Spam_Honeypot'                => 'Włącz pole honeypot',
    'lang_Spam_Honeypot_Hint'           => 'Dodaje ukryte pole, które wypełniają boty, ale nie ludzie. Niewidoczne dla odwiedzających.',
    'lang_Spam_Timecheck'               => 'Włącz kontrolę czasu',
    'lang_Spam_Timecheck_Hint'          => 'Odrzuca zgłoszenia przesłane szybciej, niż człowiek mógłby wypełnić formularz.',
    'lang_Spam_Min_Time'                => 'Minimalny czas odpowiedzi:',
    'lang_Spam_Seconds'                 => 'sekund',
    'lang_Captcha_Method'               => 'Metoda CAPTCHA',
    'lang_Captcha_None'                 => 'Brak',

// ── Cloudflare Turnstile ──────────────────────────────────────────────────────
    'lang_Turnstile_Hint'               => 'Pobierz bezpłatne klucze witryny i tajne klucze z panelu Cloudflare:',
    'lang_Turnstile_Link'               => 'Cloudflare Turnstile →',
    'lang_Turnstile_Site_Key'           => 'Klucz witryny',
    'lang_Turnstile_Secret_Key'         => 'Klucz tajny',
    'lang_Turnstile_Secret_Hint'        => 'Nigdy nie udostępniaj ani nie publikuj klucza tajnego.',
    'lang_Turnstile_Failed'             => 'Weryfikacja bezpieczeństwa nie powiodła się. Spróbuj ponownie.',

// ── hCaptcha ──────────────────────────────────────────────────────────────────
    'lang_HCaptcha_Hint'                => 'Pobierz bezpłatne klucze witryny i tajne klucze z panelu hCaptcha:',
    'lang_HCaptcha_Link'                => 'Panel hCaptcha →',
    'lang_HCaptcha_Site_Key'            => 'Klucz witryny',
    'lang_HCaptcha_Secret_Key'          => 'Klucz tajny',
    'lang_HCaptcha_Secret_Hint'         => 'Nigdy nie udostępniaj ani nie publikuj klucza tajnego.',
    'lang_HCaptcha_Failed'              => 'Weryfikacja bezpieczeństwa nie powiodła się. Spróbuj ponownie.',

// ── Google reCAPTCHA ──────────────────────────────────────────────────────────
    'lang_Recaptcha_Hint'               => 'Pobierz klucze witryny i tajne klucze z konsoli Google reCAPTCHA:',
    'lang_Recaptcha_Link'               => 'Konsola Google reCAPTCHA →',
    'lang_Recaptcha_Site_Key'           => 'Klucz witryny',
    'lang_Recaptcha_Secret_Key'         => 'Klucz tajny',
    'lang_Recaptcha_Secret_Hint'        => 'Nigdy nie udostępniaj ani nie publikuj klucza tajnego.',
    'lang_Recaptcha_Failed'             => 'Weryfikacja bezpieczeństwa nie powiodła się. Spróbuj ponownie.',
    'lang_Recaptcha3_Threshold'         => 'Próg wyniku (0.0–1.0)',
    'lang_Recaptcha3_Threshold_Hint'    => 'Zgłoszenia z wynikiem poniżej tej wartości zostaną odrzucone. Zalecane jest 0.5. Wyższa wartość = bardziej rygorystyczne sprawdzanie.',

// ── Field palette ─────────────────────────────────────────────────────────────
    'lang_Add_Field'                    => 'Dodaj pole',
    'lang_Field_Text'                   => 'Tekst',
    'lang_Field_Textarea'               => 'Pole tekstowe',
    'lang_Field_Email'                  => 'E-mail',
    'lang_Field_Tel'                    => 'Telefon',
    'lang_Field_Number'                 => 'Liczba',
    'lang_Field_Select'                 => 'Lista rozwijana',
    'lang_Field_Radio'                  => 'Przycisk opcji',
    'lang_Field_Checkbox'               => 'Pole wyboru',
    'lang_Field_File'                   => 'Plik',
    'lang_Field_Date'                   => 'Data',
    'lang_Field_Time'                   => 'Godzina',

// ── Canvas ────────────────────────────────────────────────────────────────────
    'lang_Canvas_Head'                  => 'Obszar formularza — przeciągnij, aby zmienić kolejność',
    'lang_Drop_Hint'                    => 'Upuść tutaj pole lub kliknij je w palecie, aby dodać',
    'lang_ReplyTo_Head'                 => 'Adres Reply-To',
    'lang_File_Options_Head'            => 'Opcje przesyłania plików',
    'lang_File_Options_Hint'            => 'Skonfiguruj dozwolone typy plików i maksymalny rozmiar dla każdego pola pliku.',

// ── Properties panel ──────────────────────────────────────────────────────────
    'lang_Properties'                   => 'Właściwości',
    'lang_Select_Field'                 => 'Wybierz pole, aby edytować jego właściwości',
    'lang_Prop_Label'                   => 'Etykieta',
    'lang_Prop_Name'                    => 'Nazwa pola (HTML)',
    'lang_Prop_Placeholder'             => 'Tekst zastępczy',
    'lang_Prop_Required'                => 'Wymagane',
    'lang_Prop_Options'                 => 'Opcje',
    'lang_Option_N'                     => 'Opcja',
    'lang_Add_Option'                   => 'Dodaj opcję',

// ── Settings tab ──────────────────────────────────────────────────────────────
    'lang_Mail_Method'                  => 'Metoda wysyłki poczty',
    'lang_Mail_Method_PHP'              => 'PHP mail() — użyj ustawień domyślnych serwera',
    'lang_Mail_Method_SMTP'             => 'SMTP — skonfiguruj poniżej',
    'lang_Setting_EmailTo'              => 'Wyślij na adres',
    'lang_Setting_EmailFrom'            => 'Adres nadawcy',
    'lang_Setting_EmailFrom_Hint'       => 'Adres, z którego wysyłane są wiadomości. Musi być autoryzowany na serwerze.',
    'lang_Setting_EmailSubject'         => 'Temat wiadomości',
    'lang_Setting_SubmitLabel'          => 'Etykieta przycisku wysyłania',
    'lang_Setting_SuccessMsg'           => 'Komunikat sukcesu',
    'lang_Setting_AttachFiles'          => 'Dołącz przesłane pliki do wiadomości (tylko SMTP)',
    'lang_Setting_AttachFiles_Hint'     => 'Wymaga SMTP. Pliki będą zawsze dołączane jako linki do pobrania.',
    'lang_Files_Head'                   => 'Przesłane pliki',
    'lang_Files_Loading'                => 'Ładowanie…',
    'lang_SMTP_Hint'                    => 'pozostaw puste, aby użyć PHP mail()',
    'lang_SMTP_Host'                    => 'Host SMTP',
    'lang_SMTP_Port'                    => 'Port',
    'lang_SMTP_Enc'                     => 'Szyfrowanie',
    'lang_SMTP_User'                    => 'Nazwa użytkownika SMTP',
    'lang_SMTP_Pass'                    => 'Hasło SMTP',
    'lang_SMTP_From'                    => 'Adres nadawcy',

// ── Embed tab ─────────────────────────────────────────────────────────────────
    'lang_Embed_Shortcode'              => 'Shortcode (wklej do treści strony)',
    'lang_Embed_Tag'                    => 'Znacznik szablonu (wklej do PHP motywu)',
    'lang_Embed_SaveHint'               => 'Najpierw zapisz formularz, aby wygenerować kody osadzania.',

// ── JS toast / feedback strings ───────────────────────────────────────────────
    'lang_Name_Required'                => 'Proszę podać nazwę formularza.',
    'lang_Saved'                        => 'Formularz zapisany!',
    'lang_Save_Failed'                  => 'Nie udało się zapisać. Spróbuj ponownie.',
    'lang_Save_First'                   => 'Najpierw zapisz formularz.',

// ── Test email ────────────────────────────────────────────────────────────────
    'lang_Test_Email'                   => 'Wyślij wiadomość testową',
    'lang_Test_Sending'                 => 'Wysyłanie…',
    'lang_Test_Ok'                      => 'Wiadomość testowa została wysłana pomyślnie.',
    'lang_Test_Fail'                    => 'Nie udało się wysłać. Sprawdź ustawienia.',

];