<?php
    class Car
    {
        private $make_model;
        private $make_price;
        private $make_miles;
        private $make_photo;

        function __construct($car_make, $car_price, $car_miles, $car_photo)
        {
            $this->make_model = $car_make;
            $this->make_price = $car_price;
            $this->make_miles = $car_miles;
            $this->make_photo = $car_photo;
        }
        function setMake($new_make)
        {
            $model = (string) $new_make;
        }

        function getMake()
        {
            return $this->make_model;
        }

        function setPrice($new_price)
        {
            $price = (float) $new_price;
        }

        function getPrice()
        {
            return $this->make_price;
        }

        function setMiles($new_miles)
        {
            $miles = (float) $new_miles;
        }

        function getMiles()
        {
            return $this->make_miles;
        }

        function setPhoto()
        {
            $photo = (string) $new_photo;
        }

        function getPhoto()
        {
            return $this->make_photo;
        }

        function worthBuying($max_price)
        {
            return $this->make_price < ($max_price + 100);
        }

        function save()
        {
            array_push($_SESSION['list_of_cars'], $this);
        }

        static function getAll()
        {
            return $_SESSION['list_of_cars'];
        }

    }
?>
