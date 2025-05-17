<div>
    <x-mary-select
        class="!outline-none"
        label='Main Company Status'
        wire:model.live.debounce.250ms='status'
        :options='$selectOptions'
    />

    <x-mary-select
        class="!outline-none"
        label='Country'
        wire:model.live.debounce.250ms='location.country'
        :options='$locationOptions["country"]'
        :disabled='empty($locationOptions["country"])'
        placeholder='Select Country'
    />

    <x-mary-select
        class="!outline-none"
        label='Region'
        wire:model.live.debounce.250ms='location.region'
        :options='$locationOptions["region"]'
        :disabled='empty($locationOptions["region"])'
        placeholder='Select Region'
    />

    <x-mary-select
        class="!outline-none"
        label='Province'
        wire:model.live.debounce.250ms='location.province'
        :options='$locationOptions["province"]'
        :disabled='empty($locationOptions["province"])'
        placeholder='Select Province'
    />

    <x-mary-select
        class="!outline-none"
        label='City/Municipality'
        wire:model.live.debounce.250ms='location.city'
        :options='$locationOptions["city"]'
        :disabled='empty($locationOptions["city"])'
        placeholder='Select City/Municipality'
    />

    <x-mary-select
        class="!outline-none"
        label='Barangay'
        wire:model.live.debounce.250ms='location.barangay'
        :options='$locationOptions["barangay"]'
        :disabled='empty($locationOptions["barangay"])'
        placeholder='Select Barangay'
    />

    <x-mary-input
        label='Street Address'
        wire:model.live.debounce.250ms='location.street_add'
        placeholder='123 Gumamela St.'
        clearable
    />

    <x-mary-input
        label='Zip Code'
        wire:model.live.debounce.250ms='location.zipcode'
        placeholder='1234'
        clearable
    />

    <x-mary-button label='Save' wire:click='save' />
</div>
