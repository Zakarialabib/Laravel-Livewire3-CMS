<?php

declare(strict_types=1);

namespace App\Livewire\Utils;

use Livewire\Attributes\Computed;
use App\Models\{PageSetting, Partner, Section, Service, Slider};

trait WithModels
{
    public $perPage = 4;

    #[Computed]
    public function services()
    {
        return Service::active()->take($this->perPage)->get();
    }

    #[Computed]
    public function sliders()
    {
        return Slider::active()->take($this->perPage)->get();
    }

    #[Computed]
    public function partners()
    {
        return Partner::active()->take($this->perPage)->get();
    }

    public function getPageConfig($pageId)
    {
        return PageSetting::where('page_id', $pageId)->first();
    }

    public function getServiceConfig($serviceId)
    {
        return PageSetting::where('service_id', $serviceId)->first();
    }

    public function getPageTypeConfig($type)
    {
        return PageSetting::where('page_type', $type)->first();
    }

    public function getSectionByType($type)
    {
        return Section::where('type', $type)->active()->first();
    }
}
