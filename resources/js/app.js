import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';
import Swal from 'sweetalert2';
import $ from 'jquery';
import select2 from 'select2';

// Initialize Select2 onto jQuery
select2($);

window.$ = window.jQuery = $;
window.Alpine = Alpine;
window.Swal = Swal;

// Ultra-Luxury Bespoke SweetAlert2 Alert Suite (Center-Positioned, Bespoke Jewel Badges)
window.AzkaAlert = {
    /**
     * Show luxury confirmation modal for destructive/delete actions
     */
    confirmDelete: function(options = {}) {
        const badgeSvg = `
            <div class="w-16 h-16 mx-auto mb-3.5 rounded-2xl bg-amber-500/10 border border-amber-500/25 text-amber-600 flex items-center justify-center shadow-lg shadow-amber-500/10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
        `;
        return Swal.fire({
            position: 'center',
            title: options.title || 'Hapus Data Ini?',
            html: `${badgeSvg}<div class="azka-swal-text">${options.text || 'Data yang dihapus akan hilang secara permanen dan tidak dapat dikembalikan!'}</div>`,
            showCancelButton: true,
            confirmButtonText: options.confirmText || 'Ya, Hapus Data',
            cancelButtonText: options.cancelText || 'Batalkan',
            reverseButtons: true,
            focusCancel: true,
            customClass: {
                popup: 'azka-swal-luxury-modal',
                title: 'azka-swal-title',
                confirmButton: 'azka-btn-danger',
                cancelButton: 'azka-btn-secondary',
                actions: 'azka-swal-actions'
            },
            buttonsStyling: false
        });
    },

    /**
     * Show luxury confirmation modal for general actions
     */
    confirmAction: function(options = {}) {
        const badgeSvg = `
            <div class="w-16 h-16 mx-auto mb-3.5 rounded-2xl bg-[#D6A84F]/10 border border-[#D6A84F]/30 text-[#D6A84F] flex items-center justify-center shadow-lg shadow-[#D6A84F]/10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        `;
        return Swal.fire({
            position: 'center',
            title: options.title || 'Konfirmasi Tindakan',
            html: `${badgeSvg}<div class="azka-swal-text">${options.text || 'Apakah Anda yakin ingin melanjutkan tindakan ini?'}</div>`,
            showCancelButton: true,
            confirmButtonText: options.confirmText || 'Ya, Lanjutkan',
            cancelButtonText: options.cancelText || 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'azka-swal-luxury-modal',
                title: 'azka-swal-title',
                confirmButton: 'azka-btn-primary',
                cancelButton: 'azka-btn-secondary',
                actions: 'azka-swal-actions'
            },
            buttonsStyling: false
        });
    },

    /**
     * Show luxury success modal in Center with emerald jewel badge
     */
    success: function(title, text = '') {
        const badgeSvg = `
            <div class="w-16 h-16 mx-auto mb-3.5 rounded-2xl bg-emerald-500/10 border border-emerald-500/25 text-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/15">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        `;
        return Swal.fire({
            position: 'center',
            title: title || 'Berhasil Disimpan!',
            html: `${badgeSvg}<div class="azka-swal-text">${text}</div>`,
            confirmButtonText: 'Selesai',
            timer: 3500,
            timerProgressBar: true,
            customClass: {
                popup: 'azka-swal-luxury-modal',
                title: 'azka-swal-title',
                confirmButton: 'azka-btn-primary',
                actions: 'azka-swal-actions'
            },
            buttonsStyling: false
        });
    },

    /**
     * Show luxury error modal in Center with ruby jewel badge
     */
    error: function(title, text = '') {
        const badgeSvg = `
            <div class="w-16 h-16 mx-auto mb-3.5 rounded-2xl bg-rose-500/10 border border-rose-500/25 text-rose-600 flex items-center justify-center shadow-lg shadow-rose-500/15">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        `;
        return Swal.fire({
            position: 'center',
            title: title || 'Perhatian',
            html: `${badgeSvg}<div class="azka-swal-text">${text}</div>`,
            confirmButtonText: 'Tutup',
            customClass: {
                popup: 'azka-swal-luxury-modal',
                title: 'azka-swal-title',
                confirmButton: 'azka-btn-danger',
                actions: 'azka-swal-actions'
            },
            buttonsStyling: false
        });
    }
};

