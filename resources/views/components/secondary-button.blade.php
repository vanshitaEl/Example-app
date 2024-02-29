<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-sm btn-primary']) }}>
    {{ $slot }}
</button>