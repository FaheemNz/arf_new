<?php

namespace App\Widgets;

use App\Models\Desktop;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;

class Desktops extends AbstractWidget
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
        $count = Desktop::count();
        $string = 'Desktops';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-photos',
            'title'  => "{$count} {$string}",
            'text'   => __('voyager::dimmer.post_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => 'Desktops',
                'link' => '/admin/desktops',
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
