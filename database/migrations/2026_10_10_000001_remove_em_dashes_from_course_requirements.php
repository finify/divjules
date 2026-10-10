<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * The starter catalogue seeded a requirement line containing an em dash
 * ("Updated CV — relevant work experience is an advantage"). Rewrite it to match
 * the updated seeder copy.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('courses')->where('entry_requirements', 'like', '%Updated CV%')->orderBy('id')
            ->each(function ($course) {
                $reqs = json_decode($course->entry_requirements, true);
                if (! is_array($reqs)) {
                    return;
                }
                $reqs = array_map(fn ($r) => is_string($r)
                    ? str_replace('Updated CV — relevant work experience is an advantage', 'Updated CV (relevant work experience is an advantage)', $r)
                    : $r, $reqs);
                DB::table('courses')->where('id', $course->id)->update(['entry_requirements' => json_encode($reqs)]);
            });
    }

    public function down(): void
    {
        //
    }
};
