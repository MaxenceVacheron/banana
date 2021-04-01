<?php

namespace ContainerXjNLwBV;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolderd7c03 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializera7259 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesaae24 = [
        
    ];

    public function getConnection()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'getConnection', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'getMetadataFactory', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'getExpressionBuilder', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'beginTransaction', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->beginTransaction();
    }

    public function getCache()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'getCache', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->getCache();
    }

    public function transactional($func)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'transactional', array('func' => $func), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->transactional($func);
    }

    public function commit()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'commit', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->commit();
    }

    public function rollback()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'rollback', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'getClassMetadata', array('className' => $className), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'createQuery', array('dql' => $dql), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'createNamedQuery', array('name' => $name), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'createQueryBuilder', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'flush', array('entity' => $entity), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'clear', array('entityName' => $entityName), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->clear($entityName);
    }

    public function close()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'close', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->close();
    }

    public function persist($entity)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'persist', array('entity' => $entity), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'remove', array('entity' => $entity), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'refresh', array('entity' => $entity), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'detach', array('entity' => $entity), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'merge', array('entity' => $entity), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'getRepository', array('entityName' => $entityName), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'contains', array('entity' => $entity), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'getEventManager', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'getConfiguration', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'isOpen', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'getUnitOfWork', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'getProxyFactory', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'initializeObject', array('obj' => $obj), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'getFilters', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'isFiltersStateClean', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'hasFilters', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return $this->valueHolderd7c03->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializera7259 = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolderd7c03) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolderd7c03 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolderd7c03->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, '__get', ['name' => $name], $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        if (isset(self::$publicPropertiesaae24[$name])) {
            return $this->valueHolderd7c03->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderd7c03;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolderd7c03;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, '__set', array('name' => $name, 'value' => $value), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderd7c03;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolderd7c03;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, '__isset', array('name' => $name), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderd7c03;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolderd7c03;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, '__unset', array('name' => $name), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderd7c03;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolderd7c03;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, '__clone', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        $this->valueHolderd7c03 = clone $this->valueHolderd7c03;
    }

    public function __sleep()
    {
        $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, '__sleep', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;

        return array('valueHolderd7c03');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializera7259 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializera7259;
    }

    public function initializeProxy() : bool
    {
        return $this->initializera7259 && ($this->initializera7259->__invoke($valueHolderd7c03, $this, 'initializeProxy', array(), $this->initializera7259) || 1) && $this->valueHolderd7c03 = $valueHolderd7c03;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolderd7c03;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolderd7c03;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
