<?php
declare(strict_types=1);

namespace App\Form\Api\Sample;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class SampleForm extends Form
{
    /**
     * @param \Cake\Form\Schema $schema schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField('title', ['type' => 'string'])
            ->addField('content', ['type' => 'text']);
    }

    /**
     * @param \Cake\Validation\Validator $validator validator
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator->requirePresence('title', true)
            ->notEmptyString('title')
            ->maxLength('title', 20)
            ->maxLength('content', 50);

        return $validator;
    }
}
