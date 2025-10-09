<?php

namespace App\View\Composers;

use App\Models\ContactDetail;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class ContactDetailsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $contacts = Cache::remember('active_contact_details', 3600, function () {
            return ContactDetail::active()->ordered()->get();
        });

        $view->with('contactDetails', $contacts);
    }
}
