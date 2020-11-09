@props([
	'type' => 'text', 
	'label' => '', 
	'required' => false, 
	'placeholder' => '', 
])

<div class="{{ $attributes->get('class') }}">
    <label for="{{ $attributes->whereStartsWith('wire:model')->first() }}"
           class="block text-sm font-medium leading-5 text-gray-700">{{ $label }}
    </label>
    <div class="mt-1 relative rounded-md shadow-sm">

    	<!--
			Utilizando a bag "attributes" para verificar 
			quais os parâmetros informados no nosso componente.
			Utilizando a função whereStartsWith, podemos 
			pegar o model associado a esse componente (wire:model), 
			mas também garantimos que tudo funcione caso seja 
			necessário aplicar uma propriedade a esse atributos, 
			por exemplo: wire:model.lazy ou wire:model.debound.100ms
    	-->

        <input
            {{ $attributes->whereStartsWith('wire:model') }}
            id="{{ $attributes->whereStartsWith('wire:model')->first() }}"
            type="{{ $type }}"
            required="{{ $required }}"
            @error($attributes->whereStartsWith('wire:model')->first())
            	class="form-input block w-full pr-10 border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red sm:text-sm sm:leading-5"
            @else
            	class="form-input block w-full sm:text-sm sm:leading-5"
            @endif
            placeholder="{{ $placeholder }}"
            @error($attributes->whereStartsWith('wire:model')->first())
            aria-invalid="true"
            aria-describedby="email-error"
            @enderror
        />
        @error($attributes->whereStartsWith('wire:model')->first())
            <div wire:key="error_svg_{{ $attributes->whereStartsWith('wire:model')->first() }}"
                 class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
        @enderror
    </div>
    @error($attributes->whereStartsWith('wire:model')->first())
    	<!--
    		Utilizamos o wire:key pois caso o nosso 
    		formulário apresente algum erro, ele será 
    		exibido no DOM, logo abaixo do input problemátoc, 
    		e não será removido caso o usuário comece a digitar 
    		um novo valor no input. Aplicando um wire:key com 
    		uma chave ÚNICA, resolve este problema.
    	-->
        <p wire:key="error_{{ $attributes->whereStartsWith('wire:model')->first() }}" class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
        </p>
    @enderror
</div>