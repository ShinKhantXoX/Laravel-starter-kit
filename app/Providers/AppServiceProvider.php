<?php

namespace App\Providers;

use App\Enums\TokenAbility;
use App\Helpers\QueryBuilderHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(255);

        $this->registerBlueprintMacros();
        $this->registerQueryBuilderMacros();
        $this->overrideSanctumConfigurationToSupportRefreshToken();
    }

    private function overrideSanctumConfigurationToSupportRefreshToken(): void
    {
        Sanctum::$accessTokenAuthenticationCallback = function ($accessToken, $isValid) {
            $abilities = collect($accessToken->abilities);
            if (!empty($abilities) && $abilities[0] === TokenAbility::ISSUE_ACCESS_TOKEN->value) {
                return $accessToken->expires_at && $accessToken->expires_at->isFuture();
            }

            return $isValid;
        };

        Sanctum::$accessTokenRetrievalCallback = function ($request) {
            if (!$request->routeIs('refresh')) {
                return str_replace('Bearer ', '', $request->headers->get('Authorization'));
            }

            return $request->cookie('refreshToken') ?? '';
        };
    }

    private function registerBlueprintMacros()
    {
        Blueprint::macro('snowflakeId', fn($column = 'id') => $this->unsignedBigInteger($column));
        Blueprint::macro('snowflakeIdAndPrimary', fn($column = 'id') => $this->snowflakeId($column)->primary());

        Blueprint::macro('auditColumns', function () {
            // $this->snowflakeId('created_by')->nullable();
            // $this->snowflakeId('updated_by')->nullable();
            // $this->snowflakeId('deleted_by')->nullable();
            $this->timestamps();
            $this->softDeletes();

            return $this;
        });
    }

    private function registerQueryBuilderMacros()
    {
        Builder::macro('sortingQuery', function () {
            return QueryBuilderHelper::sortingQuery($this);
        });

        Builder::macro('searchQuery', function () {
            return QueryBuilderHelper::searchQuery($this);
        });

        Builder::macro('paginationQuery', function () {
            return QueryBuilderHelper::paginationQuery($this);
        });

        Builder::macro('filterQuery', function () {
            return QueryBuilderHelper::filterQuery($this);
        });

        Builder::macro('filterDateQuery', function () {
            return QueryBuilderHelper::filterDateQuery($this);
        });
    }
}
