<?

$_SERVER['argv'];

switch ($_SERVER['argv'][1]) {
    case 'migrate':
        require_once 'vendor\framework\database\migration\migration.php';
        break;
    default:
        echo 'Command not found';
        break;
}