@section('title', 'Registre-se!')

<div>
    <div class="min-h-screen bg-white flex">
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm">
                <div>
                    <img class="h-12 w-auto" src="{{ asset('svgs/logo.svg') }}" alt="Workflow" />
                    <h2 class="mt-6 text-3xl leading-9 font-extrabold text-gray-900">
                        Preparado para começar?
                    </h2>
                </div>

                <div class="mt-8">
                    <div class="mt-6">
                        <form wire:submit.prevent="register">

                            <!--
                                Utilizamos o debounce para não enviar 
                                requisições até que o usuário realmente termine 
                                de digitar as informações. Para isso utilizamos o 
                                "attributes bag" em nosso Registro.php
                            -->

                            <x-text-input
                                wire:model.debounce.100ms="name" 
                                type="text" label="Nome completo" :required="true" placeholder="Qual seu nome completo?" class="mt-4" />
                            <x-text-input
                                wire:model.debounce.100ms="companyName" 
                                type="text" label="Empresa" :required="true" placeholder="Digite a razão social" class="mt-4" />
                            <x-text-input
                                wire:model.debounce.100ms="email" 
                                type="email" label="E-mail" :required="true" placeholder="dominio@dominio.com.br" class="mt-4" />
                            <x-text-input
                                wire:model.debounce.100ms="password"
                                type="password" label="Senha" :required="true" placeholder="" class="mt-4" />
                            <small class="block mt-2 text-gray-500 text-xs">
                                - Utilize senhas fortes;<br>
                                - Mínimo de 8 caractéres;<br>
                                - Utilize letras e números;
                            </small>

                            <div class="mt-6">
                                <span class="block w-full rounded-md shadow-sm">
                                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                        Registrar-se!
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden lg:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1505904267569-f02eaeb45a4c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80" alt="" />
        </div>
    </div>
</div>
