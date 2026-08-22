@php
    use Illuminate\Support\Facades\Storage;

    $siteName =
        $siteSettings['site_name']
        ?? 'Wacana Style';

    $categoryNames = [
        'touring' => 'Touring',
        'kopdar' => 'Kopdar',
        'ride_out' => 'Ride Out',
        'jacket_po' => 'Pembuatan Jaket / Open PO',
    ];

    $categoryName =
        $categoryNames[$form->category]
        ?? ucfirst(
            str_replace(
                '_',
                ' ',
                $form->category
            )
        );

    $effectivePrice =
        (float) (
            $form->promo_price > 0
                ? $form->promo_price
                : $form->payment_amount
        );

    $success =
        session('form_success');

    $variations =
        is_array($form->price_variations)
            ? $form->price_variations
            : [];

    $priceFields =
        $form->fields
            ->where('is_price_field', true)
            ->values();
@endphp

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>
    {{ $form->title }} | {{ $siteName }}
</title>

<meta
    name="description"
    content="{{ $form->description ?: 'Formulir '.$categoryName.' '.$siteName }}"
>

<link rel="preconnect"
      href="https://fonts.googleapis.com">

<link rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@500;600;700;800;900&display=swap"
      rel="stylesheet">

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

:root{
    --red:#ef2029;
    --bg:#060608;
    --card:#0d0d10;
    --card2:#111116;
    --border:rgba(255,255,255,.09);
    --text:#f5f5f5;
    --muted:#96969f;
}

*{
    box-sizing:border-box;
}

body{
    margin:0;

    background:
        radial-gradient(
            circle at 50% -8%,
            rgba(239,32,41,.15),
            transparent 35%
        ),
        var(--bg);

    color:var(--text);

    font-family:Inter,Arial,sans-serif;
}

a{
    color:inherit;
    text-decoration:none;
}

.form-container{
    width:min(950px,calc(100% - 32px));
    margin:auto;

    padding:90px 0 110px;
}

.form-back{
    display:inline-flex;
    align-items:center;
    gap:8px;

    margin-bottom:25px;

    color:#ff4b52;

    font-size:12px;
    font-weight:700;
}

.form-card{
    overflow:hidden;

    border:1px solid var(--border);
    border-radius:22px;

    background:rgba(255,255,255,.018);
}

.form-banner{
    width:100%;
    max-height:480px;

    display:block;

    object-fit:cover;
}

.form-head{
    padding:36px 40px 28px;
}

.form-category{
    display:inline-flex;

    padding:7px 12px;

    margin-bottom:15px;

    border:1px solid rgba(239,32,41,.25);
    border-radius:100px;

    background:rgba(239,32,41,.08);

    color:#ff4b52;

    font-size:10px;
    font-weight:800;

    text-transform:uppercase;
}

.form-title{
    margin:0;

    font-family:Montserrat,Arial,sans-serif;

    font-size:clamp(34px,5vw,56px);

    line-height:1.08;

    font-weight:900;

    letter-spacing:-2px;
}

.form-description{
    margin:18px 0 0;

    color:var(--muted);

    font-size:14px;
    line-height:1.8;
}

.event-info{
    display:grid;

    grid-template-columns:
        repeat(2,minmax(0,1fr));

    gap:12px;

    margin-top:24px;
}

.info-card{
    padding:14px 15px;

    border:1px solid var(--border);
    border-radius:12px;

    background:rgba(255,255,255,.02);
}

.info-card small{
    display:block;

    margin-bottom:5px;

    color:#6f6f78;

    font-size:9px;
    font-weight:800;

    text-transform:uppercase;
}

.info-card strong{
    font-size:12px;
}

.form-body{
    padding:32px 40px 42px;

    border-top:1px solid var(--border);
}

.fields-grid{
    display:grid;

    grid-template-columns:
        repeat(12,minmax(0,1fr));

    gap:18px;
}

.field-wrap{
    grid-column:span 12;
}

.field-wrap[data-width="half"]{
    grid-column:span 6;
}

.field-wrap[data-width="third"]{
    grid-column:span 4;
}

.field-label{
    display:block;

    margin-bottom:8px;

    color:#eee;

    font-size:12px;
    font-weight:700;
}

.required{
    color:#ff4b52;
}

.field-help{
    margin-top:7px;

    color:#71717a;

    font-size:10px;
    line-height:1.5;
}

.field-input,
.field-select,
.field-textarea{
    width:100%;

    padding:13px 14px;

    border:1px solid rgba(255,255,255,.11);
    border-radius:11px;

    outline:none;

    background:#101014;

    color:#fff;

    font-family:inherit;

    font-size:13px;
}

