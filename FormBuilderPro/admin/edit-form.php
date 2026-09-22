<?php if (!defined('IN_GS')) { die('You cannot load this page directly.'); }

/**
 * Form Builder Pro — Admin: Edit / New Form
 * Included by FormBuilderPro_admin_page() when fb_view is 'edit'.
 */

$edit_id   = (int)($_GET['form_id'] ?? 0);
$edit_form = $edit_id ? FormBuilderPro_get_form($edit_id) : null;

$js_form_id   = $edit_id;
$js_form_name = $edit_form ? htmlspecialchars($edit_form['name'], ENT_QUOTES) : '';
$js_fields    = $edit_form ? $edit_form['fields']   : '[]';
$js_settings  = $edit_form ? $edit_form['settings'] : '{}';
$fb_nonce     = FormBuilderPro_get_token_nonce();
?>
<!-- ── Styles ───────────────────────────────────────────────────────────── -->
<link rel="stylesheet" href="<?= FormBuilderPro_PLUGIN_URL ?>assets/css/jquery-ui.min.css">
<link rel="stylesheet" href="<?= FormBuilderPro_PLUGIN_URL ?>assets/css/style.css">

<div id="fb-app" data-nonce="<?= htmlspecialchars($fb_nonce) ?>">

<!-- Toast -->
<div class="fb-toast" id="fb-toast"></div>

<!-- ── Header ───────────────────────────────────────────────────────────── -->
<div class="fb-header">
    <h3>
        <a style="color:var(--gold);border:1px solid var(--gold)" class="btn-icon" href="load.php?id=FormBuilderPro" title="<?= i18n_r('FormBuilderPro/lang_Back') ?>">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M10 4L6 8l4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
        <span id="builder-form-name"><?= i18n_r('FormBuilderPro/lang_Edit') ?>: <span style="color:grey"><?= $js_form_name ?: i18n_r('FormBuilderPro/lang_New_Form') ?></span></span>
    </h3>
    <div style="display:flex;gap:.5rem;align-items:center">
        <input type="text" id="builder-name-input" value="<?= $js_form_name ?>" placeholder="<?= i18n_r('FormBuilderPro/lang_Form_Name_Placeholder') ?>…"
               style="padding:.45rem .75rem;border:1px solid var(--border);border-radius:5px;font-size:.9rem;width:220px">
        <button class="btn btn-save" onclick="fbSaveForm()">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7l3.5 3.5L12 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <?= i18n_r('FormBuilderPro/lang_Save') ?>
        </button>
    </div>
</div>

<!-- ── Tabs ─────────────────────────────────────────────────────────────── -->
<div class="fb-tabs">
    <div class="fb-tab active" data-tab="fields" onclick="fbSwitchTab('fields')">
		<svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none" /><path fill="currentColor" d="M19 2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm0 4V4H5v2zm0 10a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2zm0 4v-2H5v2zm0-11a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2zm0 4v-2H5v2z" /></svg>
		<?= i18n_r('FormBuilderPro/lang_Tab_Fields') ?>
	</div>
	<div class="fb-tab" data-tab="settings" onclick="fbSwitchTab('settings')">
		<svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none" /><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707l.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707l-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707l-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535l1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708l.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536l.707-1.707H20a1 1 0 0 0 1-1" /><path d="M12 15a3 3 0 1 0 0-6a3 3 0 0 0 0 6" /></g></svg> 
		<?= i18n_r('FormBuilderPro/lang_Tab_Settings') ?>
	</div>
	<div class="fb-tab" data-tab="spam" onclick="fbSwitchTab('spam')">
		<svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none" /><path fill="currentColor" d="M12 22q-3.475-.875-5.738-3.988T4 11.1V5l8-3l8 3v6.1q0 3.8-2.262 6.913T12 22m0-2.1q2.425-.75 4.05-2.963T17.95 12H12V4.125l-6 2.25v5.175q0 .175.05.45H12z" /></svg> 
		<?= i18n_r('FormBuilderPro/lang_Tab_Spam') ?>
	</div>
	<div class="fb-tab" data-tab="embed" onclick="fbSwitchTab('embed')">
		<svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none" /><path fill="currentColor" d="m12.89 3l1.96.4L11.11 21l-1.96-.4zm6.7 9L16 8.41V5.58L22.42 12L16 18.41v-2.83zM1.58 12L8 5.58v2.83L4.41 12L8 15.58v2.83z" /></svg> 
		<?= i18n_r('FormBuilderPro/lang_Tab_Embed') ?>
	</div>
