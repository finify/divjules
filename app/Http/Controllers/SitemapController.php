<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\University;
use Firefly\FilamentBlog\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = collect([
            [route('home.index'), now(), '1.0'],
            [route('home.universities'), now(), '0.9'],
            [route('home.courses'), now(), '0.9'],
            [route('home.about'), null, '0.6'],
            [route('home.blog'), now(), '0.7'],
            [route('home.contact'), null, '0.7'],
            [route('home.apply'), null, '0.8'],
            [route('home.reviews'), null, '0.5'],
        ]);

        University::active()->select('slug', 'updated_at')->get()
            ->each(fn ($u) => $urls->push([route('universities.show', $u->slug), $u->updated_at, '0.8']));
        Course::active()->select('slug', 'updated_at')->get()
            ->each(fn ($c) => $urls->push([route('courses.show', $c->slug), $c->updated_at, '0.7']));

        try {
            Post::where('status', 'published')->select('slug', 'updated_at')->get()
                ->each(fn ($p) => $urls->push([route('blog.show', $p->slug), $p->updated_at, '0.6']));
        } catch (\Throwable $e) {
            // blog tables may not exist yet on a fresh install
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls as [$loc, $lastmod, $priority]) {
            $xml .= '<url><loc>' . e($loc) . '</loc>'
                . ($lastmod ? '<lastmod>' . $lastmod->toAtomString() . '</lastmod>' : '')
                . '<priority>' . $priority . '</priority></url>';
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
