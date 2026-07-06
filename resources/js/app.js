import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);

window.Alpine = Alpine;

Alpine.data('wizard', () => ({
    steps: ['Basic Info', 'Dates', 'Venues', 'Sponsorship', 'Packages', 'Audience', 'Media', 'Participants', 'Plan', 'Review'],
    currentStep: 0,
    completedSteps: [],
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
        website_url: '',
        registration_deadline: '',
        expected_audience: '',
        budget_min: '',
        budget_max: '',
        sponsorship_type: '',
        tags: '',
        audience_description: '',
        video_url: '',
        plan: 'basic',
        sponsor_levels: [],
        audience_age_groups: [],
        audience_gender: [],
        audience_income: [],
        audience_industries: [],
        audience_reach: '',
        dates: [],
        venues: [],
        participants: [],
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
        this.form.sponsor_levels = levels;
        this.autosave();
    },

    fileSelected(event, key) {
        const file = event.target.files[0];
        if (!file) return;
        this.files[key] = file;
        const reader = new FileReader();
        reader.onload = (e) => { this.previews[key] = e.target.result; };
        reader.readAsDataURL(file);
        this.errors[key] = null;
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
        } else if (step === 2) {
            if (this.form.venues.length === 0) e.venues = 'Add at least one venue.';
        } else if (step === 3) {
            if (!this.form.expected_audience) e.expected_audience = 'Expected audience is required.';
        } else if (step === 5) {
            if (this.form.audience_age_groups.length === 0) e.audience_age_groups = 'Select at least one age group.';
        } else if (step === 8) {
            if (!this.form.plan) e.plan = 'Please select a plan.';
        }
        this.errors = e;
        return Object.keys(e).length === 0;
    },

    nextStep() {
        if (this.validateStep(this.currentStep)) {
            if (!this.completedSteps.includes(this.currentStep)) {
                this.completedSteps.push(this.currentStep);
            }
            this.currentStep = Math.min(this.currentStep + 1, this.steps.length - 1);
        }
    },

    prevStep() {
        this.currentStep = Math.max(this.currentStep - 1, 0);
    },

    goTo(step) {
        if (step <= this.currentStep) {
            this.currentStep = step;
            return;
        }
        let valid = true;
        for (let i = this.currentStep; i < step; i++) {
            if (!this.validateStep(i)) { valid = false; break; }
        }
        if (valid) {
            for (let i = this.currentStep; i < step; i++) {
                if (!this.completedSteps.includes(i)) this.completedSteps.push(i);
            }
            this.currentStep = step;
        }
    },

    addDate() {
        this.form.dates.push({
            label: '', start_date: '', end_date: '', start_time: '', end_time: '',
            timezone: 'Asia/Kolkata', all_day: false, sort_order: this.form.dates.length,
        });
    },

    addVenue() {
        this.form.venues.push({
            venue_type: 'physical', venue_name: '', address: '', city: '', state: '',
            country: 'India', postal_code: '', latitude: '', longitude: '',
            virtual_url: '', virtual_platform: '', is_primary: this.form.venues.length === 0, sort_order: this.form.venues.length,
        });
    },

    addParticipant() {
        this.form.participants.push({
            name: '', participant_type_id: '', role_label: '', session_title: '',
            bio: '', organization: '', designation: '', sort_order: this.form.participants.length,
        });
    },

    addPackage() {
        this.packages.push({
            name: '', price: 0, description: '', benefits_text: '', slots_available: 1,
        });
        this.$nextTick(() => {
            const container = this.$refs.packagesContainer;
            if (container) container.scrollTop = container.scrollHeight;
        });
    },

    removePackage(idx) {
        this.packages.splice(idx, 1);
    },

    autosave() {
        if (this.saving) return;
        const payload = new FormData();
        payload.append('_token', document.querySelector('input[name="_token"]').value);
        if (this.eventId) payload.append('event_id', this.eventId);

        for (const [key, val] of Object.entries(this.form)) {
            if (Array.isArray(val)) {
                if (key === 'dates' || key === 'venues' || key === 'participants') {
                    val.forEach((item, i) => {
                        for (const [k, v] of Object.entries(item)) {
                            if (v !== null && v !== undefined && v !== '') {
                                payload.append(key + '[' + i + '][' + k + ']', v);
                            }
                        }
                    });
                } else {
                    val.forEach(v => payload.append(key + '[]', v));
                }
            } else if (val !== null && val !== undefined && val !== '') {
                payload.append(key, val);
            }
        }

        if (this.packages.length > 0) {
            this.packages.forEach((pkg, i) => {
                if (pkg.name) {
                    payload.append('packages[' + i + '][name]', pkg.name);
                    if (pkg.price) payload.append('packages[' + i + '][price]', pkg.price);
                    if (pkg.description) payload.append('packages[' + i + '][description]', pkg.description);
                    if (pkg.benefits_text) payload.append('packages[' + i + '][benefits]', pkg.benefits_text);
                    if (pkg.slots_available) payload.append('packages[' + i + '][slots_available]', pkg.slots_available);
                }
            });
        }

        for (const [key, file] of Object.entries(this.files)) {
            if (file) payload.append(key, file);
        }

        this.saving = true;
        fetch('/organizer/events/save-draft', {
            method: 'POST', body: payload, headers: { 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { this.eventId = data.event_id; this.draftSaved = true; this.saveToLocalStorage(); }
        })
        .catch(() => {})
        .finally(() => { this.saving = false; });
    },

    saveToLocalStorage() {
        try { localStorage.setItem('event_draft', JSON.stringify({ form: this.form, packages: this.packages, eventId: this.eventId })); } catch (e) {}
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
                    'website_url','registration_deadline','expected_audience','budget_min','budget_max',
                    'sponsorship_type','tags','audience_description','video_url','plan',
                    'audience_age_groups','audience_gender','audience_income','audience_industries','audience_reach'];
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
                this.form[key] = key === 'dates' ? [] : (key === 'venues' ? [] : (key === 'participants' ? [] : []));
            } else {
                this.form[key] = '';
            }
        }
        this.form.country = 'India';
        this.form.plan = 'basic';
        this.packages = [];
        this.files = { logo: null, cover_image: null, banner_image: null };
        this.previews = { logo: null, cover_image: null, banner_image: null };
        this.errors = {};
        this.completedSteps = [];
        this.addDate();
        this.addVenue();
    },

    submit() {
        if (this.submitting) return;
        this.validateStep(8);
        if (!this.validateStep(0)) { this.currentStep = 0; return; }
        if (!this.validateStep(1)) { this.currentStep = 1; return; }
        if (this.form.dates.length === 0) { this.errors = { dates: 'Add at least one date.' }; this.currentStep = 1; return; }
        if (this.form.venues.length === 0) { this.errors = { venues: 'Add at least one venue.' }; this.currentStep = 2; return; }
        if (Object.keys(this.errors).length > 0) { this.currentStep = 8; return; }
        this.submitting = true;
        localStorage.removeItem('event_draft');
        this.$el.submit();
    }
}));

Alpine.start();
