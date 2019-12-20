<?php

namespace Statamic\Addons\LangUrl;

use Statamic\Contracts\Data\Content\Content;
use Statamic\Extend\Tags;
use Statamic\API\URL;
use Statamic\API\Data;


class LangUrlTags extends Tags
{
    /**
     * The {{ lang_url }} tag
     *
     * @return string|array
     */
    public function index()
    {
        $context = $this->context;

        // target locale
        $locale = $this->getParam('locale', 'default');
        if ($locale == 'default') {
            $locale = default_locale();
        }

        /** @var Content $content */
        $content = !empty($context["id"]) ? Data::find($context["id"]) : null;
        if ($content) {
            // set the locale on the object
            $content->locale($locale);

            // return localized url
            return $content->url();
        }

        // generate url to front page if no page or entry is in the context
        return URL::prependSiteUrl('/', $locale);
    }
}
