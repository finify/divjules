<?php

if (!function_exists('contact')) {
    /**
     * Get contact detail by key
     *
     * @param string $key The contact detail key
     * @param string $attribute Optional attribute to return (value, link, label, etc)
     * @return mixed
     */
    function contact(string $key, string $attribute = 'value')
    {
        static $contacts = null;

        if ($contacts === null) {
            $contacts = \Illuminate\Support\Facades\Cache::remember('contact_details_helper', 3600, function () {
                return \App\Models\ContactDetail::active()->ordered()->get()->keyBy('key');
            });
        }

        $contact = $contacts->get($key);

        if (!$contact) {
            return null;
        }

        return match($attribute) {
            'value' => $contact->value,
            'label' => $contact->label,
            'link' => $contact->link,
            'icon' => $contact->icon,
            'type' => $contact->type,
            'formatted' => $contact->formatted_value,
            default => $contact->$attribute ?? null,
        };
    }
}

if (!function_exists('contact_all')) {
    /**
     * Get all active contact details
     *
     * @return \Illuminate\Support\Collection
     */
    function contact_all()
    {
        return \Illuminate\Support\Facades\Cache::remember('all_contact_details', 3600, function () {
            return \App\Models\ContactDetail::active()->ordered()->get();
        });
    }
}
