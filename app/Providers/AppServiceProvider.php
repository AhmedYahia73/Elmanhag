<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Gate;

use App\Models\User;

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
        
        // 'revisions', 'exams', 'pop up', 'reviews',
        // '', 'support', 'reports', 'notice board'
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        // if roles have student module
        Gate::define('isStudent', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('students', $arr)) {
                        return true;
                    }
                }
            }
        });

        // if roles have teachers module
        Gate::define('isTeachers', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('teachers', $arr)) {
                        return true;
                    }
                }
            }
        });

        // if roles have admins module
        Gate::define('isAdmins', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('admins', $arr)) {
                        return true;
                    }
                }
            }
        });

        // if roles have categories module
        Gate::define('isCategories', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('categories', $arr)) {
                        return true;
                    }
                }
            }
        });

        // if roles have subjects module
        Gate::define('isSubjects', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('subjects', $arr)) {
                        return true;
                    }
                }
            }
        });

        // if roles have bundles module
        Gate::define('isBundles', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('bundles', $arr)) {
                        return true;
                    }
                }
            }
        });

        // if roles have questions module
        Gate::define('isQuestions', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('questions', $arr)) {
                        return true;
                    }
                }
            }
        });

        // if roles have hw module
        Gate::define('isHw', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('hw', $arr)) {
                        return true;
                    }
                }
            }
        });

        // if roles have live module
        Gate::define('isLive', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('live', $arr)) {
                        return true;
                    }
                }
            }
        });

        // if roles have discounts module
        Gate::define('isDiscounts', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('discounts', $arr)) {
                        return true;
                    }
                }
            }
        });

        // if roles have promocode module
        Gate::define('isPromocode', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('promocode', $arr)) {
                        return true;
                    }
                }
            }
        });

        // if roles have promocode module
        Gate::define('isPromocode', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('promocode', $arr)) {
                        return true;
                    }
                }
            }
        });

        // if roles have affilate module
        Gate::define('isAffilate', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('affilate', $arr)) {
                        return true;
                    }
                }
            }
        });
        
        // if roles have settings module
        Gate::define('isSettings', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('settings', $arr)) {
                        return true;
                    }
                }
            }
        });
        // if roles have payments module
        Gate::define('isPayments', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('payments', $arr)) {
                        return true;
                    }
                }
            }
        });
        
        // if roles have chapters module
        Gate::define('isChapters', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('chapters', $arr)) {
                        return true;
                    }
                }
            }
        });
        
        // if roles have lessons module
        Gate::define('isLessons', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('lessons', $arr)) {
                        return true;
                    }
                }
            }
        });
        
        // if roles have admin_roles module
        Gate::define('isAdminRoles', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('admin_roles', $arr)) {
                        return true;
                    }
                }
            }
        });
        
        // if roles have admin_roles module
        Gate::define('isComplaint', function (User $user) {
            if ( $user->role == 'supAdmin' ) {
                return true;
            }
            elseif ( $user->role == 'admin' ) {
                if (isset($user->admin_position->roles)) {
                    $arr = $user->admin_position->roles->pluck('role')->toArray();
                    if (in_array('complaint', $arr)) {
                        return true;
                    }
                }
            }
        });

    }
}
