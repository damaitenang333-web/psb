<?php

if (! function_exists('get_form_errors')) {
    /**
     * Helper internal untuk mengambil array errors dari Session atau Service Validation
     */
    function get_form_errors(): array
    {
        // 1. Cek dari Session Flashdata (hasil redirect controller with('errors', ...))
        $sessionErrors = session('errors');
        if (is_array($sessionErrors)) {
            return $sessionErrors;
        }

        // 2. Fallback ke Service Validation jika di-render langsung tanpa redirect
        return \Config\Services::validation()->getErrors();
    }
}

if (! function_exists('field_error')) {
    function field_error(string $field): string
    {
        $errors = get_form_errors();
        return isset($errors[$field]) ? 'is-invalid' : '';
    }
}

if (! function_exists('show_feedback')) {
    function show_feedback(string $field): string
    {
        $errors = get_form_errors();
        if (isset($errors[$field])) {
            return '<div class="invalid-feedback">' . esc($errors[$field]) . '</div>';
        }
        return '';
    }
}