</div>

<div id="tab-fields">
    <div class="fb-panel">
        <div class="fb-panel-head"><?= i18n_r('FormBuilderPro/lang_Canvas_Head') ?></div>
        <div class="fb-canvas">
            <!-- formBuilder library mounts here -->
            <div id="fb-canvas"></div>
        </div>
    </div>

    <!-- Reply-To panel: shown only when email fields are present -->
    <div class="fb-panel" id="fb-replyto-panel" style="display:none;max-width:560px;margin-top:1rem">
        <div class="fb-panel-head"><?= i18n_r('FormBuilderPro/lang_ReplyTo_Head') ?></div>
        <div class="fb-settings-body" id="fb-replyto-body"></div>
    </div>

    <!-- File options panel: shown only when file fields are present -->
    <div class="fb-panel" id="fb-file-panel" style="display:none;max-width:560px;margin-top:1rem">
        <div class="fb-panel-head"><?= i18n_r('FormBuilderPro/lang_File_Options_Head') ?></div>
        <div class="fb-settings-body" id="fb-file-body">
            <p class="fb-hint" style="margin-bottom:.75rem"><?= i18n_r('FormBuilderPro/lang_File_Options_Hint') ?></p>
        </div>
    </div>
</div>

<!-- ── Tab: Settings ────────────────────────────────────────────────────── -->
<div id="tab-settings" style="display:none">
    <div class="fb-panel" style="max-width:560px">
        <div class="fb-panel-head"><?= i18n_r('FormBuilderPro/lang_Tab_Settings') ?></div>
        <div class="fb-settings-body">

            <div class="fb-prop-group">
                <label><?= i18n_r('FormBuilderPro/lang_Setting_EmailTo') ?></label>
                <input type="email" id="s-email-to" placeholder="recipient@example.com">
            </div>
            <div class="fb-prop-group">
                <label><?= i18n_r('FormBuilderPro/lang_Setting_EmailFrom') ?></label>
                <input type="email" id="s-email-from" placeholder="noreply@yourdomain.com">
                <p class="fb-hint"><?= i18n_r('FormBuilderPro/lang_Setting_EmailFrom_Hint') ?></p>
            </div>
            <div class="fb-prop-group">
                <label><?= i18n_r('FormBuilderPro/lang_Setting_EmailSubject') ?></label>
                <input type="text" id="s-email-subject">
            </div>
            <div class="fb-prop-group">
                <label><?= i18n_r('FormBuilderPro/lang_Setting_SubmitLabel') ?></label>
                <input type="text" id="s-submit-label" placeholder="Send">
            </div>
            <div class="fb-prop-group">
                <label><?= i18n_r('FormBuilderPro/lang_Setting_SuccessMsg') ?></label>
                <input type="text" id="s-success-msg">
            </div>

            <!--hr style="border:none;border-top:1px solid var(--border);margin:1.25rem 0"-->
		</div>
		
		<div class="fb-panel-head" style="border-top: 1px solid var(--border);"><?= i18n_r('FormBuilderPro/lang_Mail_Method') ?></div>
		<div class="fb-settings-body">
			<div class="fb-prop-group" style="display:flex;flex-direction:column;gap:.5rem">
				<label class="fb-toggle"><input type="radio" name="s-mail-method" id="s-mail-php"  value="php"  onchange="fbMailMethod('php')">  <?= i18n_r('FormBuilderPro/lang_Mail_Method_PHP') ?></label>
				<label class="fb-toggle"><input type="radio" name="s-mail-method" id="s-mail-smtp" value="smtp" onchange="fbMailMethod('smtp')"> <?= i18n_r('FormBuilderPro/lang_Mail_Method_SMTP') ?></label>
			</div>
		</div>

		<div id="s-smtp-fields">
		<div class="fb-panel-head" style="border-top: 1px solid var(--border);">SMTP — <?= i18n_r('FormBuilderPro/lang_SMTP_Hint') ?></div>
        <div class="fb-settings-body">

            <div class="fb-prop-group">
                <label><?= i18n_r('FormBuilderPro/lang_SMTP_Host') ?></label>
                <input type="text" id="s-smtp-host" placeholder="smtp.gmail.com">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
                <div class="fb-prop-group">
                    <label><?= i18n_r('FormBuilderPro/lang_SMTP_Port') ?></label>
                    <input type="text" id="s-smtp-port" placeholder="587">
                </div>
                <div class="fb-prop-group">
                    <label><?= i18n_r('FormBuilderPro/lang_SMTP_Enc') ?></label>
                    <select id="s-smtp-enc">
                        <option value="tls">TLS (STARTTLS)</option>
                        <option value="ssl">SSL</option>
                        <option value="none">None</option>
                    </select>
                </div>
            </div>
            <div class="fb-prop-group">
                <label><?= i18n_r('FormBuilderPro/lang_SMTP_User') ?></label>
                <input type="text" id="s-smtp-user">
            </div>
            <div class="fb-prop-group">
                <label><?= i18n_r('FormBuilderPro/lang_SMTP_Pass') ?></label>
                <input type="text" id="s-smtp-pass">
            </div>
            <div class="fb-prop-group">
                <label><?= i18n_r('FormBuilderPro/lang_SMTP_From') ?></label>
                <input type="email" id="s-smtp-from">
            </div>
			
            <div class="fb-prop-group">
                <label class="fb-toggle">
                    <input type="checkbox" id="s-attach-files">
                    <?= i18n_r('FormBuilderPro/lang_Setting_AttachFiles') ?>
                </label>
                <p class="fb-hint"><?= i18n_r('FormBuilderPro/lang_Setting_AttachFiles_Hint') ?></p>
            </div>

            <div style="margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid var(--border)">
                <button class="btn btn-test" type="button" onclick="fbTestEmail()">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 3.5L7 8l6-4.5M1 3.5h12v8H1z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
                    <?= i18n_r('FormBuilderPro/lang_Test_Email') ?>
                </button>
                <span id="fb-test-result" style="margin-left:.75rem;font-size:.875rem"></span>
            </div>

        </div>
        </div><!-- #s-smtp-fields -->
    </div>
