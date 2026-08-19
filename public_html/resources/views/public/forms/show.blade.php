@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $form->title }} | {{ $siteName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100">
    <div class="max-w-4xl mx-auto py-16 px-4">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-2xl">
            <div class="mb-8">
                <p class="text-sm uppercase tracking-[0.24em] text-red-400">{{ $siteName }}</p>
                <h1 class="mt-3 text-3xl font-bold">{{ $form->title }}</h1>
                @if($form->description)
                    <p class="mt-4 text-slate-300">{{ $form->description }}</p>
                @endif
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-red-200">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('public.form.store', $form->slug) }}" class="space-y-6" enctype="multipart/form-data">
                @csrf

                @foreach($form->fields as $field)
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-200">
                            {{ $field->label }}
                            @if($field->is_required)<span class="text-red-400">*</span>@endif
                        </label>

                        @php $fieldName = $field->name; @endphp

                        @switch($field->type)
                            @case('textarea')
                                <textarea name="{{ $fieldName }}" rows="4" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-red-500 focus:outline-none" placeholder="{{ $field->placeholder ?? '' }}" {{ $field->is_required ? 'required' : '' }}></textarea>
                                @break
                            @case('email')
                                <input type="email" name="{{ $fieldName }}" value="{{ old($fieldName) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-red-500 focus:outline-none" placeholder="{{ $field->placeholder ?? '' }}" {{ $field->is_required ? 'required' : '' }}>
                                @break
                            @case('phone')
                                <input type="tel" name="{{ $fieldName }}" value="{{ old($fieldName) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-red-500 focus:outline-none" placeholder="{{ $field->placeholder ?? '' }}" {{ $field->is_required ? 'required' : '' }}>
                                @break
                            @case('number')
                                <input type="number" name="{{ $fieldName }}" value="{{ old($fieldName) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-red-500 focus:outline-none" placeholder="{{ $field->placeholder ?? '' }}" {{ $field->is_required ? 'required' : '' }}>
                                @break
                            @case('date')
                                <input type="date" name="{{ $fieldName }}" value="{{ old($fieldName) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-red-500 focus:outline-none" {{ $field->is_required ? 'required' : '' }}>
                                @break
                            @case('select')
                                <select name="{{ $fieldName }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-red-500 focus:outline-none" {{ $field->is_required ? 'required' : '' }}>
                                    <option value="">Pilih</option>
                                    @php $options = is_array($field->options) ? $field->options : json_decode($field->options ?? '[]', true); @endphp
                                    @foreach($options as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                @break
                            @case('radio')
                                <div class="space-y-2">
                                    @php $options = is_array($field->options) ? $field->options : json_decode($field->options ?? '[]', true); @endphp
                                    @foreach($options as $option)
                                        <label class="flex items-center gap-2 text-slate-200">
                                            <input type="radio" name="{{ $fieldName }}" value="{{ $option }}" class="accent-red-500">
                                            <span>{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @break
                            @case('checkbox')
                                <div class="space-y-2">
                                    @php $options = is_array($field->options) ? $field->options : json_decode($field->options ?? '[]', true); @endphp
                                    @foreach($options as $option)
                                        <label class="flex items-center gap-2 text-slate-200">
                                            <input type="checkbox" name="{{ $fieldName }}[]" value="{{ $option }}" class="accent-red-500">
                                            <span>{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @break
                            @case('file')
                            @case('image')
                                <input type="file" name="{{ $fieldName }}" class="block w-full text-sm text-slate-200 file:mr-4 file:rounded-full file:border-0 file:bg-red-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white" {{ $field->is_required ? 'required' : '' }}>
                                @break
                            @default
                                <input type="text" name="{{ $fieldName }}" value="{{ old($fieldName) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-red-500 focus:outline-none" placeholder="{{ $field->placeholder ?? '' }}" {{ $field->is_required ? 'required' : '' }}>
                        @endswitch

                        @if($field->description)
                            <p class="mt-2 text-xs text-slate-400">{{ $field->description }}</p>
                        @endif
                    </div>
                @endforeach

                <div class="pt-4">
                    <button type="submit" class="inline-flex items-center rounded-xl bg-red-600 px-6 py-3 font-semibold text-white hover:bg-red-500">
                        Kirim Formulir
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