window.renderIcons = () => {
    createIcons({ icons });
};

// Initialize Select2 with luxury theme on all relevant select elements
window.initSelect2 = function(context = document) {
    if (!window.$) return;
    $(context).find('select.select2, select:not(.no-select2)').each(function() {
        const $el = $(this);
        if ($el.hasClass('select2-hidden-accessible')) {
            return;
        }
        
        // Find if select is inside an Alpine modal
        const modalParent = $el.closest('[x-show], .azka-modal, .modal-dialog');
        const dropdownParent = modalParent.length ? modalParent : $(document.body);

        $el.select2({
            width: '100%',
            dropdownParent: dropdownParent,
            language: {
                noResults: function() {
                    return 'Tidak ada hasil yang cocok';
                }
            }
        });

        // Trigger change event for Alpine/native bindings
        $el.on('change.select2', function() {
            const event = new Event('change', { bubbles: true });
            this.dispatchEvent(event);
        });
    });
};

// Interactive Top Progress Bar & Async Loading Controller
window.AzkaLoading = {
    bar: null,
    progress: 0,
    timer: null,

    init: function() {
        if (!this.bar) {
            let el = document.getElementById('azka-top-loader');
            if (!el) {
                el = document.createElement('div');
                el.id = 'azka-top-loader';
                el.style.cssText = 'position:fixed;top:0;left:0;height:3.5px;width:0%;background:linear-gradient(90deg, #D6A84F, #172B4D, #D6A84F);background-size:200% 100%;box-shadow:0 0 12px rgba(214,168,79,0.85);z-index:999999;transition:width 0.25s ease, opacity 0.4s ease;pointer-events:none;opacity:0;';
                document.body.appendChild(el);
            }
            this.bar = el;
        }
    },

    start: function() {
        this.init();
        if (this.timer) clearInterval(this.timer);
        this.progress = 25;
        this.bar.style.opacity = '1';
        this.bar.style.width = this.progress + '%';

        this.timer = setInterval(() => {
            if (this.progress < 85) {
                this.progress += Math.random() * 12;
                if (this.progress > 85) this.progress = 85;
                if (this.bar) this.bar.style.width = this.progress + '%';
            }
        }, 180);
    },

    set: function(val) {
        this.init();
        this.progress = val;
        if (this.bar) {
            this.bar.style.opacity = '1';
            this.bar.style.width = val + '%';
        }
    },

    done: function() {
        this.init();
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
        if (this.bar) {
            this.bar.style.width = '100%';
            setTimeout(() => {
                if (this.bar) this.bar.style.opacity = '0';
                setTimeout(() => {
                    if (this.bar) this.bar.style.width = '0%';
                }, 300);
            }, 250);
        }
    }
};

// Global Asynchronous Interceptors (Fetch API & XMLHttpRequest)
if (typeof window !== 'undefined') {
    // 1. Fetch API Interceptor
    const originalFetch = window.fetch;
    if (originalFetch) {
        window.fetch = async function(...args) {
            window.AzkaLoading.start();
            try {
                const response = await originalFetch.apply(this, args);
                window.AzkaLoading.done();
                return response;
            } catch (error) {
                window.AzkaLoading.done();
                throw error;
            }
        };
    }

    // 2. XMLHttpRequest Interceptor
    const originalXHR = window.XMLHttpRequest;
    if (originalXHR) {
        const origOpen = originalXHR.prototype.open;
        const origSend = originalXHR.prototype.send;
        originalXHR.prototype.open = function(...args) {
            this._azkaTracked = true;
            return origOpen.apply(this, args);
        };
        originalXHR.prototype.send = function(...args) {
            if (this._azkaTracked) {
                window.AzkaLoading.start();
                this.addEventListener('loadend', () => {
                    window.AzkaLoading.done();
                });
            }
            return origSend.apply(this, args);
        };
    }
}

