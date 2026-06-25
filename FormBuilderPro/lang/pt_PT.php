<?php

$i18n = [

// ── Basics ────────────────────────────────────────────────────────────────────
    'lang_Menu_Title'                   => 'Form Builder Pro',
    'lang_Page_Title'                   => 'Form Builder Pro',
    'lang_Description'                  => 'Construtor de formulários com arrastar e largar, compatível com mail() e SMTP. (SQLite3 obrigatório)',

// ── General actions ───────────────────────────────────────────────────────────
    'lang_New_Form'                     => 'Novo formulário',
    'lang_Save'                         => 'Guardar',
    'lang_Edit'                         => 'Editar formulário',
    'lang_Delete'                       => 'Eliminar',
    'lang_Back'                         => 'Voltar à lista',
    'lang_Submissions'                  => 'Submissões',

// ── Forms list ────────────────────────────────────────────────────────────────
    'lang_No_Forms'                     => 'Ainda não existem formulários. Crie o seu primeiro formulário para começar.',
    'lang_Col_Name'                     => 'Nome',
    'lang_Col_Slug'                     => 'Slug',
    'lang_Col_Fields'                   => 'Campos',
    'lang_Col_Created'                  => 'Criado',

// ── Builder header ────────────────────────────────────────────────────────────
    'lang_Form_Name_Placeholder'        => 'Nome do formulário',

// ── Builder tabs ──────────────────────────────────────────────────────────────
    'lang_Tab_Fields'                   => 'Campos',
    'lang_Tab_Settings'                 => 'Configurações',
    'lang_Tab_Forms'                    => 'Formulários',
    'lang_Tab_Files'                    => 'Anexos',
    'lang_Tab_Spam'                     => 'Spam',
    'lang_Tab_Embed'                    => 'Incorporação',

// ── Spam protection ───────────────────────────────────────────────────────────
    'lang_Spam_Honeypot'                => 'Ativar campo honeypot',
    'lang_Spam_Honeypot_Hint'           => 'Adiciona um campo oculto que os bots preenchem mas os utilizadores não. Invisível para os visitantes.',
    'lang_Spam_Timecheck'               => 'Ativar verificação por tempo',
    'lang_Spam_Timecheck_Hint'          => 'Rejeita submissões que chegam mais depressa do que um humano conseguiria preencher o formulário.',
    'lang_Spam_Min_Time'                => 'Tempo mínimo de resposta:',
    'lang_Spam_Seconds'                 => 'segundos',
    'lang_Captcha_Method'               => 'Método CAPTCHA',
    'lang_Captcha_None'                 => 'Nenhum',

// ── Cloudflare Turnstile ──────────────────────────────────────────────────────
    'lang_Turnstile_Hint'               => 'Obtenha gratuitamente as chaves do site e a chave secreta no painel Cloudflare:',
    'lang_Turnstile_Link'               => 'Cloudflare Turnstile →',
    'lang_Turnstile_Site_Key'           => 'Chave do site',
    'lang_Turnstile_Secret_Key'         => 'Chave secreta',
    'lang_Turnstile_Secret_Hint'        => 'Nunca partilhe nem exponha publicamente a chave secreta.',
    'lang_Turnstile_Failed'             => 'A verificação de segurança falhou. Tente novamente.',

// ── hCaptcha ──────────────────────────────────────────────────────────────────
    'lang_HCaptcha_Hint'                => 'Obtenha gratuitamente as chaves do site e a chave secreta no painel hCaptcha:',
    'lang_HCaptcha_Link'                => 'Painel hCaptcha →',
    'lang_HCaptcha_Site_Key'            => 'Chave do site',
    'lang_HCaptcha_Secret_Key'          => 'Chave secreta',
    'lang_HCaptcha_Secret_Hint'         => 'Nunca partilhe nem exponha publicamente a chave secreta.',
    'lang_HCaptcha_Failed'              => 'A verificação de segurança falhou. Tente novamente.',

// ── Google reCAPTCHA ──────────────────────────────────────────────────────────
    'lang_Recaptcha_Hint'               => 'Obtenha as chaves do site e a chave secreta na consola Google reCAPTCHA:',
    'lang_Recaptcha_Link'               => 'Consola Google reCAPTCHA →',
    'lang_Recaptcha_Site_Key'           => 'Chave do site',
    'lang_Recaptcha_Secret_Key'         => 'Chave secreta',
    'lang_Recaptcha_Secret_Hint'        => 'Nunca partilhe nem exponha publicamente a chave secreta.',
    'lang_Recaptcha_Failed'             => 'A verificação de segurança falhou. Tente novamente.',
    'lang_Recaptcha3_Threshold'         => 'Limiar de pontuação (0.0–1.0)',
    'lang_Recaptcha3_Threshold_Hint'    => 'As submissões com pontuação inferior a este valor serão rejeitadas. Recomenda-se 0.5. Valor mais alto = mais rigoroso.',

// ── Field palette ─────────────────────────────────────────────────────────────
    'lang_Add_Field'                    => 'Adicionar campo',
    'lang_Field_Text'                   => 'Texto',
    'lang_Field_Textarea'               => 'Área de texto',
    'lang_Field_Email'                  => 'E-mail',
    'lang_Field_Tel'                    => 'Telefone',
    'lang_Field_Number'                 => 'Número',
    'lang_Field_Select'                 => 'Lista suspensa',
    'lang_Field_Radio'                  => 'Botão de opção',
    'lang_Field_Checkbox'               => 'Caixa de seleção',
    'lang_Field_File'                   => 'Ficheiro',
    'lang_Field_Date'                   => 'Data',
    'lang_Field_Time'                   => 'Hora',

// ── Canvas ────────────────────────────────────────────────────────────────────
    'lang_Canvas_Head'                  => 'Área do formulário — arraste para reorganizar',
    'lang_Drop_Hint'                    => 'Largue um campo aqui ou clique num campo da paleta para o adicionar',
    'lang_ReplyTo_Head'                 => 'Endereço Reply-To',
    'lang_File_Options_Head'            => 'Opções de carregamento de ficheiros',
    'lang_File_Options_Hint'            => 'Configure os tipos de ficheiro permitidos e o tamanho máximo por campo de ficheiro.',

// ── Properties panel ──────────────────────────────────────────────────────────
    'lang_Properties'                   => 'Propriedades',
    'lang_Select_Field'                 => 'Selecione um campo para editar as suas propriedades',
    'lang_Prop_Label'                   => 'Etiqueta',
    'lang_Prop_Name'                    => 'Nome do campo (HTML)',
    'lang_Prop_Placeholder'             => 'Texto de ajuda',
    'lang_Prop_Required'                => 'Obrigatório',
    'lang_Prop_Options'                 => 'Opções',
    'lang_Option_N'                     => 'Opção',
    'lang_Add_Option'                   => 'Adicionar opção',

// ── Settings tab ──────────────────────────────────────────────────────────────
    'lang_Mail_Method'                  => 'Método de envio',
    'lang_Mail_Method_PHP'              => 'PHP mail() — utilizar predefinição do servidor',
    'lang_Mail_Method_SMTP'             => 'SMTP — configurar abaixo',
    'lang_Setting_EmailTo'              => 'Enviar para e-mail',
    'lang_Setting_EmailFrom'            => 'Endereço do remetente',
    'lang_Setting_EmailFrom_Hint'       => 'Endereço a partir do qual os e-mails são enviados. Deve estar autorizado no servidor.',
    'lang_Setting_EmailSubject'         => 'Assunto do e-mail',
    'lang_Setting_SubmitLabel'          => 'Texto do botão de envio',
    'lang_Setting_SuccessMsg'           => 'Mensagem de sucesso',
    'lang_Setting_AttachFiles'          => 'Anexar ficheiros carregados ao e-mail (apenas SMTP)',
    'lang_Setting_AttachFiles_Hint'     => 'Requer SMTP. Os ficheiros serão sempre incluídos como ligações para download.',
    'lang_Files_Head'                   => 'Ficheiros carregados',
    'lang_Files_Loading'                => 'A carregar…',
    'lang_SMTP_Hint'                    => 'deixe em branco para utilizar PHP mail()',
    'lang_SMTP_Host'                    => 'Servidor SMTP',
    'lang_SMTP_Port'                    => 'Porta',
    'lang_SMTP_Enc'                     => 'Encriptação',
    'lang_SMTP_User'                    => 'Nome de utilizador SMTP',
    'lang_SMTP_Pass'                    => 'Palavra-passe SMTP',
    'lang_SMTP_From'                    => 'Endereço do remetente',

// ── Embed tab ─────────────────────────────────────────────────────────────────
    'lang_Embed_Shortcode'              => 'Shortcode (cole no conteúdo da página)',
    'lang_Embed_Tag'                    => 'Etiqueta do template (cole no PHP do tema)',
    'lang_Embed_SaveHint'               => 'Guarde primeiro o formulário para gerar os códigos de incorporação.',

// ── JS toast / feedback strings ───────────────────────────────────────────────
    'lang_Name_Required'                => 'Introduza um nome para o formulário.',
    'lang_Saved'                        => 'Formulário guardado!',
    'lang_Save_Failed'                  => 'Falha ao guardar. Tente novamente.',
    'lang_Save_First'                   => 'Guarde primeiro o formulário.',

// ── Test email ────────────────────────────────────────────────────────────────
    'lang_Test_Email'                   => 'Enviar e-mail de teste',
    'lang_Test_Sending'                 => 'A enviar…',
    'lang_Test_Ok'                      => 'E-mail de teste enviado com sucesso.',
    'lang_Test_Fail'                    => 'Falha no envio. Verifique as suas configurações.',

];