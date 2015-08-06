<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/car.php";

    session_start();

    $porsche = new Car("2014 Porsche 911", 114991, 7861, "images/porsche.jpg");
    $ford = new Car("2011 Ford F450", 55995, 14241, "images/ford.jpg");
    $lexus = new Car("2013 Lexus RX 350", 44700, 20000, "images/lexus.jpg");
    $mercedes = new Car("Mercedes Benz CLS550", 39900, 37979, "images/mercedes.jpg");

    if (empty($_SESSION['list_of_cars'])) {
        $_SESSION['list_of_cars'] = array($porsche, $ford, $lexus, $mercedes);
    }

    $app = new Silex\Application();


    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    /* CAR_FORM.HTML.TWIG - Home route */

    $app->get("/", function() use ($app) {

        return $app['twig']->render('car_form.html.twig', array('cars' => Car::getAll()));

    });

    /* END CAR_FORM.HTML.TWIG */

    /* START VIEW_CAR.HTML.TWIG */

    $app->get("/view_car", function() use ($app) {


        $cars = Car::getAll();

        $cars_matching_search = array();
        foreach ($cars as $car) {
            if ($car->worthBuying($_GET["price"]) && ($car->worthBuying($_GET["miles"]))) {
                array_push($cars_matching_search, $car);
            }
        }

        return $app['twig']->render('view_car.html.twig', array('cars' => $cars_matching_search));

    });

    /* END VIEW_CAR.HTML.TWIG */

    /* BEGIN SELL_CAR.HTML.TWIG */

    $app->get("/sell_car", function() use ($app) {

        return $app['twig']->render('sell_car.html.twig');
    });

    $app->post("/car_added", function() use ($app) {

        $car = new Car($_POST['make'], $_POST['price'], $_POST['miles'], $_POST['photo']);
        $car->save();

        return $app['twig']->render('car_added.html.twig', array('newcar' => $car));
    });

    /* END SELL_CAR.HTML.TWIG */

    return $app;

?>