</div><!-- #tab-settings -->

<!-- ── Tab: Spam ────────────────────────────────────────────────────────── -->
<div id="tab-spam" style="display:none">
    <div class="fb-panel" style="max-width:560px">
        <div class="fb-panel-head"><?= i18n_r('FormBuilderPro/lang_Tab_Spam') ?></div>
        <div class="fb-settings-body">

            <div class="fb-prop-group">
                <label class="fb-toggle">
                    <input type="checkbox" id="s-honeypot">
                    <?= i18n_r('FormBuilderPro/lang_Spam_Honeypot') ?>
                </label>
                <p class="fb-hint"><?= i18n_r('FormBuilderPro/lang_Spam_Honeypot_Hint') ?></p>
            </div>

            <div class="fb-prop-group">
                <label class="fb-toggle">
                    <input type="checkbox" id="s-timecheck">
                    <?= i18n_r('FormBuilderPro/lang_Spam_Timecheck') ?>
                </label>
                <p class="fb-hint"><?= i18n_r('FormBuilderPro/lang_Spam_Timecheck_Hint') ?></p>
                <div id="s-timecheck-options" style="display:none;margin-top:.6rem">
                    <label style="text-transform:none;letter-spacing:0;font-size:.875rem;font-weight:500">
                        <?= i18n_r('FormBuilderPro/lang_Spam_Min_Time') ?>
                        <input type="number" id="s-timecheck-min" min="1" max="30" value="3"
                               style="width:70px;margin-left:.5rem;display:inline-block">
                        <?= i18n_r('FormBuilderPro/lang_Spam_Seconds') ?>
                    </label>
                </div>
            </div>

            <!--hr style="border:none;border-top:1px solid var(--border);margin:1.25rem 0"-->
		</div>
		
		<div class="fb-panel-head" style="border-top: 1px solid var(--border);"><?= i18n_r('FormBuilderPro/lang_Captcha_Method') ?></div>
		<div class="fb-settings-body">

            <div class="fb-prop-group" style="display:flex;flex-direction:column;gap:.5rem">
                <label class="fb-toggle"><input type="radio" name="s-captcha-method" id="s-captcha-none"      value="none"       onchange="fbCaptchaMethod('none')">       <?= i18n_r('FormBuilderPro/lang_Captcha_None') ?></label>
                <label class="fb-toggle"><input type="radio" name="s-captcha-method" id="s-captcha-turnstile" value="turnstile"  onchange="fbCaptchaMethod('turnstile')">  Cloudflare Turnstile</label>
                <label class="fb-toggle"><input type="radio" name="s-captcha-method" id="s-captcha-hcaptcha"  value="hcaptcha"   onchange="fbCaptchaMethod('hcaptcha')">   hCaptcha</label>
                <label class="fb-toggle"><input type="radio" name="s-captcha-method" id="s-captcha-recaptcha2" value="recaptcha2" onchange="fbCaptchaMethod('recaptcha2')"> Google reCAPTCHA v2</label>
                <label class="fb-toggle"><input type="radio" name="s-captcha-method" id="s-captcha-recaptcha3" value="recaptcha3" onchange="fbCaptchaMethod('recaptcha3')"> Google reCAPTCHA v3</label>
            </div>

            <!-- Turnstile fields -->
            <div id="s-captcha-turnstile-fields" style="display:none;margin-top:.75rem">
                <p class="fb-hint" style="margin-bottom:.9rem">
                    <?= i18n_r('FormBuilderPro/lang_Turnstile_Hint') ?>
                    <a href="https://dash.cloudflare.com/?to=/:account/turnstile" target="_blank" rel="noopener">
                        <?= i18n_r('FormBuilderPro/lang_Turnstile_Link') ?>
                    </a>
                </p>
                <div class="fb-prop-group">
                    <label><?= i18n_r('FormBuilderPro/lang_Turnstile_Site_Key') ?></label>
                    <input type="text" id="s-turnstile-site-key" placeholder="0x4AAAAAAA...">
                </div>
                <div class="fb-prop-group">
                    <label><?= i18n_r('FormBuilderPro/lang_Turnstile_Secret_Key') ?></label>
                    <input type="text" id="s-turnstile-secret-key" placeholder="0x4AAAAAAA...">
                    <p class="fb-hint"><?= i18n_r('FormBuilderPro/lang_Turnstile_Secret_Hint') ?></p>
                </div>
            </div>

            <!-- hCaptcha fields -->
            <div id="s-captcha-hcaptcha-fields" style="display:none;margin-top:.75rem">
                <p class="fb-hint" style="margin-bottom:.9rem">
                    <?= i18n_r('FormBuilderPro/lang_HCaptcha_Hint') ?>
                    <a href="https://dashboard.hcaptcha.com" target="_blank" rel="noopener">
                        <?= i18n_r('FormBuilderPro/lang_HCaptcha_Link') ?>
                    </a>
                </p>
                <div class="fb-prop-group">
                    <label><?= i18n_r('FormBuilderPro/lang_HCaptcha_Site_Key') ?></label>
                    <input type="text" id="s-hcaptcha-site-key" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">
                </div>
                <div class="fb-prop-group">
                    <label><?= i18n_r('FormBuilderPro/lang_HCaptcha_Secret_Key') ?></label>
                    <input type="text" id="s-hcaptcha-secret-key" placeholder="0x...">
                    <p class="fb-hint"><?= i18n_r('FormBuilderPro/lang_HCaptcha_Secret_Hint') ?></p>
                </div>
            </div>

            <!-- reCAPTCHA v2 fields -->
            <div id="s-captcha-recaptcha2-fields" style="display:none;margin-top:.75rem">
                <p class="fb-hint" style="margin-bottom:.9rem">
                    <?= i18n_r('FormBuilderPro/lang_Recaptcha_Hint') ?>
                    <a href="https://www.google.com/recaptcha/admin/create" target="_blank" rel="noopener">
                        <?= i18n_r('FormBuilderPro/lang_Recaptcha_Link') ?>
                    </a>
                </p>
                <div class="fb-prop-group">
                    <label><?= i18n_r('FormBuilderPro/lang_Recaptcha_Site_Key') ?></label>
                    <input type="text" id="s-recaptcha2-site-key" placeholder="6Lc...">
                </div>
                <div class="fb-prop-group">
                    <label><?= i18n_r('FormBuilderPro/lang_Recaptcha_Secret_Key') ?></label>
                    <input type="text" id="s-recaptcha2-secret-key" placeholder="6Lc...">
                    <p class="fb-hint"><?= i18n_r('FormBuilderPro/lang_Recaptcha_Secret_Hint') ?></p>
                </div>
            </div>

            <!-- reCAPTCHA v3 fields -->
            <div id="s-captcha-recaptcha3-fields" style="display:none;margin-top:.75rem">
                <p class="fb-hint" style="margin-bottom:.9rem">
                    <?= i18n_r('FormBuilderPro/lang_Recaptcha_Hint') ?>
                    <a href="https://www.google.com/recaptcha/admin/create" target="_blank" rel="noopener">
                        <?= i18n_r('FormBuilderPro/lang_Recaptcha_Link') ?>
                    </a>
                </p>
                <div class="fb-prop-group">
                    <label><?= i18n_r('FormBuilderPro/lang_Recaptcha_Site_Key') ?></label>
                    <input type="text" id="s-recaptcha3-site-key" placeholder="6Lc...">
                </div>
                <div class="fb-prop-group">
                    <label><?= i18n_r('FormBuilderPro/lang_Recaptcha_Secret_Key') ?></label>
                    <input type="text" id="s-recaptcha3-secret-key" placeholder="6Lc...">
                    <p class="fb-hint"><?= i18n_r('FormBuilderPro/lang_Recaptcha_Secret_Hint') ?></p>
                </div>
                <div class="fb-prop-group">
                    <label><?= i18n_r('FormBuilderPro/lang_Recaptcha3_Threshold') ?></label>
                    <input type="number" id="s-recaptcha3-threshold" min="0" max="1" step="0.1" value="0.5"
                           style="width:80px">
                    <p class="fb-hint"><?= i18n_r('FormBuilderPro/lang_Recaptcha3_Threshold_Hint') ?></p>
                </div>
            </div>

        </div>
    </div>
