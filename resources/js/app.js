import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);

window.Alpine = Alpine;

Alpine.data('eventForm', () => ({
    steps: ['Details', 'Schedule', 'Sponsorship', 'Review'],
    currentStep: 0,
    eventId: null,
    saving: false,
    draftSaved: false,
    submitting: false,
    autosaveTimer: null,

    form: {
        title: '',
        tagline: '',
        description: '',
        category_id: '',
        event_type: '',
        start_date: '',
        end_date: '',
        expected_audience: '',
        tags: '',
        sponsorship_type: '',
        budget_min: '',
        budget_max: '',
        sponsor_levels: [],
        video_url: '',
        plan: 'basic',
        audience_age_groups: [],
        audience_gender: [],
        audience_income: [],
        audience_industries: [],
        audience_reach: '',
        audience_description: '',
        dates: [],
        venues: [],
        participants: [],
        same_time_all: false,
        common_start_time: '',
        common_end_time: '',
        common_timezone: 'Asia/Kolkata',
        common_all_day: false,
    },

    packages: [],
    files: { logo: null, cover_image: null, banner_image: null },
    previews: { logo: null, cover_image: null, banner_image: null },
    errors: {},

    init() {
        this.addDate();
        this.addVenue();
        this.restoreDraft();
        this.loadServerDraft();
        this.autosaveTimer = setInterval(() => { this.autosave(); }, 10000);
    },

    toggleLevel(level) {
        const levels = this.form.sponsor_levels || [];
        const idx = levels.indexOf(level);
        if (idx === -1) { levels.push(level); } else { levels.splice(idx, 1); }
        this.form.sponsor_levels = [...levels];
        this.autosave();
    },

    fileSelected(event, key) {
        const file = event.target.files[0];
        if (!file) return;
        this.files[key] = file;
        const reader = new FileReader();
        reader.onload = (e) => { this.previews[key] = e.target.result; };
        reader.readAsDataURL(file);
    },

    validateStep(step) {
        const e = {};
        if (step === 0) {
            if (!this.form.title?.trim()) e.title = 'Title is required.';
            if (!this.form.description?.trim()) e.description = 'Description is required.';
            if (!this.form.category_id) e.category_id = 'Category is required.';
            if (!this.form.event_type) e.event_type = 'Event type is required.';
            if (!this.form.start_date) e.start_date = 'Start date is required.';
            if (!this.form.end_date) e.end_date = 'End date is required.';
            if (this.form.start_date && this.form.end_date && this.form.start_date > this.form.end_date) {
                e.end_date = 'End date must be after start date.';
            }
        } else if (step === 1) {
            if (this.form.dates.length === 0) e.dates = 'Add at least one date.';
            this.form.dates.forEach((dt, i) => {
                if (!dt.start_date) e['dates.' + i + '.start_date'] = 'Start date is required for session ' + (i + 1);
            });
            if (this.form.venues.length === 0) e.venues = 'Add at least one venue.';
        } else if (step === 3) {
            if (!this.form.plan) e.plan = 'Please select a plan.';
        }
        this.errors = e;
        return Object.keys(e).length === 0;
    },

    nextStep() {
        if (this.validateStep(this.currentStep)) {
            this.currentStep = Math.min(this.currentStep + 1, this.steps.length - 1);
        }
    },

    prevStep() {
        this.currentStep = Math.max(this.currentStep - 1, 0);
    },

    goTo(step) {
        if (step <= this.currentStep) { this.currentStep = step; return; }
        let valid = true;
        for (let i = this.currentStep; i < step; i++) {
            if (!this.validateStep(i)) { valid = false; break; }
        }
        if (valid) this.currentStep = step;
    },

    addDate() {
        this.form.dates.push({
            label: '', start_date: '', end_date: '', start_time: '', end_time: '',
            timezone: 'Asia/Kolkata', all_day: false, sort_order: this.form.dates.length,
        });
    },

    removeDate(idx) {
        this.form.dates.splice(idx, 1);
        this.form.dates.forEach((dt, i) => dt.sort_order = i);
    },

    toggleSameTime() {
        if (this.form.same_time_all && this.form.dates.length > 0) {
            const first = this.form.dates[0];
            this.form.common_start_time = first.start_time || '';
            this.form.common_end_time = first.end_time || '';
            this.form.common_timezone = first.timezone || 'Asia/Kolkata';
            this.form.common_all_day = first.all_day || false;
        }
    },

    addVenue() {
        this.form.venues.push({
            venue_type: 'physical', venue_name: '', address: '', city: '', state: '',
            country: 'India', virtual_url: '', virtual_platform: '',
            is_primary: this.form.venues.length === 0, sort_order: this.form.venues.length,
        });
    },

    addParticipant() {
        this.form.participants.push({
            name: '', participant_type_id: '', role_label: '', session_title: '',
            bio: '', organization: '', designation: '', sort_order: this.form.participants.length,
        });
    },

    addPackage() {
        this.packages.push({ name: '', price: 0, description: '', benefits_text: '', slots_available: 1 });
    },

    removePackage(idx) {
        this.packages.splice(idx, 1);
    },

    formatDate(dateStr) {
        if (!dateStr) return '';
        const d = new Date(dateStr + 'T00:00:00');
        return d.toLocaleDateString('en-US', { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
    },

    buildFormData() {
        const payload = new FormData();
        payload.append('_token', document.querySelector('input[name="_token"]').value);
        if (this.eventId) payload.append('event_id', this.eventId);

        const scalarFields = ['title', 'tagline', 'description', 'category_id', 'event_type',
            'start_date', 'end_date', 'expected_audience', 'tags', 'sponsorship_type',
            'budget_min', 'budget_max', 'video_url', 'plan',
            'audience_description', 'audience_reach'];
        scalarFields.forEach(f => {
            if (this.form[f] !== null && this.form[f] !== undefined && this.form[f] !== '') {
                payload.append(f, this.form[f]);
            }
        });

        ['audience_age_groups', 'audience_gender', 'audience_income', 'audience_industries', 'sponsor_levels'].forEach(key => {
            const arr = this.form[key] || [];
            arr.forEach(v => payload.append(key + '[]', v));
        });

        this.form.dates.forEach((dt, i) => {
            Object.entries(dt).forEach(([k, v]) => {
                if (v !== null && v !== undefined && v !== '') {
                    payload.append('dates[' + i + '][' + k + ']', v);
                }
            });
            if (this.form.same_time_all) {
                payload.append('dates[' + i + '][start_time]', this.form.common_start_time);
                payload.append('dates[' + i + '][end_time]', this.form.common_end_time);
                payload.append('dates[' + i + '][timezone]', this.form.common_timezone);
                payload.append('dates[' + i + '][all_day]', this.form.common_all_day);
            }
        });

        this.form.venues.forEach((v, i) => {
            Object.entries(v).forEach(([k, val]) => {
                if (val !== null && val !== undefined && val !== '') {
                    payload.append('venues[' + i + '][' + k + ']', val);
                }
            });
        });

        this.form.participants.forEach((p, i) => {
            Object.entries(p).forEach(([k, v]) => {
                if (v !== null && v !== undefined && v !== '') {
                    payload.append('participants[' + i + '][' + k + ']', v);
                }
            });
        });

        this.packages.forEach((pkg, i) => {
            if (pkg.name) {
                payload.append('packages[' + i + '][name]', pkg.name);
                if (pkg.price) payload.append('packages[' + i + '][price]', pkg.price);
                if (pkg.description) payload.append('packages[' + i + '][description]', pkg.description);
                if (pkg.benefits_text) payload.append('packages[' + i + '][benefits]', pkg.benefits_text);
                if (pkg.slots_available) payload.append('packages[' + i + '][slots_available]', pkg.slots_available);
            }
        });

        Object.entries(this.files).forEach(([key, file]) => {
            if (file) payload.append(key, file);
        });

        return payload;
    },

    autosave() {
        if (this.saving) return;
        this.saving = true;
        fetch('/organizer/events/save-draft', {
            method: 'POST',
            body: this.buildFormData(),
            headers: { 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { this.eventId = data.event_id; this.draftSaved = true; this.saveToLocalStorage(); }
        })
        .catch(() => {})
        .finally(() => { this.saving = false; });
    },

    saveToLocalStorage() {
        try {
            localStorage.setItem('event_draft', JSON.stringify({
                form: this.form,
                packages: this.packages,
                eventId: this.eventId,
            }));
        } catch (e) {}
    },

    restoreDraft() {
        try {
            const raw = localStorage.getItem('event_draft');
            if (raw) {
                const data = JSON.parse(raw);
                if (data.form) Object.assign(this.form, data.form);
                if (data.packages) this.packages = data.packages;
                if (data.eventId) this.eventId = data.eventId;
            }
        } catch (e) {}
    },

    loadServerDraft() {
        fetch('/organizer/events/load-draft', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success && data.data) {
                const d = data.data;
                this.eventId = d.id;
                const fields = ['title','tagline','description','category_id','event_type','start_date','end_date',
                    'expected_audience','budget_min','budget_max','sponsorship_type','tags',
                    'video_url','plan','audience_description','audience_reach'];
                fields.forEach(f => { if (d[f] !== null && d[f] !== undefined) this.form[f] = d[f]; });
                if (d.sponsor_levels) this.form.sponsor_levels = d.sponsor_levels;
                if (d.packages) this.packages = d.packages.map(p => ({
                    name: p.title || p.name, price: p.price, description: p.description,
                    benefits_text: Array.isArray(p.benefits) ? p.benefits.map(b => b.benefit_text || b).join('\n') : (p.benefits_text || ''),
                    slots_available: p.slots_available,
                }));
                if (d.dates && d.dates.length) this.form.dates = d.dates;
                if (d.venues && d.venues.length) this.form.venues = d.venues;
                if (d.participants && d.participants.length) this.form.participants = d.participants;
                this.draftSaved = true;
            }
        })
        .catch(() => {});
    },

    clearDraft() {
        if (this.eventId) {
            fetch('/organizer/events/' + this.eventId + '/discard-draft', {
                method: 'DELETE',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value }
            }).catch(() => {});
        }
        localStorage.removeItem('event_draft');
        this.eventId = null;
        this.draftSaved = false;
        for (const key in this.form) {
            if (Array.isArray(this.form[key])) {
                this.form[key] = [];
            } else {
                this.form[key] = '';
            }
        }
        this.form.plan = 'basic';
        this.form.same_time_all = false;
        this.form.common_start_time = '';
        this.form.common_end_time = '';
        this.form.common_timezone = 'Asia/Kolkata';
        this.form.common_all_day = false;
        this.packages = [];
        this.files = { logo: null, cover_image: null, banner_image: null };
        this.previews = { logo: null, cover_image: null, banner_image: null };
        this.errors = {};
        this.addDate();
        this.addVenue();
    },

    submit() {
        if (this.submitting) return;
        if (!this.validateStep(0)) { this.currentStep = 0; return; }
        if (!this.validateStep(1)) { this.currentStep = 1; return; }
        if (!this.validateStep(3)) { this.currentStep = 3; return; }
        this.submitting = true;
        localStorage.removeItem('event_draft');

        const payload = this.buildFormData();
        fetch('/organizer/events', {
            method: 'POST',
            body: payload,
            headers: { 'Accept': 'text/html, application/xhtml+xml' }
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
            } else if (response.ok) {
                window.location.href = '/organizer/events';
            } else {
                return response.text().then(text => {
                    const match = text.match(/<title>(.*?)<\/title>/i);
                    this.errors = { submit: 'Submission failed. Please check all fields.' };
                    this.submitting = false;
                });
            }
        })
        .catch(() => {
            this.errors = { submit: 'Network error. Please try again.' };
            this.submitting = false;
        });
    }
}));

Alpine.start();
