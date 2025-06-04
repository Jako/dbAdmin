<?php
/**
 * Set the class names for all tables
 *
 * @package dbadmin
 * @subpackage processors
 */

use Sergant210\dbAdmin\Processors\ObjectGetListProcessor;

/**
 * Class dbAdminSetClassesProcessor
 */
class dbAdminSetClassesProcessor extends ObjectGetListProcessor
{
    public $objectType = 'dbadmin.table';
    public $classKey = 'dbAdminTable';
    public $primaryKeyField = 'name';
    public $permission = 'table_save';

    /**
     * {@inheritDoc}
     * @return bool
     */
    public function beforeQuery()
    {
        $this->setProperty('limit', 0);

        return parent::beforeQuery();
    }

    public function prepareRow(xPDOObject $object)
    {
        $name = str_replace($this->modx->config['table_prefix'], '', $object->get('name'));
        $package = $object->get('package');
        if (empty($package)) {
            /** @var modNamespace[] $namespaces */
            $namespaces = $this->modx->getIterator('modNamespace');
            foreach ($namespaces as $namespace) {
                $package = $namespace->get('name');
                try {
                    $class = $this->dbadmin->database->getPackageClass($package, $name);
                    if ($class) {
                        break;
                    }
                } catch (Exception $e) {
                }
            }
            if (!$class) {
                foreach (['modx', 'modx.sources', 'modx.registry.db', 'modx.transport'] as $package) {
                    try {
                        $class = $this->dbadmin->database->getPackageClass($package, $name);
                        if ($class) {
                            break;
                        }
                    } catch (Exception $e) {
                    }
                }
                if (!$class) {
                    $package = '';
                    $class = '';
                }
            }
        } else {
            try {
                $class = $this->dbadmin->database->getPackageClass($package, $name);
            } catch (Exception $e) {
            }
        }
        if ($class) {
            $object->set('package', $package);
            $object->set('class', $class);
            $object->save();

            $this->modx->log(xPDO::LOG_LEVEL_INFO, $this->modx->lexicon('dbadmin.set_class_message', [
                'table' => $name,
                'package' => $package,
                'class' => $class,
            ]));
        }

        return $object->toArray();
    }

    /**
     * {@inheritDoc}
     * @return string
     */
    public function outputArray(array $array, $count = false)
    {
        $this->modx->log(xPDO::LOG_LEVEL_INFO, 'COMPLETED');

        return '';
    }
}

return 'dbAdminSetClassesProcessor';
