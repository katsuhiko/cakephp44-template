<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Samples Model
 *
 * @method \App\Model\Entity\Sample newEmptyEntity()
 * @method \App\Model\Entity\Sample newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Sample[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sample get($primaryKey, $options = [])
 * @method \App\Model\Entity\Sample findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Sample patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Sample[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sample|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sample saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sample[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Sample[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Sample[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Sample[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SamplesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('samples');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('title')
            ->maxLength('title', 40)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('content')
            ->requirePresence('content', 'create')
            ->notEmptyString('content');

        return $validator;
    }
}
