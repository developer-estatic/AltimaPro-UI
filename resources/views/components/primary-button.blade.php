<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn w-100 btn-primary crm-blue-btn']) }}>
    {{ $slot }}
</button>
