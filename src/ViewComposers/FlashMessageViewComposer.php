<?php
/**
 *
 *
 * @category
 * @package
 * @author yusuf.yilmaz
 * @since  : 30.01.2020
 */

namespace Garavel\ViewComposers;

use Illuminate\View\View;

class FlashMessageViewComposer {


    const MESSAGE_SUCCESS = 'success';
    const MESSAGE_WARNING = 'warning';
    const MESSAGE_INFO = 'info';
    const MESSAGE_DANGER = 'danger';


    private $hasFlashMessage = false;
    private $messageClass = 'success';
    private $message = '';


    /**
     * FlashMessageViewComposer constructor.
     * @todo Multiple Flash Message Support
     */
    public function __construct()
    {
        $this->hasFlashMessage();
    }


    public function compose(View $view)
    {
        if ($this->hasFlashMessage)
        {
            $data = [
                'class'   => $this->messageClass,
                'message' => $this->message,
            ];
            $template = view()->make('adminlte::partials.flash_message', $data)->render();
            $view->with('flashMessage', $template);
        }

    }

    private function hasFlashMessage()
    {
        $sessionKeys = [
            self::MESSAGE_SUCCESS,
            self::MESSAGE_WARNING,
            self::MESSAGE_DANGER,
            self::MESSAGE_INFO,
        ];

        foreach ($sessionKeys as $key)
        {
            if (request()->session()->has($key))
            {
                $this->hasFlashMessage = true;
                $this->messageClass = $key;
                $this->message = request()->session()->get($key);
            }
        }

    }
}