.field-textarea{
    min-height:120px;

    resize:vertical;
}

.field-input:focus,
.field-select:focus,
.field-textarea:focus{
    border-color:rgba(239,32,41,.7);

    box-shadow:
        0 0 0 3px rgba(239,32,41,.08);
}

.choice-list{
    display:grid;

    gap:9px;
}

.choice{
    display:flex;

    align-items:center;

    gap:9px;

    padding:11px 12px;

    border:1px solid var(--border);
    border-radius:10px;

    background:#101014;

    font-size:12px;
}

.field-heading{
    padding-top:14px;

    border-top:1px solid var(--border);
}

.field-heading h3{
    margin:0;

    font-family:Montserrat;

    font-size:18px;
}

.field-info{
    padding:14px 16px;

    border:1px solid rgba(239,32,41,.16);
    border-radius:11px;

    background:rgba(239,32,41,.05);

    color:#b9b9c0;

    font-size:12px;
    line-height:1.7;
}

.payment-box{
    margin-top:30px;

    padding:22px;

    border:1px solid rgba(239,32,41,.18);
    border-radius:16px;

    background:rgba(239,32,41,.04);
}

.payment-title{
    margin:0 0 17px;

    font-family:Montserrat;

    font-size:17px;
}

.price{
    font-family:Montserrat;

    font-size:28px;
    font-weight:900;

    color:#fff;
}

.old-price{
    margin-left:8px;

    color:#777780;

    text-decoration:line-through;

    font-size:12px;
}

.payment-grid{
    display:grid;

    grid-template-columns:
        repeat(2,minmax(0,1fr));

    gap:12px;

    margin-top:18px;
}

.payment-item{
    padding:13px;

    border:1px solid var(--border);
    border-radius:10px;

    background:rgba(255,255,255,.02);

    font-size:11px;
}

.qris{
    display:block;

    max-width:260px;

    margin:20px auto 0;

    border-radius:14px;
}

.submit-btn{
    width:100%;

    margin-top:28px;

    padding:15px 20px;

    border:0;
    border-radius:12px;

    cursor:pointer;

    background:
        linear-gradient(
            135deg,
            #ef2029,
            #b91c1c
        );

    color:#fff;

    font-family:Montserrat;

    font-size:13px;
    font-weight:900;
}

.error-box,
.success-box{
    margin-bottom:22px;

    padding:16px;

    border-radius:12px;

    font-size:12px;
    line-height:1.7;
}

.error-box{
    border:1px solid rgba(239,68,68,.25);

    background:rgba(239,68,68,.07);

    color:#fca5a5;
}

.success-box{
    border:1px solid rgba(34,197,94,.25);

    background:rgba(34,197,94,.07);

    color:#bbf7d0;
}

.quota-full{
    margin-top:25px;

    padding:18px;

    text-align:center;

    border:1px solid rgba(239,68,68,.25);
    border-radius:12px;

    background:rgba(239,68,68,.06);

    color:#fca5a5;

    font-size:12px;
}

.conditional-hidden{
    display:none !important;
}

@media(max-width:680px){

    .form-container{
        width:calc(100% - 28px);

        padding:55px 0 75px;
    }

    .form-head,
    .form-body{
        padding:25px 22px;
    }

    .field-wrap[data-width="half"],
    .field-wrap[data-width="third"]{
        grid-column:span 12;
    }

    .event-info,
    .payment-grid{
        grid-template-columns:1fr;
    }

    .form-title{
        font-size:35px;
    }
}

</style>

</head>


<body>

@include('partials.header-nav')

<main>

<div class="form-container">


<a
    href="{{ route('public.forms') }}"
    class="form-back"
>
    <i class="fa-solid fa-arrow-left"></i>

    Semua Formulir
</a>


@if($success)

<div class="success-box">

    <strong>
        {{ $success['success_title'] ?? 'Berhasil' }}
    </strong>

    <div>
        {{ $success['success_message'] ?? '' }}
    </div>

    @if(!empty($success['next_instructions']))
        <div style="margin-top:8px">
            {{ $success['next_instructions'] }}
        </div>
    @endif

    @if(!empty($success['reference_number']))
        <div style="margin-top:8px">
            Nomor:
            <strong>
                {{ $success['reference_number'] }}
            </strong>
        </div>
    @endif

</div>

@endif


@if($errors->any())

<div class="error-box">

    <strong>
        Periksa kembali formulir:
    </strong>

    <ul>

        @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>

@endif


<section class="form-card">


