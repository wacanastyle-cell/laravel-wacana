@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $form->title }} | {{ $siteName }}</title>

    <meta name="description"
          content="{{ \Illuminate\Support\Str::limit(strip_tags($form->description ?? 'Formulir Wacana Style'), 160) }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        /* =========================
           PUBLIC FORM THUMBNAIL
        ========================= */

        .public-form-thumbnail {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto 28px;
            aspect-ratio: 16 / 9;
            overflow: hidden;
            border-radius: 22px;
            border: 1px solid rgba(255,255,255,.10);
            background: #111114;
            box-shadow: 0 20px 60px rgba(0,0,0,.35);
        }

        .public-form-thumbnail img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 640px) {
            .public-form-thumbnail {
                border-radius: 16px;
                margin-bottom: 20px;
            }
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            width: 100%;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background: #08080a;
            color: #f4f4f5;
            font-family: Inter, Arial, sans-serif;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: Montserrat, Arial, sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #0d0d0f;
        }

        ::-webkit-scrollbar-thumb {
            background: #dc2626;
            border-radius: 10px;
        }

        .form-page {
            width: 100%;
            min-height: 100vh;
            padding: 110px 16px 70px;
        }

        .form-container {
            width: min(900px, 100%);
            margin: 0 auto;
        }

        .form-card {
            overflow: hidden;
            background:
                linear-gradient(
                    145deg,
                    rgba(25, 25, 29, .98),
                    rgba(12, 12, 15, .98)
                );
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 22px;
            box-shadow:
                0 25px 70px rgba(0,0,0,.45),
                0 0 0 1px rgba(255,255,255,.02);
        }

        .form-header {
            padding: 34px 34px 28px;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }

        .brand-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            color: #ef4444;
            font-family: Montserrat, Arial, sans-serif;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .brand-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #ef2029;
            box-shadow: 0 0 12px rgba(239,32,41,.65);
        }

        .form-title {
            margin: 0;
            color: #fff;
            font-size: clamp(25px, 4vw, 38px);
            line-height: 1.15;
            font-weight: 800;
        }

        .form-description {
            margin: 14px 0 0;
            color: #a1a1aa;
            font-size: 14px;
            line-height: 1.75;
        }

        .form-body {
            padding: 32px 34px 36px;
        }

        .alert {
            margin-bottom: 24px;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 13px;
            line-height: 1.6;
        }

        .alert-success {
            color: #bbf7d0;
            background: rgba(34,197,94,.08);
            border: 1px solid rgba(34,197,94,.25);
        }

        .alert-error {
            color: #fecaca;
            background: rgba(239,68,68,.08);
            border: 1px solid rgba(239,68,68,.25);
        }

        .alert-error ul {
            margin: 0;
            padding-left: 20px;
        }

        .field {
            margin-bottom: 22px;
        }

        .field-label {
            display: block;
            margin-bottom: 8px;
            color: #e4e4e7;
            font-family: Montserrat, Arial, sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .03em;
        }

        .required {
            color: #ef4444;
            margin-left: 3px;
        }

        .field-input,
        .field-select,
        .field-textarea {
            display: block;
            width: 100%;
            border: 1px solid rgba(255,255,255,.10);
            border-radius: 12px;
            outline: none;
            background: #09090b;
            color: #f4f4f5;
            padding: 13px 14px;
            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }

        .field-input::placeholder,
        .field-textarea::placeholder {
            color: #52525b;
        }

        .field-input:focus,
        .field-select:focus,
        .field-textarea:focus {
            border-color: #ef4444;
            background: #0c0c0f;
            box-shadow: 0 0 0 3px rgba(239,68,68,.10);
        }

        .field-textarea {
            min-height: 120px;
            resize: vertical;
            line-height: 1.6;
        }

        .field-select {
            cursor: pointer;
        }

        .field-select option {
            background: #09090b;
            color: #fff;
        }

        .field-help {
            margin: 7px 0 0;
            color: #71717a;
            font-size: 11px;
            line-height: 1.6;
        }

        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .checkbox-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: #d4d4d8;
            font-size: 13px;
            line-height: 1.5;
            cursor: pointer;
        }

        .checkbox-item input {
            width: 17px;
            height: 17px;
            margin: 2px 0 0;
            accent-color: #ef2029;
            flex: 0 0 auto;
        }

        .file-input {
            display: block;
            width: 100%;
            padding: 10px;
            border: 1px dashed rgba(255,255,255,.16);
            border-radius: 12px;
            background: #09090b;
            color: #a1a1aa;
            cursor: pointer;
        }

        .file-input:hover {
            border-color: rgba(239,68,68,.55);
        }

        .file-input::file-selector-button {
            margin-right: 12px;
            padding: 9px 14px;
            border: 0;
            border-radius: 9px;
            background: #ef2029;
            color: #fff;
            font-weight: 700;
            cursor: pointer;
        }

        .submit-area {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid rgba(255,255,255,.07);
        }

        .submit-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 48px;
            padding: 0 22px;
            border: 0;
            border-radius: 12px;
            background: #dc2626;
            color: #fff;
            font-family: Montserrat, Arial, sans-serif;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            transition:
                background .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }

        .submit-button:hover {
            background: #ef2029;
            transform: translateY(-1px);
            box-shadow: 0 10px 30px rgba(220,38,38,.25);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        .upload-note {
            margin-top: 8px;
            color: #71717a;
            font-size: 10px;
            line-height: 1.5;
        }

        @media (max-width: 700px) {
            .form-page {
                padding: 90px 12px 50px;
            }

            .form-header {
                padding: 25px 20px 22px;
            }

            .form-body {
                padding: 24px 20px 28px;
            }

            .form-card {
                border-radius: 16px;
            }

            .submit-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

@include('partials.header-nav')

<main class="form-page">
@if(!empty($form->thumbnail))
    <div class="public-form-thumbnail">
        <img
            src="{{ asset('storage/' . ltrim($form->thumbnail, '/')) }}"
            alt="{{ $form->title }}"
            loading="eager"
            onerror="this.parentElement.style.display='none';"
        >
    </div>
@endif

    <div class="form-container">

        <section class="form-card">

            <header class="form-header">
                <div class="brand-label">
                    <span class="brand-dot"></span>
                    {{ $siteName }}
                </div>

                <h1 class="form-title">
                    {{ $form->title }}
                </h1>

                @if($form->description)
                    <p class="form-description">
                        {{ $form->description }}
                    </p>
                @endif
            </header>

            <div class="form-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('public.form.store', $form->slug) }}"
                    enctype="multipart/form-data"
                >
                    @csrf

                    @foreach($form->fields as $field)

                        @php
                            $fieldName = $field->name;
                            $oldValue = old($fieldName);
                        @endphp

                        <div class="field">

                            <label class="field-label" for="{{ $fieldName }}">
                                {{ $field->label }}

                                @if($field->is_required)
                                    <span class="required">*</span>
                                @endif
                            </label>

                            @switch($field->type)

                                @case('textarea')
                                    <textarea
                                        id="{{ $fieldName }}"
                                        name="{{ $fieldName }}"
                                        rows="5"
                                        class="field-textarea"
                                        placeholder="{{ $field->placeholder ?? '' }}"
                                        {{ $field->is_required ? 'required' : '' }}
                                    >{{ old($fieldName) }}</textarea>
                                    @break

                                @case('tel')
                                @case('phone')
                                    <input
                                        id="{{ $fieldName }}"
                                        type="tel"
                                        name="{{ $fieldName }}"
                                        value="{{ old($fieldName) }}"
                                        class="field-input"
                                        placeholder="{{ $field->placeholder ?? '' }}"
                                        autocomplete="tel"
                                        {{ $field->is_required ? 'required' : '' }}
                                    >
                                    @break

                                @case('number')
                                    <input
                                        id="{{ $fieldName }}"
                                        type="number"
                                        name="{{ $fieldName }}"
                                        value="{{ old($fieldName) }}"
                                        class="field-input"
                                        placeholder="{{ $field->placeholder ?? '' }}"
                                        {{ $field->is_required ? 'required' : '' }}
                                    >
                                    @break

                                @case('date')
                                    <input
                                        id="{{ $fieldName }}"
                                        type="date"
                                        name="{{ $fieldName }}"
                                        value="{{ old($fieldName) }}"
                                        class="field-input"
                                        {{ $field->is_required ? 'required' : '' }}
                                    >
                                    @break

                                @case('time')
                                    <input
                                        id="{{ $fieldName }}"
                                        type="time"
                                        name="{{ $fieldName }}"
                                        value="{{ old($fieldName) }}"
                                        class="field-input"
                                        {{ $field->is_required ? 'required' : '' }}
                                    >
                                    @break

                                @case('select')
                                    @php
                                        $options = $field->optionsList();
                                    @endphp

                                    <select
                                        id="{{ $fieldName }}"
                                        name="{{ $fieldName }}"
                                        class="field-select"
                                        {{ $field->is_required ? 'required' : '' }}
                                    >
                                        <option value="">Pilih</option>

                                        @foreach($options as $option)
                                            <option
                                                value="{{ $option }}"
                                                {{ (string) $oldValue === (string) $option ? 'selected' : '' }}
                                            >
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @break

                                @case('checkbox')
                                    @php
                                        $options = $field->optionsList();
                                        $isSingleCheckbox = $field->isSingleCheckbox();
                                    @endphp

                                    @if($isSingleCheckbox)

                                        <label class="checkbox-item">
                                            <input
                                                type="checkbox"
                                                id="{{ $fieldName }}"
                                                name="{{ $fieldName }}"
                                                value="1"
                                                {{ old($fieldName) ? 'checked' : '' }}
                                                {{ $field->is_required ? 'required' : '' }}
                                            >

                                            <span>
                                                {{ $field->description ?: $field->label }}
                                            </span>
                                        </label>

                                    @else

                                        <div class="checkbox-group">
                                            @foreach($options as $option)
                                                <label class="checkbox-item">
                                                    <input
                                                        type="checkbox"
                                                        name="{{ $fieldName }}[]"
                                                        value="{{ $option }}"
                                                        {{ is_array(old($fieldName)) && in_array($option, old($fieldName)) ? 'checked' : '' }}
                                                    >

                                                    <span>{{ $option }}</span>
                                                </label>
                                            @endforeach
                                        </div>

                                    @endif
                                    @break

                                @case('file')
                                    <input
                                        id="{{ $fieldName }}"
                                        type="file"
                                        name="{{ $fieldName }}"
                                        class="file-input"
                                        accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx"
                                        {{ $field->is_required ? 'required' : '' }}
                                    >

                                    <div class="upload-note">
                                        Maksimal 10 MB. Format: JPG, JPEG, PNG, WEBP, PDF, DOC, DOCX.
                                    </div>
                                    @break

                                @case('image')
                                    <input
                                        id="{{ $fieldName }}"
                                        type="file"
                                        name="{{ $fieldName }}"
                                        class="file-input"
                                        accept="image/jpeg,image/png,image/webp"
                                        {{ $field->is_required ? 'required' : '' }}
                                    >

                                    <div class="upload-note">
                                        Maksimal 10 MB. Format: JPG, JPEG, PNG, WEBP.
                                    </div>
                                    @break

                                @case('email')
                                    <input
                                        id="{{ $fieldName }}"
                                        type="email"
                                        name="{{ $fieldName }}"
                                        value="{{ old($fieldName) }}"
                                        class="field-input"
                                        placeholder="{{ $field->placeholder ?? '' }}"
                                        autocomplete="email"
                                        {{ $field->is_required ? 'required' : '' }}
                                    >
                                    @break

                                @default
                                    <input
                                        id="{{ $fieldName }}"
                                        type="text"
                                        name="{{ $fieldName }}"
                                        value="{{ old($fieldName) }}"
                                        class="field-input"
                                        placeholder="{{ $field->placeholder ?? '' }}"
                                        {{ $field->is_required ? 'required' : '' }}
                                    >

                            @endswitch

                            @if($field->description && !($field->type === 'checkbox' && $field->isSingleCheckbox()))
                                <p class="field-help">
                                    {{ $field->description }}
                                </p>
                            @endif

                        </div>

                    @endforeach

                    <div class="submit-area">
                        <button type="submit" class="submit-button">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Kirim Formulir</span>
                        </button>
                    </div>

                </form>

            </div>
        </section>

    </div>
</main>

@include('partials.footer')

</body>
</html>
