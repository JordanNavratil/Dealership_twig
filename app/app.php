<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/car.php";

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    /* CAR_FORM.HTML - Home route */

    $app->get("/", function() use ($app) {

        return $app['twig']->render('car_form.html.twig');

    });

    /* END CAR_FORM.HTML */

    $app->get("/view_car", function() {
        $porsche = new Car("2014 Porsche 911", 114991, 7861, "images/porsche.jpg");
        $ford = new Car("2011 Ford F450", 55995, 14241, "images/ford.jpg");
        $lexus = new Car("2013 Lexus RX 350", 44700, 20000, "images/lexus.jpg");
        $mercedes = new Car("Mercedes Benz CLS550", 39900, 37979, "images/mercedes.jpg");

        $cars = array($porsche, $ford, $lexus, $mercedes);

        $cars_matching_search = array();
        foreach ($cars as $car) {
            if ($car->worthBuying($_GET["price"]) && ($car->worthBuying($_GET["miles"]))) {
                array_push($cars_matching_search, $car);
            }
        }
        $output = "";

        $output = $output . "<!DOCTYPE html>
            <html>
            <head>
                <title>Your Car Dealership's Homepage</title>
                <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
            </head>
            <body>
                <div class='container'>
                    <h1>Your Car Dealership</h1>
                    ";

            if (empty($cars_matching_search)) {
                $output = $output . "<p>Sorry, there are no cars available.</p>";
            } else {
                foreach ($cars_matching_search as $car) {
                    $car_make = $car->getMake();
                    $car_price = $car->getPrice();
                    $car_miles = $car->getMiles();

                    $output = $output . "<li><img class='img-rounded' src='$car->make_photo'></li>";
                    $output = $output . "<li> $car_make </li>";
                    $output = $output . "<ul>";
                        $output = $output . "<li> $car_price </li>";
                        $output = $output . "<li> Miles: $car_miles </li>";
                    $output = $output ."</ul>";

                }
            }

            $output = $output . "
                     </div>
                </body>
                </html>
            ";
        return $output;
    });

    return $app;

?>