@if(
    $form->show_banner &&
    $form->banner
)

<img
    src="{{ Storage::disk('public')->url($form->banner) }}"
    alt="{{ $form->title }}"
    class="form-banner"
>

@endif


<header class="form-head">

    <div class="form-category">
        {{ $categoryName }}
    </div>


    @if($form->show_title)

        <h1 class="form-title">
            {{ $form->title }}
        </h1>

    @endif


    @if(
        $form->show_description &&
        $form->description
    )

        <div class="form-description">
            {{ $form->description }}
        </div>

    @endif


    @if(
        ($form->show_date && $form->event_date) ||
        ($form->show_time && $form->event_time) ||
        ($form->show_location && $form->location) ||
        ($form->show_quota && $form->quota) ||
        ($form->show_remaining_quota && $remainingQuota !== null) ||
        $form->show_registration_count
    )

    <div class="event-info">


        @if(
            $form->show_date &&
            $form->event_date
        )

        <div class="info-card">

            <small>Tanggal Event</small>

            <strong>
                {{ $form->event_date->format('d M Y') }}
            </strong>

        </div>

        @endif


        @if(
            $form->show_time &&
            $form->event_time
        )

        <div class="info-card">

            <small>Jam Event</small>

            <strong>
                {{ substr($form->event_time,0,5) }}
            </strong>

        </div>

        @endif


        @if(
            $form->show_location &&
            $form->location
        )

        <div class="info-card">

            <small>Lokasi</small>

            <strong>
                {{ $form->location }}
            </strong>

            @if($form->google_maps_url)
                <div style="margin-top:5px">
                    <a
                        href="{{ $form->google_maps_url }}"
                        target="_blank"
                        style="color:#ff4b52"
                    >
                        Buka Google Maps
                    </a>
                </div>
            @endif

        </div>

        @endif


        @if(
            $form->show_quota &&
            $form->quota
        )

        <div class="info-card">

            <small>Kuota</small>

            <strong>
                {{ $form->quota }} peserta
            </strong>

        </div>

        @endif


        @if(
            $form->show_remaining_quota &&
            $remainingQuota !== null
        )

        <div class="info-card">

            <small>Sisa Kuota</small>

            <strong>
                {{ $remainingQuota }}
            </strong>

        </div>

        @endif


        @if($form->show_registration_count)

        <div class="info-card">

            <small>Jumlah Pendaftar</small>

            <strong>
                {{ $registrationCount }}
            </strong>

        </div>

        @endif


    </div>

    @endif

</header>


<div class="form-body">


@if(
    $remainingQuota !== null &&
    $remainingQuota <= 0
)

<div class="quota-full">

    Kuota pendaftaran sudah penuh.

</div>

@else


<form
    method="POST"
    action="{{ route('public.form.store', $form->slug) }}"
    enctype="multipart/form-data"
    id="dynamicForm"
>

@csrf


<div class="fields-grid">


@foreach($form->fields as $field)

@php

    $options = $field->optionsList();

    $oldValue =
        old(
            $field->name,
            $field->default_value
        );

@endphp


@if($field->type === 'heading')

<div
    class="field-wrap field-heading"
    data-width="full"
>

    <h3>
        {{ $field->label }}
    </h3>

    @if($field->description)

        <div class="field-help">
            {{ $field->description }}
        </div>

    @endif

</div>


@elseif($field->type === 'info')

<div
    class="field-wrap field-info"
    data-width="full"
>

    <strong>
        {{ $field->label }}
    </strong>

    @if($field->description)

        <div style="margin-top:5px">
            {{ $field->description }}
        </div>

    @endif

</div>


@else

<div
    class="field-wrap"
    data-field-name="{{ $field->name }}"
    data-width="{{ $field->width ?: 'full' }}"
    data-conditional="{{ $field->conditional_enabled ? '1' : '0' }}"
    data-conditional-field="{{ $field->conditional_field }}"
    data-conditional-operator="{{ $field->conditional_operator }}"
    data-conditional-value="{{ $field->conditional_value }}"
>


<label class="field-label">

    {{ $field->label }}

    @if($field->is_required)
        <span class="required">*</span>
    @endif

</label>


@if($field->type === 'textarea')

<textarea
    name="{{ $field->name }}"
    class="field-textarea"
    placeholder="{{ $field->placeholder }}"
    {{ $field->is_required ? 'required' : '' }}
>{{ $oldValue }}</textarea>


@elseif($field->type === 'select')

<select
    name="{{ $field->name }}"
    class="field-select"
    {{ $field->is_required ? 'required' : '' }}
