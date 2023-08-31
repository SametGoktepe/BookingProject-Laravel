<?php

namespace App\Http\Services\Interfaces;

interface IHotel
{
    public function getHotels();
    public function getHotelById($hotel_id);
}
