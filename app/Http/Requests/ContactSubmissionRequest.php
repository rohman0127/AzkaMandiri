<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ContactSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare inputs before validation (sanitize & normalize).
     */
    protected function prepareForValidation(): void
    {
        // Normalize phone number: remove spaces, dashes, dots, parentheses
        $phone = $this->input('phone_number');
        if (is_string($phone)) {
            $cleanedPhone = preg_replace('/[\s\-\.\(\)]+/', '', trim($phone));
            $this->merge(['phone_number' => $cleanedPhone]);
        }

        // Trim string inputs
        $this->merge([
            'name' => is_string($this->input('name')) ? trim($this->input('name')) : $this->input('name'),
            'email' => is_string($this->input('email')) ? trim($this->input('email')) : $this->input('email'),
            'subject' => is_string($this->input('subject')) ? trim($this->input('subject')) : $this->input('subject'),
            'message' => is_string($this->input('message')) ? trim($this->input('message')) : $this->input('message'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // List of blocked dangerous file extensions in subject and message
        $dangerousExtensionsRegex = '/\.(?:zip|rar|7z|tar|gz|iso|exe|bat|cmd|sh|bash|ps1|vbs|msi|dll|scr|jar|apk|dmg|html|htm|css|js|php|phtml|asp|aspx|jsp|cgi)(?:\b|[?&#\s]|$)/i';

        // Disallowed HTML and script tags
        $htmlTagsRegex = '/<[^>]*>/';

        // Disallowed CSS patterns & styling expressions
        $cssPatternsRegex = '/(?i)(?:expression\s*\(|url\s*\(|@import|@keyframes|\b(?:background-color|background|color|display|position|visibility|font-family)\s*:|\bstyle\s*=)/';

        return [
            // Anti-bot Honeypot field (must remain completely empty)
            'website_hp' => [
                'nullable',
                'max:0',
            ],

            // Full Name: Only human name characters, min 3, max 60
            'name' => [
                'required',
                'string',
                'min:3',
                'max:60',
                'regex:/^[a-zA-Z\s\.\,\'\-]+$/u',
                function ($attribute, $value, $fail) use ($htmlTagsRegex) {
                    if (preg_match($htmlTagsRegex, $value) || strip_tags($value) !== $value) {
                        $fail('Nama lengkap tidak boleh mengandung kode HTML, tag, atau skrip.');
                    }
                    // Prevent names with only spaces or dots
                    if (!preg_match('/[a-zA-Z]{2,}/', $value)) {
                        $fail('Nama lengkap harus memuat minimal 2 karakter alfabet yang jelas.');
                    }
                },
            ],

            // Phone / WhatsApp: Indonesian mobile format
            'phone_number' => [
                'required',
                'string',
                'min:9',
                'max:16',
                'regex:/^(?:\+62|62|0)8[1-9][0-9]{6,11}$/',
            ],

            // Email: Valid format, no HTML or CRLF injection
            'email' => [
                'nullable',
                'string',
                'email:filter',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (!empty($value)) {
                        if (preg_match('/[\r\n<>\'\"\\\]/', $value) || strip_tags($value) !== $value) {
                            $fail('Format email tidak valid atau mengandung karakter yang dilarang.');
                        }
                    }
                },
            ],

            // Subject: Min 3, Max 120, clean alphanumeric with standard punctuation, no HTML/CSS/ZIP
            'subject' => [
                'required',
                'string',
                'min:3',
                'max:120',
                function ($attribute, $value, $fail) use ($htmlTagsRegex, $cssPatternsRegex, $dangerousExtensionsRegex) {
                    if (preg_match($htmlTagsRegex, $value) || strip_tags($value) !== $value) {
                        $fail('Subjek pesan tidak boleh mengandung kode HTML atau tag.');
                    }
                    if (preg_match($cssPatternsRegex, $value)) {
                        $fail('Subjek pesan tidak boleh memuat sintaks CSS atau styling.');
                    }
                    if (preg_match($dangerousExtensionsRegex, $value)) {
                        $fail('Subjek tidak boleh mencantumkan ekstensi berkas berbahaya (.zip, .exe, .html, .css, .php, dll).');
                    }
                    if (preg_match('/(?:javascript|data|vbscript|onload=|onerror=):?/i', $value)) {
                        $fail('Subjek tidak boleh memuat skrip atau event handler.');
                    }
                },
            ],

            // Message: Min 10, Max 2500, clean project inquiry, strictly no HTML, CSS, ZIP, base64
            'message' => [
                'required',
                'string',
                'min:10',
                'max:2500',
                function ($attribute, $value, $fail) use ($htmlTagsRegex, $cssPatternsRegex, $dangerousExtensionsRegex) {
                    // Block HTML tags
                    if (preg_match($htmlTagsRegex, $value) || strip_tags($value) !== $value) {
                        $fail('Pesan tidak boleh mengandung kode HTML atau tag (<script>, <style>, <iframe>, dll).');
                    }

                    // Block CSS code patterns
                    if (preg_match($cssPatternsRegex, $value)) {
                        $fail('Pesan tidak boleh memuat sintaks CSS, stylesheet, atau aturan styling.');
                    }

                    // Block dangerous file extensions (zip, rar, exe, bat, cmd, sh, php, etc.)
                    if (preg_match($dangerousExtensionsRegex, $value)) {
                        $fail('Pesan tidak boleh memuat tautan atau referensi berkas terlarang (.zip, .rar, .exe, .html, .css, .php, dll).');
                    }

                    // Block base64 data URIs
                    if (preg_match('/data:[a-zA-Z0-9\/\-+.]+;base64,/i', $value)) {
                        $fail('Pesan tidak boleh memuat payload data base64 berkas.');
                    }

                    // Block dangerous URI schemes & event handlers
                    if (preg_match('/(?:javascript|vbscript|onload=|onerror=|onclick=)/i', $value)) {
                        $fail('Pesan tidak boleh memuat kode skrip JavaScript atau event handler.');
                    }
                },
            ],
        ];
    }

    /**
     * Additional validation logic for attached files.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            // Strictly prohibit any file uploads / attachments in the contact form
            if (!empty($this->allFiles())) {
                $validator->errors()->add('message', 'Formulir kontak ini tidak menerima lampiran berkas atau file upload (.zip, .exe, .html, .css, dll). Silakan sampaikan spesifikasi melalui teks atau WhatsApp resmi.');
            }
        });
    }

    /**
     * Custom Indonesian validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'website_hp.max' => 'Pengiriman pesan ditolak karena aktivitas bot terdeteksi.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama lengkap minimal 3 karakter.',
            'name.max' => 'Nama lengkap maksimal 60 karakter.',
            'name.regex' => 'Nama lengkap hanya boleh berisi huruf, spasi, titik, koma, tanda petik, dan tanda hubung (-).',
            'phone_number.required' => 'Nomor WhatsApp / HP wajib diisi.',
            'phone_number.regex' => 'Format nomor WhatsApp / HP tidak valid. Gunakan nomor Indonesia (contoh: 081234567890 atau +6281234567890).',
            'phone_number.min' => 'Nomor WhatsApp minimal 9 digit.',
            'phone_number.max' => 'Nomor WhatsApp maksimal 16 digit.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.max' => 'Alamat email maksimal 100 karakter.',
            'subject.required' => 'Subjek kebutuhan proyek wajib diisi.',
            'subject.min' => 'Subjek kebutuhan minimal 3 karakter.',
            'subject.max' => 'Subjek kebutuhan maksimal 120 karakter.',
            'message.required' => 'Pesan dan spesifikasi proyek wajib diisi.',
            'message.min' => 'Isi pesan minimal 10 karakter agar kebutuhan proyek Anda dapat dipahami dengan baik.',
            'message.max' => 'Isi pesan maksimal 2.500 karakter.',
        ];
    }
}

