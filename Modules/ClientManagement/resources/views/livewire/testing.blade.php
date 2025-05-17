<div>
    {{-- <flux:dropdown>
        <flux:button>Awaw</flux:button>
        <flux:menu>
            <flux:menu.item icon="plus">New post</flux:menu.item>
            <flux:menu.radio.group>

                @foreach (\Modules\ClientManagement\Models\Status::all() as $statusRef)
                    <flux:menu.radio> awaw </flux:menu.radio>
                @endforeach
            </flux:menu.radio.group>
        </flux:menu>
    </flux:dropdown> --}}

    <x-mary-select
        class="!outline-none"
        label='Main Company Status'
        wire:model='status'
        :options='$options'
        icon="o-user"
    />

    <x-mary-button label='Save' wire:click='save' />

    <p>Main Company: {{ $sampleComp->statusName }}</p>

    <div class="flex flex-col">
        @foreach ($sampleComp->branches as $sampleBranch)
            <p>{{$sampleBranch->branch_name}}: {{ $sampleBranch->statusName }}</p>
        @endforeach
    </div>
</div>
