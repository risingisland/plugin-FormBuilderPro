<?php

$i18n = [

// ── Basics ────────────────────────────────────────────────────────────────────
    'lang_Menu_Title'                   => 'Form Builder Pro',
    'lang_Page_Title'                   => 'Form Builder Pro',
    'lang_Description'                  => 'Drag-n-drop form builder with mail() and SMTP. (SQLite3 required)',

// ── General actions ───────────────────────────────────────────────────────────
    'lang_New_Form'                     => 'New Form',
    'lang_Save'                         => 'Save',
    'lang_Edit'                         => 'Edit Form',
    'lang_Delete'                       => 'Delete',
    'lang_Back'                         => 'Back to list',
    'lang_Submissions'                  => 'Submissions',

// ── Forms list ────────────────────────────────────────────────────────────────
    'lang_No_Forms'                     => 'No forms yet. Create your first form to get started.',
    'lang_Col_Name'                     => 'Name',
    'lang_Col_Slug'                     => 'Slug',
    'lang_Col_Fields'                   => 'Fields',
    'lang_Col_Created'                  => 'Created',

// ── Builder header ────────────────────────────────────────────────────────────
    'lang_Form_Name_Placeholder'        => 'Form name',

// ── Builder tabs ──────────────────────────────────────────────────────────────
    'lang_Tab_Fields'                   => 'Fields',
    'lang_Tab_Settings'                 => 'Settings',
    'lang_Tab_Forms'                    => 'Forms',
    'lang_Tab_Files'                    => 'Attachments',
    'lang_Tab_Spam'                     => 'Spam',
    'lang_Tab_Embed'                    => 'Embed',

// ── Spam protection ───────────────────────────────────────────────────────────
    'lang_Spam_Honeypot'                => 'Enable honeypot field',
    'lang_Spam_Honeypot_Hint'           => 'Adds a hidden field that bots fill in but humans don\'t. Invisible to visitors.',
    'lang_Spam_Timecheck'               => 'Enable time-based check',
    'lang_Spam_Timecheck_Hint'          => 'Rejects submissions that arrive faster than a human could fill the form.',
    'lang_Spam_Min_Time'                => 'Minimum response time:',
    'lang_Spam_Seconds'                 => 'seconds',
    'lang_Captcha_Method'               => 'CAPTCHA method',
    'lang_Captcha_None'                 => 'None',

// ── Cloudflare Turnstile ──────────────────────────────────────────────────────
    'lang_Turnstile_Hint'               => 'Get your free site and secret keys from the Cloudflare dashboard:',
    'lang_Turnstile_Link'               => 'Cloudflare Turnstile →',
    'lang_Turnstile_Site_Key'           => 'Site key',
    'lang_Turnstile_Secret_Key'         => 'Secret key',
    'lang_Turnstile_Secret_Hint'        => 'Never share or expose the secret key publicly.',
    'lang_Turnstile_Failed'             => 'Security check failed. Please try again.',

// ── hCaptcha ──────────────────────────────────────────────────────────────────
    'lang_HCaptcha_Hint'                => 'Get your free site and secret keys from the hCaptcha dashboard:',
    'lang_HCaptcha_Link'                => 'hCaptcha dashboard →',
    'lang_HCaptcha_Site_Key'            => 'Site key',
    'lang_HCaptcha_Secret_Key'          => 'Secret key',
    'lang_HCaptcha_Secret_Hint'         => 'Never share or expose the secret key publicly.',
    'lang_HCaptcha_Failed'              => 'Security check failed. Please try again.',

// ── Google reCAPTCHA ──────────────────────────────────────────────────────────
    'lang_Recaptcha_Hint'               => 'Get your site and secret keys from the Google reCAPTCHA console:',
    'lang_Recaptcha_Link'               => 'Google reCAPTCHA console →',
    'lang_Recaptcha_Site_Key'           => 'Site key',
    'lang_Recaptcha_Secret_Key'         => 'Secret key',
    'lang_Recaptcha_Secret_Hint'        => 'Never share or expose the secret key publicly.',
    'lang_Recaptcha_Failed'             => 'Security check failed. Please try again.',
    'lang_Recaptcha3_Threshold'         => 'Score threshold (0.0–1.0)',
    'lang_Recaptcha3_Threshold_Hint'    => 'Submissions scoring below this are rejected. 0.5 is recommended. Higher = stricter.',

// ── Field palette ─────────────────────────────────────────────────────────────
    'lang_Add_Field'                    => 'Add field',
    'lang_Field_Text'                   => 'Text',
    'lang_Field_Textarea'               => 'Textarea',
    'lang_Field_Email'                  => 'Email',
    'lang_Field_Tel'                    => 'Phone',
    'lang_Field_Number'                 => 'Number',
    'lang_Field_Select'                 => 'Dropdown',
    'lang_Field_Radio'                  => 'Radio',
    'lang_Field_Checkbox'               => 'Checkbox',
    'lang_Field_File'                   => 'File',
    'lang_Field_Date'                   => 'Date',
    'lang_Field_Time'                   => 'Time',

// ── Canvas ────────────────────────────────────────────────────────────────────
    'lang_Canvas_Head'                  => 'Form canvas — drag to reorder',
    'lang_Drop_Hint'                    => 'Drop a field here, or click one in the palette to add it',
    'lang_ReplyTo_Head'                 => 'Reply-To address',
    'lang_File_Options_Head'            => 'File upload options',
    'lang_File_Options_Hint'            => 'Configure allowed file types and maximum size per file field.',

// ── Properties panel ──────────────────────────────────────────────────────────
    'lang_Properties'                   => 'Properties',
    'lang_Select_Field'                 => 'Select a field to edit its properties',
    'lang_Prop_Label'                   => 'Label',
    'lang_Prop_Name'                    => 'Field name (HTML)',
    'lang_Prop_Placeholder'             => 'Placeholder',
    'lang_Prop_Required'                => 'Required',
    'lang_Prop_Options'                 => 'Options',
    'lang_Option_N'                     => 'Option',
    'lang_Add_Option'                   => 'Add option',

// ── Settings tab ──────────────────────────────────────────────────────────────
    'lang_Mail_Method'                  => 'Mail method',
    'lang_Mail_Method_PHP'              => 'PHP mail() — use server default',
    'lang_Mail_Method_SMTP'             => 'SMTP — configure below',
    'lang_Setting_EmailTo'              => 'Send to email',
    'lang_Setting_EmailFrom'            => 'From address',
    'lang_Setting_EmailFrom_Hint'       => 'Address emails are sent from. Must be authorised to send from your server.',
    'lang_Setting_EmailSubject'         => 'Email subject',
    'lang_Setting_SubmitLabel'          => 'Submit button label',
    'lang_Setting_SuccessMsg'           => 'Success message',
    'lang_Setting_AttachFiles'          => 'Attach uploaded files to email (SMTP only)',
    'lang_Setting_AttachFiles_Hint'     => 'Requires SMTP mail method. Files are always included as download links regardless.',
    'lang_Files_Head'                   => 'Uploaded files',
    'lang_Files_Loading'                => 'Loading…',
    'lang_SMTP_Hint'                    => 'leave blank to use PHP mail()',
    'lang_SMTP_Host'                    => 'SMTP host',
    'lang_SMTP_Port'                    => 'Port',
    'lang_SMTP_Enc'                     => 'Encryption',
    'lang_SMTP_User'                    => 'SMTP username',
    'lang_SMTP_Pass'                    => 'SMTP password',
    'lang_SMTP_From'                    => 'From address',

// ── Embed tab ─────────────────────────────────────────────────────────────────
    'lang_Embed_Shortcode'              => 'Shortcode (paste in page content)',
    'lang_Embed_Tag'                    => 'Template tag (paste in theme PHP)',
    'lang_Embed_SaveHint'               => 'Save the form first to generate embed codes.',

// ── JS toast / feedback strings ───────────────────────────────────────────────
    'lang_Name_Required'                => 'Please enter a form name.',
    'lang_Saved'                        => 'Form saved!',
    'lang_Save_Failed'                  => 'Save failed. Please try again.',
    'lang_Save_First'                   => 'Save the form first.',

// ── Test email ────────────────────────────────────────────────────────────────
    'lang_Test_Email'                   => 'Send test email',
    'lang_Test_Sending'                 => 'Sending…',
    'lang_Test_Ok'                      => 'Test email sent successfully.',
    'lang_Test_Fail'                    => 'Failed to send. Check your settings.',

];