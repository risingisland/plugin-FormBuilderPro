/**
 * formBuilder — Admin JS
 * Loaded only on the edit-form admin page.
 *
 * Depends on (loaded before this file):
 *   jQuery 3.x, jQuery UI, form-builder.min.js
 *
 * Seed globals injected by edit-form.php:
 *   FB_FORM_ID, FB_FORM_NAME, FB_FIELDS, FB_SETTINGS, FB_I18N
 */

$(function () {

	// ── Field types available in the palette ──────────────────────────────
	const FB_CONTROLS = [
		'header', 'paragraph',
		'text', 'textarea', 'email', 'tel', 'number',
		'select', 'radio-group', 'checkbox-group',
		'file', 'date', 'time',
	];

	// ── reply_to state — kept separately, keyed by field name ─────────────
	const replyToState = {};
	(FB_FIELDS || []).forEach(f => {
		// Email fields stored as type='text' subtype='email', or type='email'
		const isEmail = f.type === 'email' || (f.type === 'text' && f.subtype === 'email');
		if (isEmail && f.reply_to) replyToState[f.name] = true;
	});

	// ── file field options state — keyed by field name ────────────────────
	const fileState = {};
	(FB_FIELDS || []).forEach(f => {
		if (f.type === 'file') {
			fileState[f.name] = {
				allowed_types: f.allowed_types || 'pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,zip',
				max_size:      f.max_size      || 5,
			};
		}
	});

	// ── Init formBuilder library ──────────────────────────────────────────
	const $canvas = $('#fb-canvas');
	let fbInstance = null;

	const fbOpts = {
		controlOrder:		  FB_CONTROLS,
		controlPosition:	  'left',
		disabledActionButtons: ['data', 'clear', 'save'],
		disableFields:		  ['autocomplete', 'button', 'hidden', 'starRating'],
		formData:			  fbFieldsToLibFormat(FB_FIELDS),
		i18n: {
			location:  FB_PLUGIN_URL + 'assets/lang/',
			extension: '.lang',
			locale:    FB_LOCALE,
		},
	};

	$canvas.formBuilder(fbOpts).promise.then(function (instance) {
		fbInstance = instance;
		fbRenderReplyToPanel();
		fbRenderFilePanel();
	});

	// ── Utilities ─────────────────────────────────────────────────────────
	function fbToast(msg, type) {
		const t = document.getElementById('fb-toast');
		t.textContent = msg;
		t.className = 'fb-toast ' + (type || '') + ' show';
		setTimeout(() => t.className = 'fb-toast', 2500);
	}

	function fbSlugify(s) {
		return s.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
	}

	function escH(s) {
		return String(s)
			.replace(/&/g, '&amp;').replace(/</g, '&lt;')
			.replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	}

	// Our storage format → formBuilder library format
	// Since we now store the full library object, pass it straight through.
	// Strip our custom properties first so the library doesn't choke on them.
	function fbFieldsToLibFormat(fields) {
		if (!fields || !fields.length) return null;
		return fields.map(f => {
			// Remove our custom keys before handing back to library
			const { reply_to, allowed_types, max_size, ...libField } = f;
			return libField;
		});
	}

	// Library JS array → our storage format
	// We store the full library object to preserve all field properties,
	// then layer our custom state (reply_to, file options) on top.
	function libFieldsToOurFormat(libFields) {
		if (!Array.isArray(libFields)) return [];
		return libFields.map(f => {
			const name = f.name || fbSlugify(f.label || f.type);
			// Start with the full library object so nothing is discarded
			const out = Object.assign({}, f, { name });
			// Layer our custom state on top
			out.reply_to = !!replyToState[name];
			if (f.type === 'file') {
				out.allowed_types = fileState[name]?.allowed_types ?? 'pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,zip';
				out.max_size      = fileState[name]?.max_size      ?? 5;
			}
			return out;
		});
	}

	// Get current fields from the library as a JS array
	function getLibFields() {
		if (!fbInstance) return [];
		try {
			const data = fbInstance.actions.getData();
			if (Array.isArray(data)) return data;
			// Older versions may return JSON string
			const parsed = JSON.parse(data);
			return Array.isArray(parsed) ? parsed : [];
		} catch(e) {
			return [];
		}
	}

	// ── Tab switching ─────────────────────────────────────────────────────
	window.fbSwitchTab = function (name) {
		document.querySelectorAll('.fb-tab').forEach(t =>
			t.classList.toggle('active', t.dataset.tab === name)
		);
		document.getElementById('tab-fields').style.display   = name === 'fields'   ? '' : 'none';
		document.getElementById('tab-settings').style.display = name === 'settings' ? '' : 'none';
		document.getElementById('tab-spam').style.display	 = name === 'spam'	 ? '' : 'none';
		document.getElementById('tab-embed').style.display	= name === 'embed'	? '' : 'none';
		if (name === 'embed') updateEmbed();
	};

	// ── Settings I/O ──────────────────────────────────────────────────────
	function loadSettings() {
		const s = FB_SETTINGS;
		$('#s-email-to').val(s.email_to	  || '');
		$('#s-email-from').val(s.email_from   || '');
		$('#s-email-subject').val(s.email_subject || '');
		$('#s-submit-label').val(s.submit_label  || '');
		$('#s-success-msg').val(s.success_msg   || '');
		$('#s-attach-files').prop('checked', !!s.attach_files);
		// Mail method
		const mailMethod = s.mail_method || 'php';
		$(`input[name="s-mail-method"][value="${mailMethod}"]`).prop('checked', true);
		fbMailMethod(mailMethod);
		$('#s-smtp-host').val(s.smtp_host	 || '');
		$('#s-smtp-port').val(s.smtp_port	 || '');
		$('#s-smtp-enc').val(s.smtp_enc	  || 'tls');
		$('#s-smtp-user').val(s.smtp_user	 || '');
		$('#s-smtp-pass').val(s.smtp_pass	 || '');
		$('#s-smtp-from').val(s.smtp_from	 || '');
		// Spam
		$('#s-honeypot').prop('checked', !!s.honeypot);
		$('#s-timecheck').prop('checked', !!s.timecheck);
		$('#s-timecheck-min').val(s.timecheck_min || 3);
		$('#s-timecheck-options').toggle(!!s.timecheck);
		const method = s.captcha_method || 'none';
		$(`input[name="s-captcha-method"][value="${method}"]`).prop('checked', true);
		fbCaptchaMethod(method);
		$('#s-turnstile-site-key').val(s.turnstile_site_key	|| '');
		$('#s-turnstile-secret-key').val(s.turnstile_secret_key  || '');
		$('#s-hcaptcha-site-key').val(s.hcaptcha_site_key	 || '');
		$('#s-hcaptcha-secret-key').val(s.hcaptcha_secret_key   || '');
		$('#s-recaptcha2-site-key').val(s.recaptcha2_site_key   || '');
		$('#s-recaptcha2-secret-key').val(s.recaptcha2_secret_key || '');
		$('#s-recaptcha3-site-key').val(s.recaptcha3_site_key   || '');
		$('#s-recaptcha3-secret-key').val(s.recaptcha3_secret_key || '');
		$('#s-recaptcha3-threshold').val(s.recaptcha3_threshold  ?? 0.5);
	}

	function readSettings() {
		return {
			email_to:			 $('#s-email-to').val(),
			email_from:		   $('#s-email-from').val(),
			email_subject:		$('#s-email-subject').val(),
			submit_label:		 $('#s-submit-label').val(),
			success_msg:		  $('#s-success-msg').val(),
			attach_files:		 $('#s-attach-files').is(':checked') ? 1 : 0,
			mail_method:		  $('input[name="s-mail-method"]:checked').val() || 'php',
			smtp_host:			$('#s-smtp-host').val(),
			smtp_port:			$('#s-smtp-port').val(),
			smtp_enc:			 $('#s-smtp-enc').val(),
			smtp_user:			$('#s-smtp-user').val(),
			smtp_pass:			$('#s-smtp-pass').val(),
			smtp_from:			$('#s-smtp-from').val(),
			honeypot:			 $('#s-honeypot').is(':checked') ? 1 : 0,
			timecheck:			$('#s-timecheck').is(':checked') ? 1 : 0,
			timecheck_min:		parseInt($('#s-timecheck-min').val(), 10) || 3,
			captcha_method:	   $('input[name="s-captcha-method"]:checked').val() || 'none',
			turnstile_site_key:   $('#s-turnstile-site-key').val(),
			turnstile_secret_key: $('#s-turnstile-secret-key').val(),
			hcaptcha_site_key:	$('#s-hcaptcha-site-key').val(),
			hcaptcha_secret_key:  $('#s-hcaptcha-secret-key').val(),
			recaptcha2_site_key:  $('#s-recaptcha2-site-key').val(),
			recaptcha2_secret_key:$('#s-recaptcha2-secret-key').val(),
			recaptcha3_site_key:  $('#s-recaptcha3-site-key').val(),
			recaptcha3_secret_key:$('#s-recaptcha3-secret-key').val(),
			recaptcha3_threshold: parseFloat($('#s-recaptcha3-threshold').val()) || 0.5,
		};
	}

	$('#s-timecheck').on('change', function () {
		$('#s-timecheck-options').toggle(this.checked);
	});

	window.fbCaptchaMethod = function (method) {
		$('#s-captcha-turnstile-fields').toggle(method === 'turnstile');
		$('#s-captcha-hcaptcha-fields').toggle(method === 'hcaptcha');
		$('#s-captcha-recaptcha2-fields').toggle(method === 'recaptcha2');
		$('#s-captcha-recaptcha3-fields').toggle(method === 'recaptcha3');
	};

	window.fbMailMethod = function (method) {
		$('#s-smtp-fields').toggle(method === 'smtp');
	};

	// ── File field options panel ──────────────────────────────────────────
	function fbRenderFilePanel() {
		const panel = document.getElementById('fb-file-panel');
		const body  = document.getElementById('fb-file-body');
		if (!panel) return;

		const allFields  = getLibFields();
		const fileFields = allFields.filter(f => f.type === 'file');

		if (!fileFields.length) { panel.style.display = 'none'; return; }
		panel.style.display = '';

		body.innerHTML = fileFields.map(f => {
			const name  = f.name || fbSlugify(f.label || 'file');
			const state = fileState[name] || { allowed_types: 'pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,zip', max_size: 5 };
			return `<div class="fb-prop-group" style="border-bottom:1px solid var(--border);padding-bottom:.75rem;margin-bottom:.75rem">
				<label style="font-weight:700;text-transform:none;letter-spacing:0;font-size:.875rem;color:var(--text);margin-bottom:.5rem">${escH(f.label || name)}</label>
				<div class="fb-prop-group" style="margin-bottom:.5rem">
					<label>Allowed file types</label>
					<input type="text" value="${escH(state.allowed_types)}"
						   oninput="fbSetFileOption('${escH(name)}', 'allowed_types', this.value)"
						   placeholder="pdf,jpg,png,doc,zip"
						   style="width:100%;padding:.4rem .6rem;border:1px solid var(--border);border-radius:4px;font-size:.875rem">
					<p class="fb-hint">Comma-separated extensions, e.g. pdf,jpg,png</p>
				</div>
				<div class="fb-prop-group" style="margin:0">
					<label>Max file size (MB)</label>
					<input type="number" min="1" max="50" value="${state.max_size}"
						   oninput="fbSetFileOption('${escH(name)}', 'max_size', parseFloat(this.value))"
						   style="width:80px;padding:.4rem .6rem;border:1px solid var(--border);border-radius:4px;font-size:.875rem">
				</div>
			</div>`;
		}).join('');
	}

	window.fbSetFileOption = function (fieldName, key, value) {
		if (!fileState[fieldName]) fileState[fieldName] = { allowed_types: 'pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,zip', max_size: 5 };
		fileState[fieldName][key] = value;
	};

	// ── Embed codes ───────────────────────────────────────────────────────
	let fbCurrentSlug = '';

	function updateEmbed() {
		if (!FB_FORM_ID && !window.fbSavedId) {
			$('#embed-shortcode').val(FB_I18N.saveFirst);
			$('#embed-tag').val(FB_I18N.saveFirst);
			return;
		}
		const slug = fbCurrentSlug || fbSlugify($('#builder-name-input').val() || 'form');
		$('#embed-shortcode').val(`[formbuilderpro slug="${slug}"]`);
		$('#embed-tag').val(`<?php get_FormBuilderPro('${slug}'); ?>`);
	}

	// ── Save ──────────────────────────────────────────────────────────────
	window.fbSaveForm = function () {
		const name = $('#builder-name-input').val().trim();
		if (!name) { fbToast(FB_I18N.nameRequired, 'error'); return; }

		const libFields = getLibFields();
		const ourFields = libFieldsToOurFormat(libFields);
		const settings  = readSettings();
		const formId	= window.fbSavedId || FB_FORM_ID;

		$.ajax({
			url:	  '?id=FormBuilderPro',
			method:   'POST',
			dataType: 'json',
			data: {
				fb_action: 'save_form',
				id:		formId,
				name:	  name,
				fields:	JSON.stringify(ourFields),
				settings:  JSON.stringify(settings),
			},
			success: function (d) {
				if (d && d.ok) {
					window.fbSavedId = d.id;
					fbCurrentSlug	= d.slug;
					document.getElementById('builder-form-name').textContent = name;
					fbToast(FB_I18N.saved, 'success');
					updateEmbed();
					fbRenderReplyToPanel();
					fbRenderFilePanel();
					history.replaceState(null, '', '?id=FormBuilderPro&fb_view=edit&form_id=' + d.id);
				} else {
					fbToast((d && d.msg) || FB_I18N.saveFailed, 'error');
				}
			},
			error: function () { fbToast(FB_I18N.saveFailed, 'error'); },
		});
	};

	// ── Test email ────────────────────────────────────────────────────────
	window.fbTestEmail = function () {
		const settings = readSettings();
		const resultEl = document.getElementById('fb-test-result');
		const btn	  = document.querySelector('button[onclick="fbTestEmail()"]');

		resultEl.style.color = 'var(--text-muted)';
		resultEl.textContent = FB_I18N.testSending;
		btn.disabled = true;

		$.ajax({
			url:	  '?id=FormBuilderPro',
			method:   'POST',
			dataType: 'json',
			data: { fb_action: 'test_email', settings: JSON.stringify(settings) },
			success: function (d) {
				if (d && d.ok) {
					resultEl.style.color = 'var(--success)';
					resultEl.textContent = FB_I18N.testOk;
				} else {
					resultEl.style.color = 'var(--danger)';
					let msg = (d && d.msg) ? d.msg : FB_I18N.testFail;
					if (d && d.debug) {
						msg += '\n\nDebug info:\n' + JSON.stringify(d.debug, null, 2);
						resultEl.style.whiteSpace = 'pre';
						resultEl.style.fontFamily = 'monospace';
						resultEl.style.fontSize   = '.75rem';
					}
					resultEl.textContent = msg;
				}
			},
			error: function () {
				resultEl.style.color = 'var(--danger)';
				resultEl.textContent = FB_I18N.testFail;
			},
			complete: function () { btn.disabled = false; },
		});
	};

	// ── Reply-To panel ────────────────────────────────────────────────────
	function fbRenderReplyToPanel() {
		const panel = document.getElementById('fb-replyto-panel');
		const body  = document.getElementById('fb-replyto-body');
		if (!panel) return;

		// Read current email fields directly from the library
		const allFields   = getLibFields();
		const emailFields = allFields.filter(f =>
			f.type === 'email' || (f.type === 'text' && f.subtype === 'email')
		);

		if (!emailFields.length) { panel.style.display = 'none'; return; }
		panel.style.display = '';

		body.innerHTML = emailFields.map(f => {
			const name = f.name || fbSlugify(f.label || 'email');
			return `<div class="fb-prop-group">
				<label class="fb-toggle">
					<input type="checkbox" onchange="fbSetReplyTo('${escH(name)}', this.checked)"
						   ${replyToState[name] ? 'checked' : ''}>
					<span>${escH(f.label || name)}</span>
				</label>
			</div>`;
		}).join('');
	}

	window.fbSetReplyTo = function (fieldName, checked) {
		// Clear all, then set the chosen one
		Object.keys(replyToState).forEach(k => delete replyToState[k]);
		if (checked) replyToState[fieldName] = true;
		fbRenderReplyToPanel();
	};

	// ── Init ──────────────────────────────────────────────────────────────
	loadSettings();
	if (FB_FORM_ID) updateEmbed();

});