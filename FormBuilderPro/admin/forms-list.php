<?php if (!defined('IN_GS')) { die('You cannot load this page directly.'); }

/**
 * formBuilder — Admin: Forms List
 * Included by FormBuilderPro_admin_page() when fb_view is 'list' (default).
 */

global $SITEURL;
$forms = FormBuilderPro_get_forms();$fb_nonce = FormBuilderPro_get_token_nonce();
?>
<div id="fb-app" data-nonce="<?= htmlspecialchars($fb_nonce) ?>">

<link rel="stylesheet" href="<?= FormBuilderPro_PLUGIN_URL ?>assets/css/style.css">
<script>
const FB_DOWNLOAD_BASE = '<?= $SITEURL ?>plugins/FormBuilderPro/public/download.php?token=';
</script>

<!-- Toast -->
<div class="fb-toast" id="fb-toast"></div>

<!-- Submissions modal -->
<div class="fb-modal-bg" id="fb-modal-bg">
    <div class="fb-modal">
        <div class="fb-modal-head">
            <span id="fb-modal-title">Submissions</span>
            <button class="btn-icon" onclick="fbCloseModal()">✕</button>
        </div>
        <div class="fb-modal-body" id="fb-modal-body"></div>
    </div>
</div>

<div class="fb-header">
    <h3>
        <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;margin-right:10px" width="32" height="32" viewBox="0 0 28 28"><path d="M0 0h28v28H0z" fill="none"/><g fill="none"><path fill="url(#fba)" d="M6.75 3A3.75 3.75 0 0 0 3 6.75v14.5A3.75 3.75 0 0 0 6.75 25h14.5A3.75 3.75 0 0 0 25 21.25V6.75A3.75 3.75 0 0 0 21.25 3z"/><path fill="url(#fbb)" d="M6 12.5a2.5 2.5 0 1 1 5 0a2.5 2.5 0 0 1-5 0M8.5 17a2.5 2.5 0 1 0 0 5a2.5 2.5 0 0 0 0-5m4.5-4.75a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1-.75-.75m.75 6.25a.75.75 0 0 0 0 1.5h7.5a.75.75 0 0 0 0-1.5zM6 7.25a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H6.75A.75.75 0 0 1 6 7.25"/><defs><linearGradient id="fba" x1="10.857" x2="19.286" y1="3" y2="23.814" gradientUnits="userSpaceOnUse"><stop stop-color="#b3e0ff"/><stop offset="1" stop-color="#8cd0ff"/></linearGradient><linearGradient id="fbb" x1="5.2" x2="24.614" y1="5.725" y2="9.282" gradientUnits="userSpaceOnUse"><stop stop-color="#0094f0"/><stop offset="1" stop-color="#2764e7"/></linearGradient></defs></g></svg> 
        <?= i18n_r('FormBuilderPro/lang_Page_Title') ?>
    </h3>
    <a class="btn btn-primary" href="?id=FormBuilderPro&fb_view=edit">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        <?= i18n_r('FormBuilderPro/lang_New_Form') ?>
    </a>
</div>

<!-- ── View tabs ─────────────────────────────────────────────────────── -->
<div class="fb-tabs" style="margin-bottom:1rem">
	<div class="fb-tab active" data-view="forms"  onclick="fbListView('forms')" >
		<svg style="vertical-align:middle" width="1.4em" height="1.4em" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/><path d="M11 15h6v2h-6zM9 7H7v2h2zm2 6h6v-2h-6zm0-4h6V7h-6zm-2 2H7v2h2zm12-6v14c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h14c1.1 0 2 .9 2 2m-2 0H5v14h14zM9 15H7v2h2z" fill="currentColor"/></svg>
		<?= i18n_r('FormBuilderPro/lang_Tab_Forms')  ?>
	</div>
	<div class="fb-tab" data-view="files"  onclick="fbListView('files')" >
		<svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.4em" height="1.4em" viewBox="0 0 16 16"><path d="M0 0h16v16H0z" fill="none" /><path fill="currentColor" fill-rule="evenodd" d="M8 10.5h4A1.5 1.5 0 0 0 13.5 9V7H12a3 3 0 0 1-3-3V2.5H8A1.5 1.5 0 0 0 6.5 4v5A1.5 1.5 0 0 0 8 10.5m5.06-5.318q.145.145.243.318H12A1.5 1.5 0 0 1 10.5 4V2.697q.174.098.318.242zM15 6.242a3 3 0 0 0-.879-2.12L11.88 1.878A3 3 0 0 0 9.757 1H8a3 3 0 0 0-3 3H4a3 3 0 0 0-3 3v5a3 3 0 0 0 3 3h4a3 3 0 0 0 3-3h1a3 3 0 0 0 3-3zM9.5 12H8a3 3 0 0 1-3-3V5.5H4A1.5 1.5 0 0 0 2.5 7v5A1.5 1.5 0 0 0 4 13.5h4A1.5 1.5 0 0 0 9.5 12" clip-rule="evenodd" /></svg>
		<?= i18n_r('FormBuilderPro/lang_Tab_Files')  ?>
	</div>
</div>

<!-- ── Forms view ─────────────────────────────────────────────────────── -->
<div id="view-forms">
<?php if (empty($forms)): ?>
<div class="fb-empty">
    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d0d5dd" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 12h6M9 8h6M9 16h4"/></svg>
    <?= i18n_r('FormBuilderPro/lang_No_Forms') ?>
</div>
<?php else: ?>
<table class="fb-table">
    <thead><tr>
        <th><?= i18n_r('FormBuilderPro/lang_Col_Name') ?></th>
        <th><?= i18n_r('FormBuilderPro/lang_Col_Slug') ?></th>
        <th><?= i18n_r('FormBuilderPro/lang_Col_Fields') ?></th>
        <th><?= i18n_r('FormBuilderPro/lang_Col_Created') ?></th>
        <th></th>
    </tr></thead>
    <tbody>
    <?php foreach ($forms as $f):
        $field_count = count(json_decode($f['fields'], true) ?: []);
    ?>
    <tr>
        <td><strong><?= htmlspecialchars($f['name']) ?></strong></td>
        <td><span class="fb-slug"><?= htmlspecialchars($f['slug']) ?></span></td>
        <td><?= $field_count ?></td>
        <td><?= date('d M Y', $f['created']) ?></td>
        <td style="text-align:right;white-space:nowrap">
            <a class="btn btn-edit btn-sm" href="load.php?id=FormBuilderPro&fb_view=edit&form_id=<?= $f['id'] ?>">
                <svg width="1em" height="1em" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/><g fill="currentColor"><path d="M8 7a1 1 0 0 1-1 1H6a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h9a1 1 0 0 0 1-1v-1a1 1 0 0 1 2 0v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V9a3 3 0 0 1 3-3h1a1 1 0 0 1 1 1"/><path d="m14.596 5.011l4.392 4.392l-6.28 6.303A1 1 0 0 1 12 16H9a1 1 0 0 1-1-1v-3a1 1 0 0 1 .294-.708zm6.496-2.103a3.097 3.097 0 0 1 .165 4.203l-.164.18l-.693.694l-4.387-4.387l.695-.69a3.1 3.1 0 0 1 4.384 0"/></g></svg>
				<?= i18n_r('FormBuilderPro/lang_Edit') ?>
            </a>
            <button class="btn btn-ghost btn-sm" onclick="fbDuplicateForm(<?= $f['id'] ?>, <?= htmlspecialchars(json_encode($f['name'])) ?>)">
                <svg width="1em" height="1em" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/><path d="M16 1H4a2 2 0 0 0-2 2v14h2V3h12zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2m0 16H8V7h11z" fill="currentColor"/></svg>
				<?= i18n_r('FormBuilderPro/lang_Duplicate') ?>
            </button>
            <button class="btn btn-test btn-sm" onclick="fbViewSubmissions(<?= $f['id'] ?>, <?= htmlspecialchars(json_encode($f['name'])) ?>)">
                <svg width="1em" height="1em" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 .64L8.23 3H5v2L2.97 6.29C2.39 6.64 2 7.27 2 8v10a2 2 0 0 0 2 2h16c1.11 0 2-.89 2-2V8c0-.73-.39-1.36-.97-1.71L19 5V3h-3.23M7 5h10v4.88L12 13L7 9.88M8 6v1.5h8V6M5 7.38v1.25L4 8m15-.62L20 8l-1 .63M8 8.5V10h8V8.5Z" fill="currentColor"/></svg>
				<?= i18n_r('FormBuilderPro/lang_Submissions') ?>
            </button>
            <button class="btn btn-danger btn-sm" onclick="fbDeleteForm(<?= $f['id'] ?>, <?= htmlspecialchars(json_encode($f['name'])) ?>)">
                <svg width="1em" height="1em" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6z" fill="currentColor"/></svg>
				<?= i18n_r('FormBuilderPro/lang_Delete') ?>
            </button>
        </td>
    </tr>
    <?php endforeach ?>
    </tbody>
</table>
<?php endif ?>
</div><!-- #view-forms -->

<!-- ── Files view ─────────────────────────────────────────────────────── -->
<div id="view-files" style="display:none">
    <div class="fb-panel">
        <div class="fb-panel-head"><?= i18n_r('FormBuilderPro/lang_Files_Head') ?></div>
        <div id="fb-files-body" style="padding:1rem;color:var(--text-muted);font-size:.875rem">
            <?= i18n_r('FormBuilderPro/lang_Files_Loading') ?>
        </div>
    </div>
</div>

</div><!-- #fb-app -->

<script>
function fbToast(msg, type) {
    const t = document.getElementById('fb-toast');
    t.textContent = msg;
    t.className = 'fb-toast ' + (type || '') + ' show';
    setTimeout(() => t.className = 'fb-toast', 2500);
}

function fbDuplicateForm(id, name) {
    if (!confirm('Duplicate "' + name + '"?')) return;
    const nonce = document.getElementById('fb-app').dataset.nonce;
    fetch('load.php?id=FormBuilderPro', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'fb_action=duplicate_form&id=' + id + '&fb_nonce=' + encodeURIComponent(nonce)
    })
    .then(r => r.json())
    .then(d => {
        if (d && d.ok) {
            // Insert new row at top of table body
            const tbody = document.querySelector('.fb-table tbody');
            if (tbody) {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><strong>${escH(d.name)}</strong></td>
                    <td><span class="fb-slug">${escH(d.slug)}</span></td>
                    <td>${d.fields}</td>
                    <td>${escH(d.created)}</td>
                    <td style="text-align:right;white-space:nowrap">
                        <a class="btn btn-edit btn-sm" href="load.php?id=FormBuilderPro&fb_view=edit&form_id=${d.id}">
                            <svg width="1em" height="1em" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><g fill="currentColor"><path d="M8 7a1 1 0 0 1-1 1H6a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h9a1 1 0 0 0 1-1v-1a1 1 0 0 1 2 0v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V9a3 3 0 0 1 3-3h1a1 1 0 0 1 1 1"/><path d="m14.596 5.011 4.392 4.392-6.28 6.303A1 1 0 0 1 12 16H9a1 1 0 0 1-1-1v-3a1 1 0 0 1 .294-.708zm6.496-2.103a3.097 3.097 0 0 1 .165 4.203l-.164.18-.693.694-4.387-4.387.695-.69a3.1 3.1 0 0 1 4.384 0"/></g></svg>
                            Edit
                        </a>
                        <button class="btn btn-ghost btn-sm" onclick="fbDuplicateForm(${d.id}, ${JSON.stringify(d.name)})">
                            <svg width="1em" height="1em" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M16 1H4a2 2 0 0 0-2 2v14h2V3h12zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2m0 16H8V7h11z" fill="currentColor"/></svg>
                            Duplicate
                        </button>
                        <button class="btn btn-ghost btn-sm" onclick="fbViewSubmissions(${d.id}, ${JSON.stringify(d.name)})">
                            Submissions
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="fbDeleteForm(${d.id}, ${JSON.stringify(d.name)})">
                            <svg width="1em" height="1em" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6z" fill="currentColor"/></svg>
                            Delete
                        </button>
                    </td>`;
                tbody.insertBefore(newRow, tbody.firstChild);
                // Highlight briefly
                newRow.style.background = '#eef3fd';
                setTimeout(() => newRow.style.transition = 'background 1s', 50);
                setTimeout(() => newRow.style.background = '', 1000);
            }
            fbToast('Form duplicated');
        } else {
            fbToast('Duplicate failed', 'error');
        }
    })
    .catch(() => fbToast('Duplicate failed', 'error'));
}

function fbDeleteForm(id, name) {
    if (!confirm('Delete "' + name + '" and all its submissions?')) return;
    const nonce = document.getElementById('fb-app').dataset.nonce;
    fetch('load.php?id=FormBuilderPro', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'fb_action=delete_form&id=' + id + '&fb_nonce=' + encodeURIComponent(nonce)
    })
    .then(r => r.json())
    .then(d => {
        if (d && d.ok) {
            const btn = document.querySelector(`button[onclick*="fbDeleteForm(${id},"]`);
            if (btn) {
                const row = btn.closest('tr');
                if (row) {
                    row.style.transition = 'opacity .2s';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        const tbody = document.querySelector('.fb-table tbody');
                        if (tbody && !tbody.querySelector('tr')) {
                            document.querySelector('.fb-table').remove();
                            const empty = document.createElement('div');
                            empty.className = 'fb-empty';
                            empty.textContent = 'No forms yet. Create your first form to get started.';
                            document.getElementById('fb-app').appendChild(empty);
                        }
                    }, 200);
                }
            }
            fbToast('Form deleted');
        } else {
            fbToast('Delete failed', 'error');
        }
    })
    .catch(() => fbToast('Delete failed', 'error'));
}

function fbViewSubmissions(formId, formName) {
    document.getElementById('fb-modal-title').textContent = 'Submissions — ' + formName;
    document.getElementById('fb-modal-body').innerHTML =
        '<p style="color:var(--text-muted);font-size:.875rem;padding:1rem">Loading…</p>';
    document.getElementById('fb-modal-bg').classList.add('open');

    const nonce = document.getElementById('fb-app').dataset.nonce;
    fetch('load.php?id=FormBuilderPro&fb_action=get_submissions&form_id=' + formId + '&fb_nonce=' + encodeURIComponent(nonce))
        .then(r => r.json())
        .then(d => {
            const body = document.getElementById('fb-modal-body');
            if (!d.ok || !d.rows.length) {
                body.innerHTML = '<p style="text-align:center;color:var(--text-muted);font-size:.875rem;padding:2rem">No submissions yet.</p>';
                return;
            }
            body.innerHTML = d.rows.map(row => {
                const data   = JSON.parse(row.data || '{}');
                const dt     = new Date(row.submitted * 1000).toLocaleString();
                const fields = Object.entries(data)
                    .map(([k, v]) => {
                        // File values stored as "safe|original|token"
                        const parts = v.split('|');
                        let display;
                        if (parts.length === 3) {
                            const original = parts[1];
                            const token    = parts[2];
                            const url      = FB_DOWNLOAD_BASE + encodeURIComponent(token);
                            display = `<a href="${url}" style="color:var(--accent);text-decoration:none;display:inline-flex;align-items:center;gap:.3rem">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M6 1v7M3 5l3 3 3-3M1 9v1a1 1 0 001 1h8a1 1 0 001-1V9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                ${escH(original)}</a>`;
                        } else if (parts.length === 2) {
                            const url = 'load.php?id=FormBuilderPro&fb_action=download_file&file=' + encodeURIComponent(parts[0]) + '&fb_nonce=' + encodeURIComponent(nonce);
                            display = `<a href="${url}" style="color:var(--accent);text-decoration:none">${escH(parts[1])}</a>`;
                        } else {
                            display = escH(v);
                        }
                        return `<dt>${escH(k)}</dt><dd>${display}</dd>`;
                    })
                    .join('');
                return `<div class="fb-sub-row">
                    <div class="fb-sub-meta">#${row.id} · ${dt} · ${escH(row.ip)}</div>
                    <dl class="fb-sub-data">${fields}</dl>
                </div>`;
            }).join('');
        })
        .catch(() => {
            document.getElementById('fb-modal-body').innerHTML =
                '<p style="color:var(--danger);padding:1rem">Failed to load submissions.</p>';
        });
}

function fbCloseModal() {
    document.getElementById('fb-modal-bg').classList.remove('open');
}
document.getElementById('fb-modal-bg').addEventListener('click', e => {
    if (e.target === e.currentTarget) fbCloseModal();
});

function escH(s) {
    return String(s)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

// ── View switching ────────────────────────────────────────────────────
function fbListView(name) {
    document.querySelectorAll('.fb-tab[data-view]').forEach(t =>
        t.classList.toggle('active', t.dataset.view === name)
    );
    document.getElementById('view-forms').style.display = name === 'forms' ? '' : 'none';
    document.getElementById('view-files').style.display = name === 'files' ? '' : 'none';
    if (name === 'files') fbLoadFiles();
}

// ── Files tab ─────────────────────────────────────────────────────────
let fbFilesLoaded = false;

function fbLoadFiles() {
    if (fbFilesLoaded) return;
    fbFilesLoaded = true;
    const nonce = document.getElementById('fb-app').dataset.nonce;
    fetch('load.php?id=FormBuilderPro&fb_action=get_files&fb_nonce=' + encodeURIComponent(nonce))
        .then(r => r.json())
        .then(d => {
            const body = document.getElementById('fb-files-body');
            if (!d.ok || !d.rows.length) {
                body.innerHTML = '<p style="text-align:center;padding:2rem;color:var(--text-muted)">No uploaded files found.</p>';
                return;
            }
            const fmt = n => n >= 1048576 ? (n/1048576).toFixed(1)+' MB' : n >= 1024 ? (n/1024).toFixed(0)+' KB' : n+' B';
            body.innerHTML = `<table class="fb-table">
                <thead><tr>
                    <th>File</th><th>Form</th><th>Size</th><th>Uploaded</th><th></th>
                </tr></thead>
                <tbody>` +
                d.rows.map(r => `<tr id="fb-file-row-${escH(r.token)}">
                    <td>
                        <a href="${FB_DOWNLOAD_BASE}${encodeURIComponent(r.token)}" style="color:var(--accent)">
                            ${escH(r.original_filename)}
                        </a>
                        ${!r.exists ? '<span style="color:var(--danger);font-size:.75rem"> (missing)</span>' : ''}
                    </td>
                    <td style="font-size:.8rem;color:var(--text-muted)">${escH(r.form_name || 'Unknown')}</td>
                    <td style="font-size:.8rem">${fmt(r.size)}</td>
                    <td style="font-size:.8rem;color:var(--text-muted)">${new Date(r.created*1000).toLocaleDateString()}</td>
                    <td style="text-align:right">
                        <button class="btn btn-danger btn-sm"
                                onclick="fbDeleteFile(${JSON.stringify(r.token)}, ${JSON.stringify(r.original_filename)})">
                            <svg width="1em" height="1em" viewBox="0 0 24 24"><path d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6z" fill="currentColor"/></svg>
                            Delete
                        </button>
                    </td>
                </tr>`).join('') +
                `</tbody></table>`;
        })
        .catch(() => {
            document.getElementById('fb-files-body').innerHTML = '<p style="color:var(--danger);padding:1rem">Failed to load files.</p>';
        });
}

function fbDeleteFile(token, name) {
    if (!confirm('Delete "' + name + '"? This cannot be undone.')) return;
    const nonce = document.getElementById('fb-app').dataset.nonce;
    fetch('load.php?id=FormBuilderPro', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'fb_action=delete_file&token=' + encodeURIComponent(token) + '&fb_nonce=' + encodeURIComponent(nonce)
    })
    .then(r => r.json())
    .then(d => {
        if (d && d.ok) {
            const row = document.getElementById('fb-file-row-' + token);
            if (row) {
                row.style.transition = 'opacity .2s';
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 200);
            }
            fbToast('File deleted');
        } else {
            fbToast('Delete failed', 'error');
        }
    })
    .catch(() => fbToast('Delete failed', 'error'));
}
</script>