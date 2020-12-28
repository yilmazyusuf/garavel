<?php

namespace Garavel\Eloquent;

trait  Mutators {

    /**
     * Get labeled status
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        return self::activeOrPassiveLabel($this->status);
    }

    /**
     * Get labeled is tmd auth
     *
     * @return string
     */
    public function getIsTmdAuthLabelAttribute()
    {
        return self::activeOrPassiveLabel($this->is_tmd_auth);
    }


    public static function activeOrPassiveLabel(int $isActive)
    {
        $statusLabels[0] = ['class' => 'text-danger', 'label' => 'Pasif'];
        $statusLabels[1] = ['class' => 'text-success', 'label' => 'Aktif'];

        if (isset($statusLabels[$isActive]))
        {
            $labeled = $statusLabels[$isActive];

            return "<p class='" . $labeled['class'] . " p-0 m-0' >" . $labeled['label'] . "</p>";
        }

        return $isActive;
    }

    public function getBtnActionAttribute()
    {
        return '<a class="btn btn-default btn-sm btn-light" href="#"><i class="fa fa-edit"></i></a>';
    }

}