</div><!-- #tab-spam -->

<!-- ── Tab: Embed ───────────────────────────────────────────────────────── -->
<div id="tab-embed" style="display:none">
    <div class="fb-panel" style="max-width:560px">
        <div class="fb-panel-head"><?= i18n_r('FormBuilderPro/lang_Tab_Embed') ?></div>
        <div class="fb-settings-body">
            <div class="fb-prop-group">
                <label><?= i18n_r('FormBuilderPro/lang_Embed_Shortcode') ?></label>
                <input type="text" id="embed-shortcode" readonly onclick="this.select()"
                       style="font-family:monospace;background:#f4f6f9;cursor:pointer">
            </div>
            <div class="fb-prop-group">
                <label><?= i18n_r('FormBuilderPro/lang_Embed_Tag') ?></label>
                <input type="text" id="embed-tag" readonly onclick="this.select()"
                       style="font-family:monospace;background:#f4f6f9;cursor:pointer">
            </div>
            <p style="font-size:.8rem;color:var(--text-muted)">
                <?= i18n_r('FormBuilderPro/lang_Embed_SaveHint') ?>
            </p>
        </div>
    </div>
</div><!-- #tab-embed -->

</div><!-- #fb-app -->

<!-- ── Seed data from PHP ────────────────────────────────────────────────── -->
<script>
const FB_FORM_ID   = <?= json_encode($js_form_id) ?>;
const FB_FORM_NAME = <?= json_encode($js_form_name) ?>;
const FB_FIELDS    = <?= $js_fields ?>;
const FB_SETTINGS  = <?= $js_settings ?>;
const FB_LOCALE    = <?= json_encode($fb_locale ?? 'en-US') ?>;
const FB_PLUGIN_URL = <?= json_encode(FormBuilderPro_PLUGIN_URL) ?>;
const FB_NONCE     = <?= json_encode($fb_nonce) ?>;