>

<option value="">
    -- Pilih --
</option>

@foreach($options as $option)

<option
    value="{{ $option }}"
    @selected((string)$oldValue === (string)$option)
>
    {{ $option }}
</option>

@endforeach

</select>


@elseif($field->type === 'radio')

<div class="choice-list">

@foreach($options as $option)

<label class="choice">

<input
    type="radio"
    name="{{ $field->name }}"
    value="{{ $option }}"
    @checked((string)$oldValue === (string)$option)
    {{ $field->is_required ? 'required' : '' }}
>

{{ $option }}

</label>

@endforeach

</div>


@elseif($field->type === 'checkbox' && count($options))

<div class="choice-list">

@foreach($options as $option)

<label class="choice">

<input
    type="checkbox"
    name="{{ $field->name }}[]"
    value="{{ $option }}"
    @checked(
        is_array(old($field->name)) &&
        in_array($option, old($field->name))
    )
>

{{ $option }}

</label>

@endforeach

</div>


@elseif($field->type === 'checkbox')

<label class="choice">

<input
    type="checkbox"
    name="{{ $field->name }}"
    value="1"
    @checked(old($field->name))
    {{ $field->is_required ? 'required' : '' }}
>

{{ $field->description ?: 'Ya' }}

</label>


@elseif($field->type === 'toggle')

<label class="choice">

<input
    type="checkbox"
    name="{{ $field->name }}"
    value="1"
    @checked($oldValue)
>

Aktif

</label>


@elseif(
    in_array(
        $field->type,
        ['file','image']
    )
)

<input
    type="file"
    name="{{ $field->name }}"
    class="field-input"
    @if($field->type === 'image')
        accept="image/*"
    @endif
    {{ $field->is_required ? 'required' : '' }}
>


@else

<input
    type="{{
        match($field->type) {
            'email' => 'email',
            'tel','phone' => 'tel',
            'number' => 'number',
            'date' => 'date',
            'time' => 'time',
            'url' => 'url',
            default => 'text'
        }
    }}"
    name="{{ $field->name }}"
    value="{{ $oldValue }}"
    class="field-input"
    placeholder="{{ $field->placeholder }}"

    @if($field->min_length)
        minlength="{{ $field->min_length }}"
    @endif

    @if($field->max_length)
        maxlength="{{ $field->max_length }}"
    @endif

    @if($field->min_value !== null)
        min="{{ $field->min_value }}"
    @endif

    @if($field->max_value !== null)
        max="{{ $field->max_value }}"
    @endif

    {{ $field->is_required ? 'required' : '' }}
>

@endif


@if(
    $field->description &&
    !in_array(
        $field->type,
        ['checkbox']
    )
)

<div class="field-help">
    {{ $field->description }}
</div>

@endif


</div>

@endif


@endforeach


</div>


@if($form->payment_enabled)

<section class="payment-box">

<h2 class="payment-title">
    Informasi Pembayaran
</h2>


@if($form->show_price)

<div>

<span
    class="price"
    id="calculatedPrice"
>
    Rp{{ number_format(
        $effectivePrice,
        0,
        ',',
        '.'
    ) }}
</span>

@if(
    $form->promo_price > 0 &&
    $form->payment_amount > $form->promo_price
)

<span class="old-price">

    Rp{{ number_format(
        (float)$form->payment_amount,
        0,
        ',',
        '.'
    ) }}

</span>

@endif

</div>

@endif


<div class="payment-grid">


@if($form->bank_name)

<div class="payment-item">

<strong>
    {{ $form->bank_name }}
</strong>

<br>

{{ $form->bank_account_number }}

<br>

{{ $form->bank_account_name }}

</div>

@endif


@if($form->ewallet_name)

<div class="payment-item">

<strong>
    {{ $form->ewallet_name }}
</strong>

<br>

{{ $form->ewallet_number }}

</div>

@endif


@if($form->payment_deadline)

<div class="payment-item">

<strong>Batas Pembayaran</strong>

<br>

{{ $form->payment_deadline->format('d M Y H:i') }}

</div>

@endif


</div>


@if($form->payment_instructions)

<div
    class="field-help"
    style="margin-top:18px"
>

{!! nl2br(e($form->payment_instructions)) !!}

</div>

@endif


@if($form->qris_image)

<img
    src="{{ Storage::disk('public')->url($form->qris_image) }}"
    alt="QRIS"
    class="qris"
>

@endif


</section>

@endif


<button
    type="submit"
    class="submit-btn"
>

{{ $form->submit_button_text ?: 'Kirim Formulir' }}

</button>


