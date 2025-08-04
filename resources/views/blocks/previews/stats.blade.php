<div>
    {{-- <x-mary-stat title="Sales" description="This month" value="22.124" icon="o-arrow-trending-up" tooltip-bottom="There" /> --}}
    <x-mary-stat
        title="{{ $title }}"
        description="{{ $description }}"
        value="{{ $value }}"
        icon="o-arrow-trending-up"
        {{-- tooltip-bottom="{{ $tooltipBottom }}" --}}
    />
</div>