<?php

$i18n = [

// ── Basics ────────────────────────────────────────────────────────────────────
    'lang_Menu_Title'                   => 'Form Builder Pro',
    'lang_Page_Title'                   => 'Form Builder Pro',
    'lang_Description'                  => 'Constructor de formularios con arrastrar y soltar, compatible con mail() y SMTP. (Requiere SQLite3)',

// ── General actions ───────────────────────────────────────────────────────────
    'lang_New_Form'                     => 'Nuevo formulario',
    'lang_Save'                         => 'Guardar',
    'lang_Edit'                         => 'Editar formulario',
    'lang_Delete'                       => 'Eliminar',
    'lang_Back'                         => 'Volver a la lista',
    'lang_Submissions'                  => 'Envíos',

// ── Forms list ────────────────────────────────────────────────────────────────
    'lang_No_Forms'                     => 'Aún no hay formularios. Cree su primer formulario para comenzar.',
    'lang_Col_Name'                     => 'Nombre',
    'lang_Col_Slug'                     => 'Slug',
    'lang_Col_Fields'                   => 'Campos',
    'lang_Col_Created'                  => 'Creado',

// ── Builder header ────────────────────────────────────────────────────────────
    'lang_Form_Name_Placeholder'        => 'Nombre del formulario',

// ── Builder tabs ──────────────────────────────────────────────────────────────
    'lang_Tab_Fields'                   => 'Campos',
    'lang_Tab_Settings'                 => 'Configuración',
    'lang_Tab_Forms'                    => 'Formularios',
    'lang_Tab_Files'                    => 'Archivos adjuntos',
    'lang_Tab_Spam'                     => 'Spam',
    'lang_Tab_Embed'                    => 'Insertar',

// ── Spam protection ───────────────────────────────────────────────────────────
    'lang_Spam_Honeypot'                => 'Activar campo honeypot',
    'lang_Spam_Honeypot_Hint'           => 'Añade un campo oculto que los bots rellenan pero los humanos no. Invisible para los visitantes.',
    'lang_Spam_Timecheck'               => 'Activar comprobación por tiempo',
    'lang_Spam_Timecheck_Hint'          => 'Rechaza envíos que llegan más rápido de lo que una persona podría completar el formulario.',
    'lang_Spam_Min_Time'                => 'Tiempo mínimo de respuesta:',
    'lang_Spam_Seconds'                 => 'segundos',
    'lang_Captcha_Method'               => 'Método CAPTCHA',
    'lang_Captcha_None'                 => 'Ninguno',

// ── Cloudflare Turnstile ──────────────────────────────────────────────────────
    'lang_Turnstile_Hint'               => 'Obtenga gratuitamente las claves del sitio y secretas desde el panel de Cloudflare:',
    'lang_Turnstile_Link'               => 'Cloudflare Turnstile →',
    'lang_Turnstile_Site_Key'           => 'Clave del sitio',
    'lang_Turnstile_Secret_Key'         => 'Clave secreta',
    'lang_Turnstile_Secret_Hint'        => 'Nunca comparta ni exponga públicamente la clave secreta.',
    'lang_Turnstile_Failed'             => 'La comprobación de seguridad ha fallado. Inténtelo de nuevo.',

// ── hCaptcha ──────────────────────────────────────────────────────────────────
    'lang_HCaptcha_Hint'                => 'Obtenga gratuitamente las claves del sitio y secretas desde el panel de hCaptcha:',
    'lang_HCaptcha_Link'                => 'Panel de hCaptcha →',
    'lang_HCaptcha_Site_Key'            => 'Clave del sitio',
    'lang_HCaptcha_Secret_Key'          => 'Clave secreta',
    'lang_HCaptcha_Secret_Hint'         => 'Nunca comparta ni exponga públicamente la clave secreta.',
    'lang_HCaptcha_Failed'              => 'La comprobación de seguridad ha fallado. Inténtelo de nuevo.',

// ── Google reCAPTCHA ──────────────────────────────────────────────────────────
    'lang_Recaptcha_Hint'               => 'Obtenga las claves del sitio y secretas desde la consola de Google reCAPTCHA:',
    'lang_Recaptcha_Link'               => 'Consola Google reCAPTCHA →',
    'lang_Recaptcha_Site_Key'           => 'Clave del sitio',
    'lang_Recaptcha_Secret_Key'         => 'Clave secreta',
    'lang_Recaptcha_Secret_Hint'        => 'Nunca comparta ni exponga públicamente la clave secreta.',
    'lang_Recaptcha_Failed'             => 'La comprobación de seguridad ha fallado. Inténtelo de nuevo.',
    'lang_Recaptcha3_Threshold'         => 'Umbral de puntuación (0.0–1.0)',
    'lang_Recaptcha3_Threshold_Hint'    => 'Los envíos con una puntuación inferior serán rechazados. Se recomienda 0.5. Más alto = más estricto.',

// ── Field palette ─────────────────────────────────────────────────────────────
    'lang_Add_Field'                    => 'Añadir campo',
    'lang_Field_Text'                   => 'Texto',
    'lang_Field_Textarea'               => 'Área de texto',
    'lang_Field_Email'                  => 'Correo electrónico',
    'lang_Field_Tel'                    => 'Teléfono',
    'lang_Field_Number'                 => 'Número',
    'lang_Field_Select'                 => 'Lista desplegable',
    'lang_Field_Radio'                  => 'Botón de opción',
    'lang_Field_Checkbox'               => 'Casilla de verificación',
    'lang_Field_File'                   => 'Archivo',
    'lang_Field_Date'                   => 'Fecha',
    'lang_Field_Time'                   => 'Hora',

// ── Canvas ────────────────────────────────────────────────────────────────────
    'lang_Canvas_Head'                  => 'Lienzo del formulario — arrastre para reordenar',
    'lang_Drop_Hint'                    => 'Suelte un campo aquí o haga clic en uno de la paleta para añadirlo',
    'lang_ReplyTo_Head'                 => 'Dirección Reply-To',
    'lang_File_Options_Head'            => 'Opciones de carga de archivos',
    'lang_File_Options_Hint'            => 'Configure los tipos de archivo permitidos y el tamaño máximo por campo.',

// ── Properties panel ──────────────────────────────────────────────────────────
    'lang_Properties'                   => 'Propiedades',
    'lang_Select_Field'                 => 'Seleccione un campo para editar sus propiedades',
    'lang_Prop_Label'                   => 'Etiqueta',
    'lang_Prop_Name'                    => 'Nombre del campo (HTML)',
    'lang_Prop_Placeholder'             => 'Marcador de posición',
    'lang_Prop_Required'                => 'Obligatorio',
    'lang_Prop_Options'                 => 'Opciones',
    'lang_Option_N'                     => 'Opción',
    'lang_Add_Option'                   => 'Añadir opción',

// ── Settings tab ──────────────────────────────────────────────────────────────
    'lang_Mail_Method'                  => 'Método de correo',
    'lang_Mail_Method_PHP'              => 'PHP mail() — usar configuración predeterminada del servidor',
    'lang_Mail_Method_SMTP'             => 'SMTP — configurar a continuación',
    'lang_Setting_EmailTo'              => 'Enviar al correo',
    'lang_Setting_EmailFrom'            => 'Dirección remitente',
    'lang_Setting_EmailFrom_Hint'       => 'Dirección desde la que se envían los correos. Debe estar autorizada en el servidor.',
    'lang_Setting_EmailSubject'         => 'Asunto del correo',
    'lang_Setting_SubmitLabel'          => 'Texto del botón de envío',
    'lang_Setting_SuccessMsg'           => 'Mensaje de éxito',
    'lang_Setting_AttachFiles'          => 'Adjuntar archivos subidos al correo (solo SMTP)',
    'lang_Setting_AttachFiles_Hint'     => 'Requiere SMTP. Los archivos siempre se incluirán como enlaces de descarga.',
    'lang_Files_Head'                   => 'Archivos subidos',
    'lang_Files_Loading'                => 'Cargando…',
    'lang_SMTP_Hint'                    => 'déjelo en blanco para usar PHP mail()',
    'lang_SMTP_Host'                    => 'Servidor SMTP',
    'lang_SMTP_Port'                    => 'Puerto',
    'lang_SMTP_Enc'                     => 'Cifrado',
    'lang_SMTP_User'                    => 'Usuario SMTP',
    'lang_SMTP_Pass'                    => 'Contraseña SMTP',
    'lang_SMTP_From'                    => 'Dirección remitente',

// ── Embed tab ─────────────────────────────────────────────────────────────────
    'lang_Embed_Shortcode'              => 'Shortcode (pegar en el contenido de la página)',
    'lang_Embed_Tag'                    => 'Etiqueta de plantilla (pegar en el PHP del tema)',
    'lang_Embed_SaveHint'               => 'Guarde primero el formulario para generar los códigos de inserción.',

// ── JS toast / feedback strings ───────────────────────────────────────────────
    'lang_Name_Required'                => 'Por favor, introduzca un nombre para el formulario.',
    'lang_Saved'                        => '¡Formulario guardado!',
    'lang_Save_Failed'                  => 'Error al guardar. Inténtelo de nuevo.',
    'lang_Save_First'                   => 'Guarde primero el formulario.',

// ── Test email ────────────────────────────────────────────────────────────────
    'lang_Test_Email'                   => 'Enviar correo de prueba',
    'lang_Test_Sending'                 => 'Enviando…',
    'lang_Test_Ok'                      => 'Correo de prueba enviado correctamente.',
    'lang_Test_Fail'                    => 'Error al enviar. Revise la configuración.',

];