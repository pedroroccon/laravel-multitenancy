<?php

namespace App\Traits;

use App\Scopes\TenantScope;

trait HasTenant {

	// Utilizamos a trait HasTenant
	// para definirmos regras de negócio 
	// específicas para modelos que necessitam 
	// herdar as regras de ter um Tenant associado 
	// a ele.

	protected static function booted()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function($model) {
            if ( session()->has('tenant_id')) {
                $model->tenant_id = session()->get('tenant_id');
            }
        });
    }

}