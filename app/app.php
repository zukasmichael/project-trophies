<?php

use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Neutron\Silex\Provider\MongoDBODMServiceProvider;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Svnfqt\ProjectTrophies\Security\User\UserProvider;
use Svnfqt\ProjectTrophies\Form\RegisterType;
use Svnfqt\ProjectTrophies\Form\LoginType;

$autoloader = require_once __DIR__.'/../vendor/autoload.php';

// Constants
define('APP_PATH', __DIR__);

// App
$app = new Silex\Application();

// Config
$app['locale'] = 'fr';

// Providers
$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => APP_PATH . '/logs/development.log'
));
$app->register(new SessionServiceProvider());
$app->register(new SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'register' => array(
            'pattern' => '^/register$',
            'anonymous' => true
        ),
        'login' => array(
            'pattern' => '^/login$',
            'anonymous' => true
        ),
        'secured' => array(
            'pattern' => '^.*$',
            'form' => array(
                'login_path' => '/login',
                'check_path' => '/login_check'
            ),
            'logout' => array('logout_path' => '/logout'),
            'users' => $app->share(function () use ($app) {
                return $app['project-trophies.security.user_provider'];
            })
        )
    )
));
$app->register(new TranslationServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new TwigServiceProvider(), array(
    'twig.path' => APP_PATH . '/Resources/views'
));
$app->register(new MongoDBODMServiceProvider(), array(
    'doctrine.odm.mongodb.connection_options' => array(
        'database' => 'project-trophies',
        'host'     => 'localhost'
    ),
    'doctrine.odm.mongodb.documents' => array(
        0 => array(
            'type' => 'annotation',
            'path' => array(
                APP_PATH . '/../src/Svnfqt/ProjectTrophies',
            ),
            'namespace' => 'Svnfqt\\ProjectTrophies'
        ),
    ),
    'doctrine.odm.mongodb.proxies_dir'             => APP_PATH . '/cache/doctrine/odm/mongodb/Proxy',
    'doctrine.odm.mongodb.proxies_namespace'       => 'DoctrineMongoDBProxy',
    'doctrine.odm.mongodb.auto_generate_proxies'   => true,
    'doctrine.odm.mongodb.hydrators_dir'           => APP_PATH . '/cache/doctrine/odm/mongodb/Hydrator',
    'doctrine.odm.mongodb.hydrators_namespace'     => 'DoctrineMongoDBHydrator',
    'doctrine.odm.mongodb.auto_generate_hydrators' => true,
    'doctrine.odm.mongodb.metadata_cache'          => new \Doctrine\Common\Cache\ArrayCache()
));

// Configure doctrine
AnnotationRegistry::registerLoader(array($autoloader, 'loadClass'));

// Configure odm
$app['doctrine.odm.mongodb.dm']->getSchemaManager()->ensureIndexes();

// Configure twig
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    // Extensions
    $twig->addExtension(new Twig_Extensions_Extension_Intl());

    // Global vars
    $twig->addGlobal('layout', $twig->loadTemplate('layout.twig'));

    return $twig;
}));

// Services
$app['project-trophies.forms.register'] = function () {
    return new RegisterType();
};
$app['project-trophies.forms.login'] = function () {
    return new LoginType();
};
$app['project-trophies.security.user_provider'] = $app->share(function ($app) {
    return new UserProvider($app['doctrine.odm.mongodb.dm']);
});

// Homepage
$app->get('/', function () use ($app) {
    return $app['twig']->render('homepage.twig');
})
->bind('homepage');

// Register
$app->match('/register', function(Request $request) use ($app) {
    $form = $app['form.factory']->create($app['project-trophies.forms.register']);

    if ('POST' == $request->getMethod()) {
        $form->bind($request);

        if ($form->isValid()) {
            $user = $form->getData();

            // Encode plain password
            $encoder = $app['security.encoder_factory']->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);

            if (false !== ($app['project-trophies.security.user_provider']->persistUser($user))) {
                return $app->redirect($app['url_generator']->generate('login'));
            }

            $app['session']->getFlashBag()->add('error', 'L\'enregistrement a échoué. Veuillez réessayer.');
        } else {
            $app['session']->getFlashBag()->add('notice', 'Le formulaire n\'est pas valide.');
        }
    }

    return $app['twig']->render('register.twig', array(
        'form' => $form->createView()
    ));
})
->bind('register');

// Login
$app->get('/login', function(Request $request) use ($app) {
    if (null !== ($lastError = $app['security.last_error']($request))) {
        $app['session']->getFlashBag()->add('error', $lastError);
    }

    $form = $app['form.factory']->create(
        $app['project-trophies.forms.login'],
        array(
            '_username' => $app['session']->get('_security.last_username')
        )
    );

    return $app['twig']->render('login.twig', array(
        'form' => $form->createView()
    ));
})
->bind('login');

return $app;
