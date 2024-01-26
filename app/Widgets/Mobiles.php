<?php

namespace App\Widgets;

use App\Models\Mobile;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;

class Mobiles extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Mobile::count();
        $string = 'Mobiles';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-telephone',
            'title'  => "{$count} {$string}",
            'text'   => __('voyager::dimmer.post_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => 'Mobiles',
                'link' => '/admin/mobiles',
            ],
            'image' => voyager_asset('images/widget-backgrounds/03.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return true;
    }
}
