<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\MedicalFile;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Policies\UserPolicy;
use App\Policies\MedicalFilePolicy;
use App\Policies\InvoicePolicy;
use App\Policies\PaymentPolicy;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        MedicalFile::class => MedicalFilePolicy::class,
        Invoice::class => InvoicePolicy::class,
        Transaction::class => PaymentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();


        Gate::define('view', [InvoicePolicy::class, 'view']);
    }
}
