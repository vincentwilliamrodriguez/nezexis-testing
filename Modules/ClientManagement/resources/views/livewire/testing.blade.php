@php
    use Illuminate\Support\Str;
@endphp

<div class="px-12 py-8 flex flex-col items-stretch gap-4">
    <div class="flex gap-6 [&_div]:flex-grow">
        <div class="!flex-grow-[2] min-w-[50%]">
            <x-mary-input
                class="min-w-[50%]"
                label='Name'
                wire:model.live.debounce.250ms='item.name'
                placeholder='ABC Corporation'
                clearable
                required
                maxlength="40"
            />
        </div>
        <x-mary-select
            class="!outline-none"
            label='Client Type'
            wire:model.live.debounce.250ms='item.client_type'
            :options='$clientTypeOptions'
            placeholder='Select Client Type'
            required
        />
        <x-mary-select
            class="!outline-none"
            label='Status'
            wire:model.live.debounce.250ms='item.status'
            :options='$statusOptions'
            placeholder='Select Status'
            required
        />
    </div>

    <div class="flex gap-6 [&_div]:flex-grow">
        <x-mary-input
            label='Primary Email Address (Optional)'
            wire:model.live.debounce.250ms='item.email'
            placeholder='contact@abccorporation.com'
            clearable
            type="email"
            maxlength="30"
        />
        <x-mary-input
            label='Primary Mobile Number (Optional)'
            wire:model.live.debounce.250ms='item.mobile'
            placeholder='09123456789'
            clearable
            pattern="^09\d{9}$"
        />
    </div>

    <div class="grid grid-cols-2 gap-6">
        @foreach (['country', 'region', 'province', 'city', 'barangay'] as $loc)
            <x-mary-select
                class="!outline-none"
                :label="Str::ucfirst($loc)"
                wire:model.live.debounce.250ms="location.{{ $loc }}"
                :options="$locationOptions[$loc]"
                :disabled="empty($locationOptions[$loc])"
                :placeholder="'Select ' . Str::ucfirst($loc)"
                required
            />
        @endforeach

        <div class="flex gap-6 [&_div]:flex-grow">
            <div class="!flex-grow-[2]">
                <x-mary-input
                    label='Street Address'
                    wire:model.live.debounce.250ms='location.street_add'
                    placeholder='123 Gumamela St.'
                    clearable
                    required
                    maxlength="40"
                />
            </div>
            <x-mary-input
                label='Zip Code'
                wire:model.live.debounce.250ms='location.zipcode'
                placeholder='1234'
                clearable
                required
                pattern="^\d{4}$"
                maxlength="4"
            />
        </div>
    </div>

    <div class="flex justify-end">
        <x-mary-button class="btn-primary" icon='o-plus' label='Create' wire:click='save' />
    </div>
</div>