</form>

@endif


</div>

</section>

</div>

</main>


@include('partials.footer')


<script>

const priceVariations =
    @json($variations);

const basePrice =
    {{ (float)$effectivePrice }};

const category =
    @json($form->category);


function getNamedValue(name){

    const fields =
        document.querySelectorAll(
            `[name="${name}"], [name="${name}[]"]`
        );

    if(!fields.length){
        return null;
    }

    if(
        fields[0].type === 'radio'
    ){
        const checked =
            document.querySelector(
                `[name="${name}"]:checked`
            );

        return checked
            ? checked.value
            : null;
    }

    if(
        fields[0].type === 'checkbox'
    ){

        const checked =
            [...fields]
            .filter(el => el.checked)
            .map(el => el.value);

        if(fields.length === 1){
            return checked.length
                ? checked[0]
                : null;
        }

        return checked;
    }

    return fields[0].value;
}


function conditionMatches(
    actual,
    operator,
    expected
){

    switch(operator){

        case '!=':
        case 'not_equals':
            return String(actual ?? '') !==
                   String(expected ?? '');

        case 'contains':

            if(Array.isArray(actual)){
                return actual.includes(expected);
            }

            return String(actual ?? '')
                .toLowerCase()
                .includes(
                    String(expected ?? '')
                    .toLowerCase()
                );

        case 'not_contains':

            if(Array.isArray(actual)){
                return !actual.includes(expected);
            }

            return !String(actual ?? '')
                .toLowerCase()
                .includes(
                    String(expected ?? '')
                    .toLowerCase()
                );

        case 'empty':
            return (
                actual === null ||
                actual === '' ||
                (
                    Array.isArray(actual) &&
                    actual.length === 0
                )
            );

        case 'not_empty':
            return !(
                actual === null ||
                actual === '' ||
                (
                    Array.isArray(actual) &&
                    actual.length === 0
                )
            );

        default:
            return String(actual ?? '') ===
                   String(expected ?? '');
    }
}


function updateConditionalFields(){

    document
        .querySelectorAll(
            '[data-conditional="1"]'
        )
        .forEach(wrapper => {

            const trigger =
                wrapper.dataset
                    .conditionalField;

            const operator =
                wrapper.dataset
                    .conditionalOperator
                || 'equals';

            const expected =
                wrapper.dataset
                    .conditionalValue;

            const actual =
                getNamedValue(trigger);

            const visible =
                conditionMatches(
                    actual,
                    operator,
                    expected
                );

            wrapper
                .classList
                .toggle(
                    'conditional-hidden',
                    !visible
                );

            wrapper
                .querySelectorAll(
                    'input,select,textarea'
                )
                .forEach(input => {

                    input.disabled =
                        !visible;

                    if(
                        visible &&
                        input.dataset.wasRequired ===
                            '1'
                    ){
                        input.required = true;
                    }

                    if(!visible){

                        if(input.required){
                            input.dataset.wasRequired =
                                '1';
                        }

                        input.required = false;
                    }

                });

        });
}


function variationPrice(value){

    for(const variation of priceVariations){

        if(!variation){
            continue;
        }

        const variationValue =
            variation.value ??
            variation.option ??
            variation.label ??
            variation.name;

        if(
            String(variationValue) ===
            String(value)
        ){
            const price =
                Number(
                    variation.price ??
                    variation.amount
                );

            if(!Number.isNaN(price)){
                return price;
            }
        }
    }

    return null;
}


function updatePrice(){

    let price =
        Number(basePrice || 0);

    @foreach($priceFields as $priceField)

        {
            const selected =
                getNamedValue(
                    @json($priceField->name)
                );

            const variation =
                variationPrice(selected);

            if(variation !== null){
                price = variation;
            }
        }

    @endforeach


    if(category === 'jacket_po'){

        const qty =
            Number(
                getNamedValue(
                    'jumlah_jaket'
                ) || 1
            );

        price *=
            Math.max(1,qty);
    }


    const display =
        document.getElementById(
            'calculatedPrice'
        );

    if(display){

        display.textContent =
            'Rp' +
            new Intl.NumberFormat(
                'id-ID'
            ).format(price);
    }
}


document
    .querySelectorAll(
        'input,select,textarea'
    )
    .forEach(el => {

        el.addEventListener(
            'change',
            () => {
                updateConditionalFields();
                updatePrice();
            }
        );

        el.addEventListener(
            'input',
            () => {
                updateConditionalFields();
                updatePrice();
            }
        );

    });


updateConditionalFields();
updatePrice();

</script>


</body>

</html>
