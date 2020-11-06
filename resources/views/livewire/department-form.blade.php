<div>
    <input wire:model="name" type="text" />
    <button wire:click="submit">Cadastrar</button>

    @if ($success)
    	<div>Salvo!</div>
    @endif
</div>
