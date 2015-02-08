# SimpleMVC

### Needs change
* Easy change of the default controller

### Illuminate Database
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
  'driver' => 'mysql',

  // Setup connection
  'host' => 'skemax.com.mysql',
  'database' => 'skemax_com',
  'username' => 'skemax_com',
  'password' => '7cba624f7c1',

  // DB settings
  'charset' => 'utf8',
  'collation' => 'utf8_unicode_ci',
  'prefix' => '',
]);

$capsule->bootEloquent();
