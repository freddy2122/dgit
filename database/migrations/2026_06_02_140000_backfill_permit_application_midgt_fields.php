<?php

use App\Models\PermitApplication;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('permit_applications', 'requested_category')) {
            return;
        }

        PermitApplication::query()
            ->with('user.licenseSummary')
            ->whereNull('requested_category')
            ->orderBy('id')
            ->chunkById(100, function ($applications) {
                foreach ($applications as $application) {
                    $category = $application->displayRequestedCategory($application->user?->licenseSummary);
                    if ($category === null) {
                        continue;
                    }

                    $application->update(['requested_category' => $category]);
                }
            });
    }

    public function down(): void
    {
        // Données de repli optionnelles : pas de rollback destructif.
    }
};
