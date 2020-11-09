<?php

namespace App\Traits;

use App\Models\Tenant;
use App\Scopes\TenantScope;

trait BelongsToTenant {

	// Utilizamos a trait BelongsToTenant
	// para definirmos regras de negócio 
	// específicas para modelos que necessitam 
	// herdar as regras de ter um Tenant associado 
	// a ele. Alterando o nome bootBelongsToTenant 
    // garante que não iremos sobrescrever a função 
    // principal do nosso model. 
	protected static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function($model) {
            if ( session()->has('tenant_id')) {
                $model->tenant_id = session()->get('tenant_id');
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

}