// Show button loading spinner and prevent duplicate submissions
function applyButtonLoading(form) {
    if (!form || form.getAttribute('target') === '_blank') return;
    const submitBtn = form.querySelector('button[type="submit"]:not([disabled])');
    if (submitBtn) {
        submitBtn.dataset.originalHtml = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-75', 'cursor-wait');

        const spinnerSvg = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 inline-block text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        `;

        const labelSpan = submitBtn.querySelector('span');
        if (labelSpan) {
            labelSpan.innerText = 'Memproses...';
            submitBtn.insertAdjacentHTML('afterbegin', spinnerSvg);
        } else {
            submitBtn.innerHTML = `${spinnerSvg} <span>Memproses...</span>`;
        }
    }
}

// Trigger SweetAlert2 delete confirmation for a form
window.triggerDeleteConfirm = function(form) {
    if (!form || form.dataset.confirmed === 'true') {
        return;
    }

    let customText = form.getAttribute('data-confirm');
    const onsubmitAttr = form.getAttribute('onsubmit') || '';
    if (!customText && onsubmitAttr) {
        const match = onsubmitAttr.match(/confirm\(['"](.*?)['"]\)/);
        if (match && match[1]) {
            customText = match[1];
        }
    }

    window.AzkaAlert.confirmDelete({
        title: 'Konfirmasi Penghapusan',
        text: customText || 'Apakah Anda yakin ingin menghapus data ini secara permanen?'
    }).then((result) => {
        if (result.isConfirmed) {
            form.dataset.confirmed = 'true';
            form.onsubmit = null;
            window.AzkaLoading.start();
            applyButtonLoading(form);
            form.submit();
        }
    });
};

// Auto intercept delete actions, flash messages in center, and initialize select2
document.addEventListener('DOMContentLoaded', () => {
    window.renderIcons();
    window.initSelect2();
    window.AzkaLoading.init();

    // Check for flash messages in DOM and display in the CENTER of the page
    const flashSuccess = document.querySelector('[data-flash-success]');
    if (flashSuccess && flashSuccess.dataset.flashSuccess) {
        window.AzkaAlert.success('Berhasil Disimpan!', flashSuccess.dataset.flashSuccess);
    }

    const flashError = document.querySelector('[data-flash-error]');
    if (flashError && flashError.dataset.flashError) {
        window.AzkaAlert.error('Pemberitahuan', flashError.dataset.flashError);
    }

    // Intercept delete clicks directly on buttons (.delete-confirm or buttons in delete forms)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.delete-confirm, [data-delete-btn]');
        if (btn) {
            const form = btn.closest('form');
            if (form) {
                e.preventDefault();
                e.stopPropagation();
                window.triggerDeleteConfirm(form);
            }
        }
    }, true);

    // Intercept form submissions
    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (!form || form.tagName !== 'FORM') return;

        const methodInput = form.querySelector('input[name="_method"][value="DELETE"]');
        const hasConfirmAttr = form.hasAttribute('data-confirm') || form.classList.contains('form-delete');
        const onsubmitAttr = form.getAttribute('onsubmit') || '';
        const isDeleteAction = methodInput || hasConfirmAttr || onsubmitAttr.includes('confirm(');

        if (isDeleteAction) {
            if (form.dataset.confirmed === 'true') {
                return;
            }

            e.preventDefault();
            e.stopImmediatePropagation();
            window.triggerDeleteConfirm(form);
            return;
        }

        // Standard non-DELETE form submit (e.g. Save, Update, Filter)
        if (form.getAttribute('target') !== '_blank') {
            window.AzkaLoading.start();
            // Apply button loading if method is POST/PUT/PATCH
            const isMutation = form.method.toUpperCase() === 'POST' || form.querySelector('input[name="_method"]');
            if (isMutation) {
                applyButtonLoading(form);
            }
        }
    }, true);

    // Global navigation feedback on standard internal links
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link) return;
        const href = link.getAttribute('href');
        const target = link.getAttribute('target');
        if (
            href && 
            !href.startsWith('#') && 
            !href.startsWith('javascript:') && 
            !link.hasAttribute('download') && 
            target !== '_blank' && 
            !e.ctrlKey && !e.metaKey && !e.shiftKey
        ) {
            window.AzkaLoading.start();
        }
    });

    window.addEventListener('pageshow', () => {
        window.AzkaLoading.done();
    });
});

Alpine.start();