const FB_I18N = {
    saveFirst:    <?= json_encode(i18n_r('FormBuilderPro/lang_Save_First'))    ?>,
    nameRequired: <?= json_encode(i18n_r('FormBuilderPro/lang_Name_Required')) ?>,
    saved:        <?= json_encode(i18n_r('FormBuilderPro/lang_Saved'))         ?>,
    saveFailed:   <?= json_encode(i18n_r('FormBuilderPro/lang_Save_Failed'))   ?>,
    testSending:  <?= json_encode(i18n_r('FormBuilderPro/lang_Test_Sending'))  ?>,
    testOk:       <?= json_encode(i18n_r('FormBuilderPro/lang_Test_Ok'))       ?>,
    testFail:     <?= json_encode(i18n_r('FormBuilderPro/lang_Test_Fail'))     ?>,
};
</script>

<!-- ── Scripts (order matters) ──────────────────────────────────────────── -->
<script src="<?= FormBuilderPro_PLUGIN_URL ?>assets/js/jquery.min.js"></script>
<script src="<?= FormBuilderPro_PLUGIN_URL ?>assets/js/jquery-ui.min.js"></script>
<script src="<?= FormBuilderPro_PLUGIN_URL ?>assets/js/form-builder.min.js"></script>
<script src="<?= FormBuilderPro_PLUGIN_URL ?>assets/js/scripts.js"></script>